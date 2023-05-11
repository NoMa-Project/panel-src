<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    public static function Install(Node $node)
    {   
        
    }

    public function heartbeat(Request $request, Node $node, $key) {
        if ($node->key != $key) {
            return json_encode("Invalid Key");
        };

        $node->installed = true;
        $node->save();
        
        return json_encode("Done");
    }
}
