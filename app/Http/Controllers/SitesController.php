<?php

namespace App\Http\Controllers;

use App\Models\Sites;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("sites.index", [
            "sites" => Sites::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("sites.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required"],
            "desc" => ["required"],
            "fqnd" => ["required"],
            "type" => ["required"],
        ]);

        Sites::create([
            "name" => $request->name,
            "desc" => $request->desc,
            "type" => $request->type,
            "ssl" => $request->has("fqnd"),
            "fqnd" => $request->fqnd,
            "error" => "null",
        ]);

        return redirect()->route("sites.index")->with("success", "Site created !");
    }

    /**
     * Display the specified resource.
     */
    public function show(Sites $site)
    {
        return view("sites.show", [
            "site" => $site
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sites $site)
    {
        return view("sites.edit", [
            "site" => $site
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sites $sites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sites $sites)
    {
        //
    }
}
