<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("node.index", [
            "nodes" => Node::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("node.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "ip" => "required",
        ]);

        $node = Node::create([
            "name" => $request->input("name"),
            "ip" => $request->input("ip"),
            "token" => bin2hex(random_bytes(16)),
        ]);

        $node->error = $this->sendHeartbeat($node);
        $node->save;

        return redirect()->route("node.index")->with("success", "Node created");
    }

     /**
     * Show the specified resource.
     */
    public function show(Node $node)
    {
        return view("node.show", [
            "node" => $node
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Node $node)
    {
        return view("node.edit", [
            "node" => $node
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Node $node)
    {
        $node->installed = false;
        $node->save();
        
        $request->validate([
            "name" => "required",
            "ip" => "required",
        ]);

        $node->update([
            "name" => $request->input("name"),
            "ip" => $request->input("ip"),
            "error" => $this->sendHeartbeat($node)
        ]);

        
        
        return redirect()->route("node.index")->with("success", "Node updated !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Node $node)
    {
        $node->delete();

        return redirect()->route("node.index")->with("success", "Node deleted !");
    }



    /**
     * Send hearth beat to he specified resource.
     */
    private function sendHeartbeat(Node $node): string {
        try {
            $response = Http::post('http://' . $node->ip . ':3000/heartbeat', [
                'token' => $node->token,
            ]);
    
            if ($response->successful()) {
                $responseData = $response->json();
                if ($responseData['token'] === $node->token) {
                    $node->installed = true;
                    $node->save();
    
                    return date("d/m/y H:i:s") . " Node connected!";
                }
            }
    
            return date("d/m/y H:i:s") . " Error during binding the node!";
        } catch (Exception $e) {
            return date("d/m/y H:i:s") . " Error during binding the node! can't ping it";
        }
    }

    public function api(Node $node)
    {
        $datas = $node->datas()->get();

        return response()->json($datas);
    }
}
