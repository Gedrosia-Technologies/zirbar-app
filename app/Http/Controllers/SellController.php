<?php

namespace App\Http\Controllers;

use App\Models\Partykanta;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Roznamcha;
use App\Models\Sell;
use App\Models\SellDetail;
use App\Models\Stock;
use App\Models\Stock_detail;
use App\Models\Unit;
use Illuminate\Http\Request;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Sell::all();
        $data2 = Stock::all();
        $data3 = Stock_detail::all();

        return view('pages.sell.index', ['sold' => $data, 'stock' => $data2, 'stockdetails' => $data3]);
    }
    public function close(Request $request)
    {
        //
        $update = Sell::find($request->id);
        $update->isclosed = true;
        $update->save();

        $table = new SellDetail();
        $table->rate = $request->rate;
        $table->liters = $request->liters;
        $table->date = date('Y-m-d');
        $table->amount = $request->rate * $request->liters;
        $table->type = 3;
        $table->sellid = $request->id;
        $table->save();


        // $rz = new Roznamcha();
        // $rz->title = "Closeing Amount added for Unit " . $unit->title . " | " . $unit->type;
        // $rz->amount = $request->closeAmount;
        // $rz->type = 1;
        // $rz->date = date('Y-m-d');
        // $rz->save();

        return back()->with('info', 'Sell List Closed');
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

        /// check Stock
        $check = static::CheckStock($request->fuel , $request->liters);
        if(!$check){
            return back()->with('danger', 'Not Enough Stock Remaining Sell List Can not be added');
        }
        ///

        /////add sale list
                $sell = new Sell();
                $sell->fuel = $request->fuel;
                $sell->rate = $request->rate/210;
                $sell->liters = $request->liters;
                $sell->date = date('Y-m-d');
                $sell->save();
                $sell_id = $sell->id;

        //////////////

        //updateing stock
        ///////////////////////////////
        $stock = Stock::where('type', $request->fuel)->first();

        $stockDetail = new Stock_detail();
        $stockDetail->stockid = $stock->id;
        $stockDetail->sourceid = $sell_id;
        $stockDetail->status = 2;
        $stockDetail->liters = $request->liters;
        $stockDetail->date = date('Y-m-d');
        $stockDetail->save();
        // $stock->liters = $stock->liters - $liters;
        // $stock->sold = $stock->sold + $liters;

        // $stock->save();

        ///////////////////////////
        //updateing purchase

        ///////////////////////////////
        $rV = 0;
        $first = true;
        do {
            if ($first) {
                $rV = static::checkUpdate($request->fuel, $request->liters, $sell_id);
                $first = false;
            } else {
                $rV = static::checkUpdate($request->fuel, $rV, $sell_id);
            }
            if ($rV != 'ok') {
                static::SelectNewPurchase($request->fuel);
            }
        } while ($rV != 'ok');

        ///////////////////////////

        //Sell details 

        $table = new SellDetail();

        $table->rate = $request->rate/210;
        $table->liters = $request->liters;
        $table->date = $request->date;
        $table->amount = ($request->rate/210) * $request->liters;
        $table->type = 2;
        $table->sellid = $sell_id;
        $partykanta = new Partykanta();
        $partykanta->note = $request->fuel . " Sold Rate: " . $request->rate/210 . " Liters: " . $request->liters;
        $partykanta->partyid = $request->partyid;
        $partykanta->type = 2;
        $partykanta->date = $request->date;
        $partykanta->amount = $request->rate/210 * $request->liters;
        $partykanta->save();
        $sourceid = $partykanta->id;
        $table->partyid = $request->partyid;
        $table->sourceid = $sourceid;
        $table->save();

        //

        return back()->with('success', 'Added New Sell List');

    }

    public static function CheckStock($stocktype ,$liters2){

        $stock = \App\Models\Stock::where('type',$stocktype)->first();
        $stock_details = \App\Models\Stock_detail::where('stockid',$stock->id)->get();
        $liters = 0.00;
        $rliters = 0.00;
            foreach ($stock_details as $row ) {
                if($row->status == 1){

                    $liters +=  $row->liters;
                }else{
                    $rliters += $row->liters;
                }
            }
        $stock = $liters - $rliters;
        if($stock >= $liters2){
            return true;
        }
        else{
            return false;
        }
    }

    public static function checkUpdate($unit_type, $liters, $sell_id)
    {
        $purchase = Purchase::where('type', $unit_type)->where('status', 1)->first();
        $purchase_details = PurchaseDetails::where('purchaseid', $purchase->id)->get();
        $liters_sold = 0.00;
        foreach ($purchase_details as $row) {
            $liters_sold += $row->liters;
        }
        // dd($purchase);
        $purchase_Liters_left = abs($purchase->liters - $liters_sold);
        $returntype = 'ok';
        if ($liters < $purchase_Liters_left) {
            $table = new PurchaseDetails();
            $table->purchaseid = $purchase->id;
            $table->saleid = $sell_id;
            $table->liters = $liters;
            $table->date = date('Y-m-d');
            $table->save();
            // $purchase->liters_sold = $purchase->liters_sold + $liters;

        } else {
            $table = new PurchaseDetails();
            $table->purchaseid = $purchase->id;
            $table->saleid = $sell_id;
            $table->liters = $purchase_Liters_left;
            $table->date = date('Y-m-d');
            $table->closedafter = true;
            $table->save();
            //   $purchase->liters_sold = $purchase->liters_sold + $purchase_Liters_left;
            $purchase->status = 2;
            $returntype = $liters - $purchase_Liters_left;
        }
        $purchase->save();
        return $returntype;
    }

    public static function SelectNewPurchase($unit_type)
    {
        $purchase = Purchase::where('type', $unit_type)->where('status', 0)->orderby('id', 'asc')->first();
        $purchase->status = 1;
        $purchase->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function show(Sell $sell)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function edit(Sell $sell)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sell $sell)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sell  $sell
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $Sell_id = $request->id;
        $sell_details = SellDetail::where('sellid', $Sell_id)->get();
        foreach ($sell_details as $data) {
            if ($data->sourceid != 0) {
                $pk = Partykanta::find($data->sourceid);
                $pk->delete();
            }
            $sellDetail = SellDetail::find($data->id);
            $sellDetail->delete();
        }

        //deleting stock_details with sold backup
        $stock_details = Stock_detail::where('sourceid', $Sell_id)->where('status', 2)->get();
        foreach ($stock_details as $data) {
            $row = Stock_detail::find($data->id);
            $row->delete();
        }

        //deleting purchase Details with purchase backup
        $purchase_details = PurchaseDetails::where('saleid', $Sell_id)->orderby('purchaseid', 'desc')->get();

        $count = count($purchase_details);
        // dd($count);

        foreach ($purchase_details as $data) {

            if ($data->closedafter) {
                //updating purchase setting it to purchased status
                $update = Purchase::find($data->purchaseid);
                $update->status = 0;
                $update->save();
                //deleting the record
                $delete = PurchaseDetails::find($data->id);
                $delete->delete();
            } else {
                $delete = PurchaseDetails::find($data->id);
                $delete->delete();
            }

            if ($count == 1) {
                $update = Purchase::find($data->purchaseid);
                $update->status = 1;
                $update->save();

            } else {
                $update = Purchase::find($data->purchaseid);
                $update->status = 0;
                $update->save();
            }
            $count--;
        }

        $sellRow = Sell::find($Sell_id);

        // //Chnaging unit counter to Pevouse Unit Counter
        // $unit = Unit::find($sellRow->unitid);
        // $unit->counter = $sellRow->pcounter;
        // $unit->save();

        $sellRow->delete();

        return back()->with('danger', 'Sell List Removed');

    }
}
