<?php

namespace App\Http\Controllers;

use App\Models\Partykanta;
use App\Models\Sell;
use App\Models\SellDetail;
use Illuminate\Http\Request;

class SellDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sellList = Sell::find($id);
        $sellDetails = SellDetail::where('sellid', $id)->get();
        return view('pages.selldetail.index', ['sellList' => $sellList, 'sellDetails' => $sellDetails]);
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

        $table = new SellDetail();

        $table->rate = $request->rate;
        $table->liters = $request->liters;
        $table->date = $request->date;
        $table->amount = $request->rate * $request->liters;
        $table->type = $request->type;
        $table->sellid = $request->sellid;
        if ($request->type == 2) { //especial condtion for partyKanta
            //adding the Record to PartyKanta
            $partykanta = new Partykanta();
            $partykanta->note = $request->fueltype . " Sold Rate: " . $request->rate . " Liters: " . $request->liters;
            $partykanta->partyid = $request->partyid;
            $partykanta->type = 2;
            $partykanta->date = $request->date;
            $partykanta->amount = $request->rate * $request->liters;
            $partykanta->save();
            $sourceid = $partykanta->id;
            $table->partyid = $request->partyid;
            $table->sourceid = $sourceid;
        }
        $table->save();

        return back()->with('success', 'List Updated');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SellDetail  $sellDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SellDetail $sellDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SellDetail  $sellDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(SellDetail $sellDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SellDetail  $sellDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellDetail $sellDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SellDetail  $sellDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        if ($request->sourceid != 0) {
            $pk = Partykanta::find($request->sourceid);
            $pk->delete();
        }
        $sellDetail = SellDetail::find($request->id);
        $sellDetail->delete();
        return back()->with('danger', 'Record Removed!');

    }
}
