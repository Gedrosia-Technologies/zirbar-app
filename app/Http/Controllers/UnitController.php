<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Unit::all();
        return view('pages.units.index',['units' => $data]);
    }

    public function addnew(Request $request)
    {
        //
        $unit = new Unit();
        $unit->title = $request->title;
        $unit->type = $request->type;
        $unit->counter = $request->counter;
        $unit->save();
        return Redirect::back()->with('success', 'New Unit Created');
        
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
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $table = Unit::find($request->id);
        $table->title = $request->title;
        $table->type = $request->type;
        $table->counter = $request->counter;
        $table->save();
       return Redirect::back()->with('info', 'Unit Updated..');
    }
    public function rate(Request $request)
    {
        //
        Unit::where('type', '=', $request->type)->update(['rate' => $request->rate]);
        
       return Redirect::back()->with('success', 'Rate Updated..');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $table = Unit::find($request->id);
        $table->delete();
        return Redirect::back()->with('danger', 'Unit Removed');
    }
}
