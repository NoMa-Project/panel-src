<?php

namespace App\Console\Commands;

use App\Models\Node;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateNodesStatus extends Command
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
    protected $description = 'Update node status';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $nodes = Node::where("installed", false)->get();

        foreach ($nodes as $node) {
            try {
                $response = Http::get("http://" . $node->ip . ":5000");

                if ($response->successful()) {
                    $node->installed = true;
                    $node->save();
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
