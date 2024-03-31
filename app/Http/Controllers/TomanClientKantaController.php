<?php

namespace App\Http\Controllers;

use App\Models\TomanClient;
use App\Models\TomanClientKanta;
use App\Models\ClientTomanBalance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;
use PdfReport;

class TomanClientKantaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        if ($request->type == 1) {
            $partykanta = new TomanClientKanta;
            $partykanta->note = $request->input('title');
            $partykanta->clientid = $request->partyid;
            $partykanta->type = $request->type;
            $partykanta->date = $request->date;
            $partykanta->amount = $request->amount;
            $partykanta->save();

        }
        //debit
        if ($request->type == 2) {
            $partykanta = new TomanClientKanta;
            $partykanta->note = $request->input('title');
            $partykanta->clientid = $request->partyid;
            $partykanta->type = $request->type;
            $partykanta->date = $request->date;
            $partykanta->amount = $request->amount;
            $partykanta->save();
        }

        return Redirect::back()->with('success', 'Record added ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanClientKanta  $tomanClientKanta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $toman_data = ClientTomanBalance::where('clientid',$id)->get();
        $toman_balance = 0;
        foreach ($toman_data as $d) {
                if($d->type == 1)
                {
                    $toman_balance += $d->amount;
                }else{
                    $toman_balance -= $d->amount;
                }
        }
        $data = TomanClient::where('id', $id)->first();
        $data2 = TomanClientKanta::where('clientid', $id)->get();
        //dd($data2);
        return view('pages.tomanclientkanta.index', ['party' => $data, 'kanta' => $data2,'toman_balance'=>$toman_balance ]);
    }


    public function toman_show($id)
    {
        $toman_data = ClientTomanBalance::where('clientid',$id)->get();
       
        $data = TomanClient::where('id', $id)->first();

        return view('pages.tomanclientkanta.balance', ['party' => $data, 'kanta' => $toman_data ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanClientKanta  $tomanClientKanta
     * @return \Illuminate\Http\Response
     */
    public function update_toman_balance(Request $request)
    {

            $partykanta = new ClientTomanBalance;
            $partykanta->clientid = $request->partyid;
            $partykanta->type = $request->type;
            $partykanta->note = $request->note;
            $partykanta->date = date('Y-m-d');
            $partykanta->amount = $request->amount;
            $partykanta->save();

             return Redirect::back()->with('success', 'Record Added ');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanClientKanta  $tomanClientKanta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanClientKanta $tomanClientKanta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanClientKanta  $tomanClientKanta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = TomanClientKanta::find($request->id);
        $data->delete();
        return Redirect::back()->with('danger', 'Record Deleted');
    }
    public function toman_balance_delete(Request $request)
    {
        //
        $data = ClientTomanBalance::find($request->id);
        $data->delete();
        return Redirect::back()->with('danger', 'Record Deleted');
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
        $data_yesterday = TomanClientKanta::where('clientid', $partyid)->whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();

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
        $data = TomanClientKanta::select(['*']) // Do some querying..
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('clientid', $partyid)
            ->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.tomanclientkanta.print', compact('data', 'fromDate', 'toDate', 'balance', 'partyname'));

        $pdf->setPaper('A4', 'landscape');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Toman Client Kanta (' . $partyname . ') ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}
