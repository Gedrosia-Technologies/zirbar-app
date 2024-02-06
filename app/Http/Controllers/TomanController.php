<?php

namespace App\Http\Controllers;

use App\Models\Toman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TomanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data = Toman::all();
        $incoming = 0;
        $outgoing = 0;
        foreach ($data as $row) {
            if ($row->type == 1) {
                $incoming += $row->amount;
            }
            if ($row->type == 2) {
                $outgoing += $row->amount;
            }
        }

        $balance = $incoming - $outgoing;

        return view('pages.toman_accounts.index', ['data' => $data, 'balance' => $balance]);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function show(Toman $toman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function edit(Toman $toman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Toman $toman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Toman $toman)
    {
        //
    }
}
