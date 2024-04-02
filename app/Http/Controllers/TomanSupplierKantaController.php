<?php

namespace App\Http\Controllers;

use App\Models\TomanSupplierKanta;
use App\Http\Controllers\Controller;
use App\Models\TomanSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class TomanSupplierKantaController extends Controller
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

            $partykanta = new TomanSupplierKanta();
            $partykanta->note = $request->input('title');
            $partykanta->supplierid = $request->partyid;
            $partykanta->type = $request->type;
            $partykanta->date = $request->date;
            $partykanta->amount = $request->amount;
            $partykanta->save();

        return Redirect::back()->with('success', 'Record added ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TomanSupplier::where('id', $id)->first();
        $data2 = TomanSupplierKanta::where('supplierid', $id)->get();
        //dd($data2);
        return view('pages.tomansupplierkanta.index', ['party' => $data, 'kanta' => $data2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanSupplierKanta $tomanSupplierKanta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanSupplierKanta $tomanSupplierKanta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanSupplierKanta  $tomanSupplierKanta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         //
         $data = TomanSupplierKanta::find($request->id);
         $data->delete();
         return Redirect::back()->with('danger', 'Record Deleted');
    }
    
    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = TomanSupplierKanta::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
        $pkrIncoming = 0;
        $pkrOutgoing = 0;
        foreach ($data_yesterday as $row) {
            if ($row->type == 1) {
                $pkrOutgoing += $row->amount;
            }
            if ($row->type == 2) {
                $pkrIncoming += $row->amount;
            }
        }

        $balance = $pkrOutgoing - $pkrIncoming;
        $data = TomanSupplierKanta::whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();
        $partyname = $request->partyname;
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.tomansupplierkanta.print', compact('data', 'fromDate', 'toDate', 'balance', 'partyname'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Toman Transactions ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}