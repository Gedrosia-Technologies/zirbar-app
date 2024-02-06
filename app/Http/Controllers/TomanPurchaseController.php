<?php

namespace App\Http\Controllers;

use App\Models\TomanPurchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TomanSupplierKanta;
use App\Models\Toman;


class TomanPurchaseController extends Controller
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
        
        $tomanammount = round($request->toman);
        $rate = round($request->rate);
        $total = round($request->toman / $request->rate); 


        //add in toman purchase        
        $purchase = new TomanPurchase();
        $purchase->supplierid = $request->supplierid;
        $purchase->toman = $tomanammount;
        $purchase->rate = $rate;
        $purchase->amount = $total; 
        $purchase->type = $request->type;
        $purchase->date = $request->date;


        // add to supplier kanta
        $kanta = new TomanSupplierKanta();
        $kanta->supplierid = $request->supplierid;
        $kanta->amount = $total; 
        $kanta->type = 2;
        $kanta->note = 'Toman Purchased: '.$tomanammount.' Toman'. 'Rate: '. $rate .' PKR';
        $kanta->date = $request->date;
        $kanta->save();

        if($request->type == 1){
            // add to supplier kanta
            $kanta = new TomanSupplierKanta();
            $kanta->supplierid = $request->supplierid;
            $kanta->amount = $total; 
            $kanta->type = 1;
            $kanta->note = 'Paid for Toman Purchased: '.$tomanammount.' Toman'. 'Rate: '. $rate .' PKR';
            $kanta->date = $request->date;
            $kanta->save();
        }

        
        // add to toman
        $toman = new toman();

        $toman->type = 1;
        $toman->partyid = $request->supplierid;
        $toman->acctype = $request->type;
        $toman->toman = $tomanammount;
        $toman->rate = $rate;
        $toman->amount = $total;
        $toman->date = $request->date;

        
        
        $purchase->save();
        $toman->save();
        return Redirect::back()->with('msg', 'Purchase Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanPurchase  $tomanPurchase
     * @return \Illuminate\Http\Response
     */
    public function show(TomanPurchase $tomanPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanPurchase  $tomanPurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanPurchase $tomanPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanPurchase  $tomanPurchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanPurchase $tomanPurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanPurchase  $tomanPurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(TomanPurchase $tomanPurchase)
    {
        //
    }
}
