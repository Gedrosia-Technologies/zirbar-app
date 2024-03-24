<?php

namespace App\Http\Controllers;

use App\Models\Partykanta;
use App\Models\Purchase;
use App\Models\PurchaseCon;
use App\Models\PurchaseDetails;
use App\Models\Roznamcha;
use App\Models\Stock;
use App\Models\Stock_detail;
use App\Models\Account_details;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data = Purchase::all();
        return view('pages.purchase.index', ['purchases' => $data]);
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
        // check if already purchase in use
        $data = Purchase::where('status', 1)->where('type', $request->type)->first();
        //
        $status = 0;
        if (!$data) {
            $status = 1;
        }

        $purchasecon = new PurchaseCon();
        $purchase = new Purchase();
        $purchase->type = $request->type;

        $liters = $request->qtydrum * 210 + $request->qtyliter;
        $rate = ($request->price/$request->rate) / 210;

        $purchase->liters = $liters;
        $purchase->drum_rate = $request->price / $request->rate;
        $purchase->liter_rate = $rate;
        $purchase->amount = round($rate * $liters);
        $purchase->date = $request->date;
        $purchase->party = $request->party;
        $purchase->paid = $request->status;
        $purchase->status = $status;
        $purchase->note = $request->note;
        $purchase->save();
        $purchaseid = $purchase->id;
       
        //purchase con
        $purchasecon->purchaseid = $purchase->id;
        //puchase con

        //add stock

        $stock = Stock::where('type', $request->type)->first();
        $stock_detail = new Stock_detail();
        $stock_detail->stockid = $stock->id;
        $stock_detail->sourceid = $purchaseid;
        $stock_detail->liters = $liters;
        $stock_detail->status = 1;
        $stock_detail->date = $request->date;
        $stock_detail->save();

         //purchase con
         $purchasecon->stockdetailid = $stock_detail->id;
         //puchase con

        // $stock->liters = $request->liters + $liters;
        // $stock->save();

        if ($request->party == 0) {
            // add to roznamcha
            $table = new Roznamcha;
            $table->title = 'Paid for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
            $table->amount = $rate * $liters;
            $table->type = 2;
            $table->date = $request->date;
            $table->save();
             //purchase con
        $purchasecon->roznamchadebitid = $table->id;
        //puchase con
        } else if ($request->party > 0) {
            if ($request->status == 1) {
                // credit
                $pkc = new Partykanta;
                $pkc->note = 'Purchased ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $pkc->partyid = $request->party;
                $pkc->type = 1;
                $pkc->date = $request->date;
                $pkc->amount = $rate * $liters;
                $pkc->save();
                $pkcid = $pkc->id;

                  //purchase con
                 $purchasecon->partykantacreditid = $pkcid;
                 //puchase con

                //debit
                $pkd = new Partykanta;
                $pkd->note = 'Paid for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $pkd->partyid = $request->party;
                $pkd->type = 2;
                $pkd->date = $request->date;
                $pkd->amount = $rate * $liters;
                $pkd->save();
                $pkdid = $pkd->id;

                 //purchase con
                 $purchasecon->partykantadebitid = $pkdid;
                 //puchase con

                // add to roznamcha
                $table = new Roznamcha;
                $table->title = 'Paid for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $table->amount = $rate * $liters;
                $table->type = 2;
                $table->date = $request->date;
                $table->save();
                 //purchase con
                 $purchasecon->roznamchadebitid = $table->id;
                 //puchase con

            }
            //credit only
            if ($request->status == 0) {
                $partykanta = new Partykanta;
                $partykanta->note = 'Purchased ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $partykanta->partyid = $request->party;
                $partykanta->type = 1;
                $partykanta->date = $request->date;
                $partykanta->amount = $rate * $liters;
                $partykanta->save();

                 //purchase con
                 $purchasecon->partykantacreditid = $partykanta->id;
                 //puchase con
            }
        }

       

        $account_details = new Account_details();
        $account_details->account_id = 1;
        $account_details->description= 'Paid for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
        $account_details->type = 0;
        $account_details->date = $request->date;
        $account_details->amount = $rate * $liters;
        $account_details->save();

        //purchase con
        $purchasecon->accountdetailid = $account_details->id;
        //puchase con

        $rz = new Roznamcha();
        $rz->title = 'Account id('.$account_details->id.') Balance Credit';
        $rz->amount=  $rate * $liters;
        $rz->type = 1;
        $rz->date = $request->date;
        $rz->save();

        //purchase con
        $purchasecon->roznamchacreditid = $rz->id;
        //puchase con

        $purchasecon->save();

        return Redirect::back()->with('success', 'Purchase order added');
    }
    public function close(Request $request)
    {
        //
        $table = Purchase::find($request->id);
        $table->status = 1;
        $table->save();
        return Redirect::back()->with('danger', 'Purchase has been closed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    
        $purchase = Purchase::find($request->id);
        $purchasecon = PurchaseCon::where('purchaseid',$request->id)->first();

        $stockdetail = Stock_detail::find($purchasecon->stockdetailid);
        if($stockdetail != null)
        $stockdetail->delete();

        $ad = Account_details::find($purchasecon->accountdetailid);
        if($ad != null)
        $ad->delete();

        $pkc = Partykanta::find($purchasecon->partykantacreditid);
        if($pkc != null)
        $pkc->delete();

        $pkd = Partykanta::find($purchasecon->partykantadebitid);
        if($pkd != null)
        $pkd->delete();

        $rzd = Roznamcha::find($purchasecon->roznamchadebitid);
        if($rzd != null)
        $rzd->delete();

        $rzc = Roznamcha::find($purchasecon->roznamchacreditid);
        if($rzc != null)
        $rzc->delete();

        $purchasecon->delete();
        $purchase->delete();

        return Redirect::back()->with('danger', 'Purchase Deleted !');

    }

    function print(Request $request) {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $data = Purchase::where('type', $request->fishid)->whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();

        // $fishName = $fish->type;
        $date = Carbon::now()->format('d/m/Y');
        $pdf = PDF::loadView('pages.purchase.print', compact('data', 'date', 'fromDate', 'toDate'));

        $pdf->setPaper('A4', 'portrait');
// $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Purchase ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}
