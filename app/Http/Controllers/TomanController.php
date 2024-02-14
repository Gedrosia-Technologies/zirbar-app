<?php

namespace App\Http\Controllers;

use App\Models\Toman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use PdfReport;

class TomanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data = Toman::all();
        $incoming = 0;
        $outgoing = 0;
        foreach ($data as $row) {
            if ($row->type == 1) {
                $incoming += $row->amount;
            }
            if ($row->type == 2) {
                $outgoing += $row->amount;
            }
        }

        $balance = $outgoing - $incoming;

        return view('pages.toman_accounts.index', ['data' => $data, 'balance' => $balance]);
    }


    public function date(Request $request)
    {
        //
        $yesterday = date("Y-m-d", strtotime($request->date . '-1 days'));
        $data_yesterday = Toman::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
        $incoming = 0;
        $outgoing = 0;
        foreach ($data_yesterday as $row) {
            if ($row->type == 1) {
                $incoming += $row->amount;
            }
            if ($row->type == 2) {
                $outgoing += $row->amount;
            }
        }

        $balance = $incoming - $outgoing;

        $today = Toman::whereDate('date', date("Y-m-d", strtotime($request->date)))->get();
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
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function show(Toman $toman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function edit(Toman $toman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Toman $toman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Toman  $toman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = Toman::find($request->id);
        $data->delete();
        return redirect('/TomanAccounts')->with('danger', 'Record Delete');

    }


    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = Toman::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
        $incoming = 0;
        $outgoing = 0;
        foreach ($data_yesterday as $row) {
            if ($row->type == 1) {
                $incoming += $row->amount;
            }
            if ($row->type == 2) {
                $outgoing += $row->amount;
            }
        }

        $balance = $incoming - $outgoing;
        $data = Toman::whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.toman_accounts.print', compact('data', 'fromDate', 'toDate', 'balance'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Toman Accounts ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}
