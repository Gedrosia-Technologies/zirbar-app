<?php

namespace App\Http\Controllers;

use App\Models\TomanTransaction;
use App\Http\Controllers\Controller;
use App\Models\ClientTomanBalance;
use App\Models\TomanClientKanta;
use App\Models\TomanPurchase;
use App\Models\TomanSale;
use App\Models\TomanSupplierKanta;
use App\Models\TomanTransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;
use PdfReport;

class TomanTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TomanTransaction::all();
        $pkrIncoming = 0;
        $pkrOutgoing = 0;
        $tomanIncoming = 0;
        $tomanOutgoing = 0;
        
        foreach ($data as $row) {
           if(!$row->isopen) {
                    if ($row->type == 1) {
                        $pkrOutgoing += $row->amount;
                        $tomanIncoming += $row->toman;
                    }
                    if ($row->type == 2) {
                        $pkrIncoming += $row->amount;
                        $tomanOutgoing += $row->toman;
                    }
            }
        }
        $pkrBalance = [
            'balance' => $pkrIncoming - $pkrOutgoing, 
            'outgoing' => $pkrOutgoing,
            'incoming' => $pkrIncoming
        ];
        $tomanBalance = [
            'balance' => $tomanIncoming - $tomanOutgoing, 
            'outgoing' => $tomanOutgoing, 
            'incoming' => $tomanIncoming
        ];

        return view('pages.toman_accounts.index', ['data' => $data, 'pkrBalance' => $pkrBalance,'tomanBalance' => $tomanBalance ]);
    }

    public function date(Request $request)
    {
        //
        $yesterday = date("Y-m-d", strtotime($request->date . '-1 days'));
        $data_yesterday = TomanTransaction::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
        $pkrIncoming = 0;
        $pkrOutgoing = 0;
        foreach ($data_yesterday as $row) {
            if ($row->type == 1) {
                $pkrIncoming += $row->amount;
            }
            if ($row->type == 2) {
                $pkrOutgoing += $row->amount;
            }
        }

        $balance = $pkrIncoming - $pkrOutgoing;

        $today = TomanTransaction::whereDate('date', date("Y-m-d", strtotime($request->date)))->get();
        return view('pages.toman_accounts.date', ['view_date' => $request->date, 'data' => $today, 'balance' => $balance]);
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
     * Store Purchase a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePurchase(Request $request)
    {
        
        $tomanammount = round($request->toman);
        $rate = round($request->rate);
        $total = round($request->toman / $request->rate); 
        
        // add to toman transactions
        $toman = new TomanTransaction();
        $toman->partyid = $request->supplierid;
        $toman->type = $request->type;
        $toman->acctype = $request->acctype;
        $toman->toman = $tomanammount;
        $toman->rate = $rate;
        $toman->amount = $total;
        $toman->date = $request->date;
        
        // $purchase->save();
        $toman->save();
        return Redirect::back()->with('msg', 'An Open purchase Added');
    }

    /**
     * Store Sell a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSell(Request $request)
    {
        
        $tomanammount = round($request->toman);
        $rate = round($request->rate);
        $total = round($request->toman / $request->rate); 
        
        // add to toman transactions
        $toman = new TomanTransaction();
        $toman->partyid = $request->clientid;
        $toman->type = $request->type;
        $toman->acctype = $request->acctype;
        $toman->toman = $tomanammount;
        $toman->rate = $rate;
        $toman->amount = $total;
        $toman->date = $request->date;
        
        // $purchase->save();
        $toman->save();
        return Redirect::back()->with('msg', 'An Open sale Added');        
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanTransaction  $toman
     * @return \Illuminate\Http\Response
     */
    public function show(TomanTransaction $toman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanTransaction  $toman
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanTransaction $toman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanTransaction  $toman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanTransaction $toman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanTransaction  $toman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = TomanTransaction::find($request->id);
        $tomanTransactionDetails = TomanTransactionDetails::where('transactionid', $request->id)->get();

        foreach ($tomanTransactionDetails as $row) {
            $row->delete();
        }

        $data->delete();
        return redirect('/TomanTransactions')->with('danger', 'Record Delete');

    }


    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = TomanTransaction::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
        $pkrIncoming = 0;
        $pkrOutgoing = 0;
        foreach ($data_yesterday as $row) {
            if ($row->type == 1) {
                $pkrIncoming += $row->amount;
            }
            if ($row->type == 2) {
                $pkrOutgoing += $row->amount;
            }
        }

        $balance = $pkrIncoming - $pkrOutgoing;
        $data = TomanTransaction::whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.toman_accounts.print', compact('data', 'fromDate', 'toDate', 'balance'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Toman Accounts ' . $fromDate . ' to ' . $toDate . '.pdf');

    }

    public function closeTransaction(Request $request) {
        $tomanTransaction = TomanTransaction::find($request->transactionid); 

        if($tomanTransaction->type == 1) {
            // add to supplier kanta
            $kanta = new TomanSupplierKanta();
            $kanta->supplierid = $tomanTransaction->partyid;
            $kanta->isbridged = 1; 
            $kanta->amount = round($tomanTransaction->toman / $tomanTransaction->rate); 
            $kanta->type = 2; 
            $kanta->note = 'Toman Purchased: '.$tomanTransaction->toman.' Toman'. 'Rate: '. $tomanTransaction->rate .' PKR';
            $kanta->date = $tomanTransaction->date;
            $kanta->save();
    
            if($tomanTransaction->acctype == 1){
                // add to supplier kanta
                $kanta = new TomanSupplierKanta();
                $kanta->supplierid = $tomanTransaction->partyid;
                $kanta->isbridged = 1; 
                $kanta->amount = round($tomanTransaction->toman / $tomanTransaction->rate); 
                $kanta->type = 1;
                $kanta->note = 'Paid for Toman Purchased: '.$tomanTransaction->toman.' Toman'. 'Rate: '. $tomanTransaction->rate .' PKR';
                $kanta->date = $tomanTransaction->date;
                $kanta->save();
            }
        }else {
        //add in client toman balance
        $toman_blance = new ClientTomanBalance();
        $toman_blance->clientid = $tomanTransaction->partyid;
        $toman_blance->type = 1;
        $toman_blance->date = $tomanTransaction->date;
        $toman_blance->note = "Toman Purchased";
        $toman_blance->amount = $tomanTransaction->toman;
        $toman_blance->save();

        
        // $toman_blance_id = $toman_blance->id;
        // //add in toman purchase        
        // $sale = new TomanSale();
        // $sale->partyid = $request->clientid;
        // $sale->toman_balance_id = $toman_blance_id;
        // $sale->toman = $tomanammount;
        // $sale->rate = $rate;
        // $sale->amount = $total; 
        // $sale->acctype = $request->acctype;
        // $sale->date = $request->date;


        // add to client kanta
        $kanta = new TomanClientKanta();
        $kanta->clientid = $tomanTransaction->partyid;;
        $kanta->amount = $tomanTransaction->amount; 
        $kanta->type = 2;
        $kanta->isbridged = 1; 
        $kanta->note = 'Toman Purchased: '.$tomanTransaction->amount.' Toman'. 'Rate: '. $tomanTransaction->rate .' PKR';
        $kanta->date = $tomanTransaction->date;
        $kanta->save();

        if($tomanTransaction->acctype == 1){
            // add to client kanta
            $kanta = new TomanClientKanta();
            $kanta->clientid = $tomanTransaction->partyid;
            $kanta->amount = $tomanTransaction->amount; 
            $kanta->isbridged = 1; 
            $kanta->type = 1;
            $kanta->note = 'Paid for Toman Purchased: '.$tomanTransaction->amount.' Toman'. 'Rate: '. $tomanTransaction->rate .' PKR';
            $kanta->date = $tomanTransaction->date;
            $kanta->save();
        }

        }

        $tomanTransaction->isopen = 0;
        $tomanTransaction->save();
        return Redirect::back()->with('success', 'Toman Transaction Closed');
    }
}
