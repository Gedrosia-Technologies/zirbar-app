<?php

namespace App\Http\Controllers;

use App\Models\TomanTransactionDetails;
use App\Http\Controllers\Controller;
use App\Models\TomanStockerKanta;
use App\Models\TomanTransaction;
use Hamcrest\Type\IsObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class TomanTransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tomanTransaction = TomanTransaction::find($id);
        $tomanTransactionDetails = TomanTransactionDetails::where('transactionid', $id)->get();
        $remainingFunds = $tomanTransaction->toman;
        foreach ($tomanTransactionDetails as $row) {
            $remainingFunds -= $row->amount;
        }
        return view('pages.toman_transaction_details.index', ['tomanTransaction' => $tomanTransaction, 'tomanTransactionDetails' => $tomanTransactionDetails, 'remainingFunds' => $remainingFunds]);
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
        $tomanTransaction = TomanTransaction::find($request->transactionid);
        $tomanTransactionDetails = TomanTransactionDetails::where('transactionid', $request->transactionid)->get();
        
        $remainingFunds = $tomanTransaction->toman;
        foreach ($tomanTransactionDetails as $row) {
            $remainingFunds -= $row->amount;
        }

        if($request->amount > $remainingFunds) {
            return Redirect::back()->with('danger', 'Remaining toman are '.$remainingFunds);
        }
        
        $table = new TomanTransactionDetails();
        $table->transactionid = $request->transactionid;
        $table->stockerid = $request->stockerid;
        $table->type = $tomanTransaction->type; // 1 purchased 2 sell
        $table->amount = $request->amount; // toman amount
        $table->note = $request->note; // toman amount
        $table->date = $request->date; // toman amount
        $table->save();

        // add to stocker kanta
        $tomanStockerKanta = new TomanStockerKanta();
        $tomanStockerKanta->type = $tomanTransaction->type; // 1 purchase 2 sell
        $tomanStockerKanta->transactiondetailsid = $table->id;
        $tomanStockerKanta->stockerid = $request->stockerid;
        $tomanStockerKanta->transactionid = $request->transactionid;
        $tomanStockerKanta->amount = $request->amount;
        if($tomanTransaction->type == 2) {
            $tomanStockerKanta->note = "Toman Sold: '.$table->amount.' Toman'. 'Rate: '. $tomanTransaction->rate .' PKR';";
        }else {
            $tomanStockerKanta->note = "Toman Purchased: '.$table->amount.' Toman'. 'Rate: '. $tomanTransaction->rate .' PKR';";
        }
        $tomanStockerKanta->date = $request->date;
        $tomanStockerKanta->save();
        return Redirect::back()->with('success', 'Toman Transaction Detail Added');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function show(TomanTransactionDetails $tomanTransactionDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanTransactionDetails $tomanTransactionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanTransactionDetails $tomanTransactionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $table = TomanTransactionDetails::find($request->id);
        $tomanStockerKanta = TomanStockerKanta::where('transactiondetailsid', $request->id)->get();
        $table->delete();
        $tomanStockerKanta[0]->delete();
        return Redirect::back()->with('danger', 'Detail Removed');
    }

    
    public function displayReport2(Request $request)
    {

        $transaction = TomanTransaction::find($request->transactionid);
        $data = TomanTransactionDetails::where('transactionid', $request->transactionid)->get();
        $pdf = PDF::loadView('pages.toman_transaction_details.print', compact('data', 'transaction'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Toman Transaction ' .$request->id.' .pdf');
    }


}
