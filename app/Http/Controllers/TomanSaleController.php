<?php

namespace App\Http\Controllers;

use App\Models\TomanSale;
use App\Http\Controllers\Controller;
use App\Models\TomanClientKanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Toman;
use App\Models\ClientTomanBalance;


class TomanSaleController extends Controller
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

        //add in client toman balance
        $toman_blance = new ClientTomanBalance;
        $toman_blance->clientid = $request->clientid;
        $toman_blance->type = 1;
        $toman_blance->date = $request->date;
        $toman_blance->note = "Toman Purchased";
        $toman_blance->amount = $tomanammount;
        $toman_blance->save();
        $toman_blance_id = $toman_blance->id;

        //add in toman purchase        
        $sale = new TomanSale();
        $sale->clientid = $request->clientid;
        $sale->toman_balance_id = $toman_blance_id;
        $sale->toman = $tomanammount;
        $sale->rate = $rate;
        $sale->amount = $total; 
        $sale->type = $request->type;
        $sale->date = $request->date;


        // add to client kanta
        $kanta = new TomanClientKanta();
        $kanta->clientid = $request->clientid;
        $kanta->amount = $total; 
        $kanta->type = 2;
        $kanta->note = 'Toman Purchased: '.$tomanammount.' Toman'. 'Rate: '. $rate .' PKR';
        $kanta->date = $request->date;
        $kanta->save();

        if($request->type == 1){
            // add to client kanta
            $kanta = new TomanClientKanta();
            $kanta->clientid = $request->clientid;
            $kanta->amount = $total; 
            $kanta->type = 1;
            $kanta->note = 'Paid for Toman Purchased: '.$tomanammount.' Toman'. 'Rate: '. $rate .' PKR';
            $kanta->date = $request->date;
            $kanta->save();
        }

        
        // add to toman
        $toman = new toman();

        $toman->type = 2;
        $toman->partyid = $request->clientid;
        $toman->acctype = $request->type;
        $toman->toman = $tomanammount;
        $toman->rate = $rate;
        $toman->amount = $total;
        $toman->date = $request->date;

        
        
        $sale->save();
        $toman->save();
        return Redirect::back()->with('success', 'Sale Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanSale  $tomanSale
     * @return \Illuminate\Http\Response
     */
    public function show(TomanSale $tomanSale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanSale  $tomanSale
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanSale $tomanSale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanSale  $tomanSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanSale $tomanSale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanSale  $tomanSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(TomanSale $tomanSale)
    {
        //
    }
}
