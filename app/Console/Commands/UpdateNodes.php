<?php

namespace App\Console\Commands;


use Exception;
use App\Models\Node;
use App\Models\Datas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateNodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:nodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("Fetching datas ...");

        foreach (Node::where("installed", true)->get() as $node) {
            try {
                $response = Http::post('http://' . $node->ip . ':3000/statistics', [
                    'token' => $node->token,
                ]);
        
                if ($response->successful()) {
                    $responseData = $response->json();
                    if ($responseData['token'] === $node->token) {
                        $node->uptime = $responseData['uptime'];
    
                        $data = new Datas([
                            'maxCpu' => $responseData['cpu']['maxCpu'],
                            'cpuUsage' => $responseData['cpu']['cpuUsage'],
                            'maxRam' => $responseData['ram']['maxRam'],
                            'ramUsage' => $responseData['ram']['ramUsage'],
                        ]);
    
                        $node->datas()->save($data);
                        $this->info('Done for node ' . $node->id);
                    }
                } else {
                    $node->installed = false;
                    $node->save();
                    $this->info('Promblem with node ' . $node->id);
                }
            } catch (Exception $e) {
                $this->info('Promblem with node ' . $node->id . " " . $e);
                $node->error = date("d/m/y H:i:s") . " Error during binding the node! Can't ping it !";
                $node->save;
            }
        }
    }
}
