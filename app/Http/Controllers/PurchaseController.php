<?php

namespace App\Http\Controllers;

use App\Models\Partykanta;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Roznamcha;
use App\Models\Stock;
use App\Models\Stock_detail;
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
        $purchase->save();
        $purchaseid = $purchase->id;

        //add stock

        $stock = Stock::where('type', $request->type)->first();
        $stock_detail = new Stock_detail();
        $stock_detail->stockid = $stock->id;
        $stock_detail->sourceid = $purchaseid;
        $stock_detail->liters = $liters;
        $stock_detail->status = 1;
        $stock_detail->date = $request->date;
        $stock_detail->save();

        // $stock->liters = $request->liters + $liters;
        // $stock->save();

        if ($request->party == 0) {
            // add to roznamcha
            $table = new Roznamcha;
            $table->title = 'Payed for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
            $table->amount = $rate * $liters;
            $table->type = 2;
            $table->date = $request->date;
            $table->save();
        } else if ($request->party > 0) {
            if ($request->status == 1) {
                // credit
                $partykanta = new Partykanta;
                $partykanta->note = 'Purchased ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $partykanta->partyid = $request->party;
                $partykanta->type = 1;
                $partykanta->date = $request->date;
                $partykanta->amount = $rate * $liters;
                $partykanta->save();
                //debit
                $partykanta = new Partykanta;
                $partykanta->note = 'Payed for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $partykanta->partyid = $request->party;
                $partykanta->type = 2;
                $partykanta->date = $request->date;
                $partykanta->amount = $rate * $liters;
                $partykanta->save();
                // add to roznamcha
                $table = new Roznamcha;
                $table->title = 'Payed for ' . $request->qtydrum . ' Drums ' . $request->qtyliter . ' Liters Rate: ' . $request->price . ' / Drum';
                $table->amount = $rate * $liters;
                $table->type = 2;
                $table->date = $request->date;
                $table->save();

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
            }
        }
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
    public function destroy(Purchase $purchase)
    {
        //
    }

    function print(Request $request) {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $data = PurchaseDetails::where('type', $request->fishid)->whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();

        // $fishName = $fish->type;
        $date = Carbon::now()->format('d/m/Y');
        $pdf = PDF::loadView('pages.purchase.print', compact('data', 'date', 'fromDate', 'toDate'));

        $pdf->setPaper('A4', 'portrait');
// $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Purchase ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}
