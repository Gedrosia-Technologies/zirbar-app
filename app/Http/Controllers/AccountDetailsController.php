<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Account_details;
use App\Models\Roznamcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PdfReport;
use PDF;


class AccountDetailsController extends Controller
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
        $account_details = new Account_details();
        $account_details->account_id = $request->account;
        $account_details->description= $request->description;
        $account_details->type = $request->type;
        $account_details->date = $request->date;
        $account_details->amount = $request->amount;
        $account_details->save();

        if($request->type == 0){
            $table = new Roznamcha();
            $table->title = 'Account id('.$request->account.') Balance Credit';
            $table->amount= $request->amount;
            $table->type = 1;
            $table->date = $request->date;
            $table->save();
        }
        if($request->type == 1){
            $table = new Roznamcha();
            $table->title = 'Account id('.$request->account.') Balance Debit';
            $table->amount= $request->amount;
            $table->type = 2;
            $table->date = $request->date;
            $table->save();
        }
        return Redirect::back()->with('success', 'records updated');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account_details  $account_details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Account::where('id', $id)->first();
        $data2 = Account_details::where('account_id', $id)->get();
        //dd($data2);
        return view('pages.account_details.index',['account' => $data,'details' =>$data2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account_details  $account_details
     * @return \Illuminate\Http\Response
     */
    public function edit(Account_details $account_details)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account_details  $account_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account_details $account_details)
    {
        //
        $table = Account_details::find($request->id);
        $table->description = $request->des;
        $table->amount = $request->amount;
        $table->date = $request->date;
        $table->save();

        return Redirect::back()->with('info', 'records updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account_details  $account_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
          $table = Account_details::find($request->id);
          $table->delete();

        return Redirect::back()->with('danger', 'records Removed');
    }

    public function displayReport(Request $request)
{
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $accounttitle = $request->input('accounttitle');
    $accountdescription = $request->input('accountdescription');
    $accountid = $request->input('accountid');
   // $data = Roznamcha::select(['*']) // Do some querying..
   // ->whereBetween('date', [$fromDate, $toDate])->get();
   $yesterday = date("Y-m-d", strtotime(  $fromDate .'-1 days' ) );
   $data_credit = Account_details::where('account_id', $accountid)->where('type', 0)->whereDate('date','>','2000-01-01')->whereDate('date','<=', $yesterday)->get();
   $data_debit = Account_details::where('account_id', $accountid)->where('type', 1)->whereDate('date','>','2000-01-01')->whereDate('date','<=', $yesterday)->get();

   $balance = $data_credit->sum('amount')-$data_debit->sum('amount');
       $data = Account_details::select(['*']) // Do some querying..
       ->whereBetween('date', [$fromDate, $toDate])
       ->where('account_id', $accountid)
       ->orderBy('date')->get();
    //$date = Carbon::now()->format('d/m/Y');
  // dd($data);
       $pdf=PDF::loadView('pages.Account_details.print',compact('data','fromDate','toDate','balance','accounttitle', 'accountdescription'));
      
       $pdf->setPaper('A4', 'potrait');
      // $dompdf->set_base_path("/www/public/css/");
       return $pdf->stream('Account Details ('.$accounttitle.') '.$fromDate.' to '.$toDate.'.pdf');
   
   }
}
