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

        $unit = Unit::find($update->unitid);

        $rz = new Roznamcha();
        $rz->title = "Closeing Amount added for Unit " . $unit->title . " | " . $unit->type;
        $rz->amount = $request->closeAmount;
        $rz->type = 1;
        $rz->date = date('Y-m-d');
        $rz->save();

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
        //update unit counter
        $unit = Unit::find($request->unitid);
        $unit_p_counter = $unit->counter;
        $unit_rate = $unit->rate;
        $unit_type = $unit->type;
        $liters = abs($unit_p_counter - $request->counter);
        $unit->counter = $request->counter;
        $unit->save();
        //////////////////////////////

/////add sale list
        $sell = new Sell();
        $sell->unitid = $request->unitid;
        $sell->pcounter = $unit_p_counter;
        $sell->counter = $request->counter;
        $sell->rate = $unit_rate;
        $sell->liters = abs($unit_p_counter - $request->counter);
        $sell->date = date('Y-m-d');
        $sell->save();
        $sell_id = $sell->id;

//////////////

        //updateing stock
        ///////////////////////////////
        $stock = Stock::where('type', $unit_type)->first();

        $stockDetail = new Stock_detail();
        $stockDetail->stockid = $stock->id;
        $stockDetail->sourceid = $sell_id;
        $stockDetail->status = 2;
        $stockDetail->liters = $liters;
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
                $rV = static::checkUpdate($unit_type, $liters, $sell_id);
                $first = false;
            } else {
                $rV = static::checkUpdate($unit_type, $rV, $sell_id);
            }
            if ($rV != 'ok') {
                static::SelectNewPurchase($unit_type);
            }
        } while ($rV != 'ok');

        ///////////////////////////

        return back()->with('success', 'Added New Sell List');

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

        //Chnaging unit counter to Pevouse Unit Counter
        $unit = Unit::find($sellRow->unitid);
        $unit->counter = $sellRow->pcounter;
        $unit->save();

        $sellRow->delete();

        return back()->with('danger', 'Sell List Removed');

    }
}
