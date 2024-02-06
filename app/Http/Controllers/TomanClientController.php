<?php

namespace App\Http\Controllers;

use App\Models\TomanClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TomanClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  
        $data = TomanClient::all();
        return view('pages.toman_clients.index',['party' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $client = new TomanClient();
        $client->name = $request->title;
        $client->save();
        return Redirect::back()->with('msg', 'The Message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Http\Response
     */
    public function show(TomanClient $tomanClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanClient $tomanClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanClient $tomanClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanClient  $tomanClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(TomanClient $tomanClient)
    {
        //
    }
}
