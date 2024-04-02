<?php

namespace App\Http\Controllers;

use App\Models\TomanSupplierKanta;
use App\Http\Controllers\Controller;
use App\Models\TomanSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TomanSupplierKantaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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

            $partykanta = new TomanSupplierKanta();
            $partykanta->note = $request->input('title');
            $partykanta->supplierid = $request->partyid;
            $partykanta->type = $request->type;
            $partykanta->date = $request->date;
            $partykanta->amount = $request->amount;
            $partykanta->save();

        return Redirect::back()->with('success', 'Record added ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TomanSupplier::where('id', $id)->first();
        $data2 = TomanSupplierKanta::where('supplierid', $id)->get();
        //dd($data2);
        return view('pages.tomansupplierkanta.index', ['party' => $data, 'kanta' => $data2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanSupplierKanta $tomanSupplierKanta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanSupplierKanta $tomanSupplierKanta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         //
         $data = TomanSupplierKanta::find($request->id);
         $data->delete();
         return Redirect::back()->with('danger', 'Record Deleted');
    }
}
