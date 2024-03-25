<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TomanStocker;
use App\Models\TomanStockerKanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;
use PdfReport;


class TomanStockerKantaController extends Controller
{
    
    public function show($id)
    {
        $data = TomanStocker::where('id', $id)->first();
        $data2 = TomanStockerKanta::where('stockerid', $id)->get();
        return view('pages.toman_stocker_kanta.index', ['party' => $data, 'kanta' => $data2]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //debit = 2
        $partykanta = new TomanStockerKanta();
        $partykanta->note = $request->input('title');
        $partykanta->stockerid = $request->partyid;
        $partykanta->type = $request->type;
        $partykanta->date = $request->date;
        $partykanta->amount = $request->amount;
        $partykanta->save();

        return Redirect::back()->with('success', 'Record added ');
    }

    
    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $partyname = $request->input('partyname');
        $partyid = $request->input('partyid');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = TomanStockerKanta::where('stockerid', $partyid)->whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();

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

        // $balance = $data_yesterday->sum('wasol')-$data_yesterday->sum('adah');
        $balance = $incoming - $outgoing;
        $data = TomanStockerKanta::select(['*']) // Do some querying..
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('stockerid', $partyid)
            ->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.toman_stocker_kanta.print', compact('data', 'fromDate', 'toDate', 'balance', 'partyname'));

        $pdf->setPaper('A4', 'landscape');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Toman Stocker Kanta (' . $partyname . ') ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}
