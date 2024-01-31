<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetails;
use App\Models\Purchase;
use App\Models\Process;
use App\Models\Karcha;
use App\Models\Partykanta;
use App\Models\Broker_kanta;
use App\Models\Roznamcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class PurchaseDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseDetails  $purchaseDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Purchase::where('id', $id)->first();
        $data2 = PurchaseDetails::where('purchaseid', $id)->get();//
        return view('pages.purchasedetails.index',['purchase' => $data,'list' =>$data2]);

    }
    public function add(Request $request)
    {
        $amount = ($request->quantity * $request->rate) ;
        $pt = $amount - ($amount * ($request->wastep/100));
        $Newrate = $pt/$request->quantity;
       // dd($Newrate); 
        $table = new PurchaseDetails();
        $table->purchaseid = $request->purchaseid;
        $table->type = $request->type;
        $table->rate = $Newrate;///$request->rate;
        $table->pt = $request->wastep;///$request->rate;
        $table->orate = $request->rate;
        $table->qty = $request->quantity;
        $table->cqty = $request->quantity;
        $table->date = $request->date;
        $table->save();
        return Redirect::back()->with('success', 'Added New Purchase item');
        
    }
      public function addKarcha(Request $request)
    {
        $table = new Karcha();
        $table->purchaseid = $request->purchaseid;
        $table->type = $request->note;
        $table->amount = $request->amount;
        $table->date = $request->date;
        $table->save();

        // $table = new Partykanta();
        // $table->partyid = 1;
        // $table->type = 2;
        // $table->amount = $request->amount;
        // $table->note = $request->note;
        // $table->date = $request->date;
        // $table->save();

        $table = new Roznamcha();
        $table->title = $request->note.' Karcha Paid ';
        $table->amount= $request->amount;
        $table->type = 2;
        $table->date = $request->date;
        $table->save();

        return Redirect::back()->with('success', 'Added New Karcha item');
        
    }

       public function pay($id,$brokerid,$fishtype)
    {
        
        $purchaseRow = PurchaseDetails::where('id',$id)->first();
        //adding to broker account
        $table = new Broker_kanta();
        $table->brokerid = $brokerid;
        $table->type = 1;
        $table->amount = ($purchaseRow->qty) * ($purchaseRow->rate);
        $table->note = $purchaseRow->qty.' kgs Purchased of '.$fishtype;
        $table->date = $purchaseRow->date;
        $table->save();

        //Changing the Status 
        $table = PurchaseDetails::find($id);
        $table->status = 1;
        $table->save();
        return Redirect::back()->with('success', 'Amount Credited to Broker Account');

    }
       public function process(Request $request)
    {
        
        // $purchaseRow = PurchaseDetails::where('id',$id)->first();
        // //adding to broker account
        // $table = new Broker_kanta();
        // $table->brokerid = $brokerid;
        // $table->type = 1;
        // $table->amount = ($purchaseRow->qty) * ($purchaseRow->rate);
        // $table->note = $purchaseRow->qty.' kgs Purchased of '.$fishtype;
        // $table->date = $purchaseRow->date;
        // $table->save();


        //Process adding Gand
        $table = new Process();
        $table->PurchaseId = $request->purchaseid;
        $table->PurchaseItemDetailId = $request->itemId;
        $table->rate = $request->rate;
        $table->qty = $request->quantity;
        $table->amount = ($request->rate)*($request->quantity);
        $table->type = $request->fishtype;
        $table->save();




        //Updateing Current Qty
        $C_qty = $request->fqty;
        $C_qty -= $request->quantity;
        $table = PurchaseDetails::find($request->itemId);
        $table->cqty = $C_qty;
        $table->save();

        


        return Redirect::back()->with('success', 'Amount Credited to Broker Account');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseDetails  $purchaseDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseDetails $purchaseDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseDetails  $purchaseDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseDetails $purchaseDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseDetails  $purchaseDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseDetails $purchaseDetails)
    {
        //
    }


public function displayReport2(Request $request)
    {
        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        $partyname = $request->input('partyname');
        $purchaseid = $request->input('id');
    // $data = Roznamcha::select(['*']) // Do some querying..
    // ->whereBetween('date', [$fromDate, $toDate])->get();
    // $yesterday = date("Y-m-d", strtotime(  $fromDate .'-1 days' ) );
    // $data_yesterday = PurchaseDetails::where('purchaseid', $purchaseid)->get();

    // $grandtotal = 0;
    // $total = 0;
    // $amount = ($request->quantity * $request->rate) ;
    //     $pt = $amount - ($amount * ($request->wastep/100));
    //     $Newrate = $pt/$request->quantity;
    // foreach($data_yesterday as $row)
    // {
    //     $total = ($row->qty * $row->orate);
    //     $grandtotal += $total;
    // }

    // $balance = $data_yesterday->sum('wasol')-$data_yesterday->sum('adah');
    // $balance = $incoming - $outgoing;
        $data = PurchaseDetails::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])
        ->where('purchaseid', $purchaseid)
        ->orderBy('date')->get();
        $karcha = Karcha::where('purchaseid', $purchaseid)->get();
        //$date = Carbon::now()->format('d/m/Y');
    // dd($data);
        $pdf=PDF::loadView('pages.purchasedetails.print',compact('data','karcha','partyname'));
        
        $pdf->setPaper('A4', 'landscape');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Purchase Report ('.$partyname.').pdf');
    
    }
}
