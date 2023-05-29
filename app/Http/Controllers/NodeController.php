<?php

namespace App\Http\Controllers;

use Spatie\Ssh\Ssh;
use App\Models\Node;
use Illuminate\Http\Request;

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
            "port" => "required",
            "user" => "required",
            "password" => "required",
        ]);

        $node = Node::create([
            "name" => $request->input("name"),
            "ip" => $request->input("ip"),
            "port" => $request->input("port"),
            "user" => $request->input("user"),
            "pswd" => $request->input("password"),
            "key" => bin2hex(random_bytes(16)),
        ]);

        $this->sendHeartbeat($node);

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
            "port" => "required",
            "user" => "required",
            "password" => "required",
        ]);

        $node->update([
            "name" => $request->input("name"),
            "ip" => $request->input("ip"),
            "port" => $request->input("port"),
            "user" => $request->input("user"),
            "pswd" => $request->input("password"),
        ]);

        $this->sendHeartbeat($node);
        
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
    private function sendHeartbeat(Node $node) {
        $url = route('heartbeat', [$node->id, $node->key]);
        $test = Ssh::create('mazbaz', $node->ip)->usePrivateKey(storage_path('keys/testkeys'))->execute('cat hello > /var/test.mazbaz');
        dd($test->isSuccessful());
        $node->error = "";

        $node->save();
    }
}
