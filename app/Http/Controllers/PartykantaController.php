<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Partykanta;
use App\Models\Roznamcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;
use PdfReport;

class PartykantaController extends Controller
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

        $party = Party::find($request->partyid);
            $partykanta = new Partykanta;
            $partykanta->note = $request->input('title');
            $partykanta->partyid = $request->partyid;
            $partykanta->type = $request->type;
            $partykanta->date = $request->date;
            $partykanta->amount = $request->amount;
            $partykanta->save();

        if ($party->type == 'Client') {
            $rz = new Roznamcha();
            $rz->title = "Amount Recevied Party Kanta ID : ".$request->partyid;
            $rz->amount = $request->amount;
            $rz->type = 1;
            $rz->date = $request->date;
            $rz->save();
        }else{
            $rz = new Roznamcha();
            $rz->title = "Amount Paid Party Kanta ID : ".$request->partyid;
            $rz->amount = $request->amount;
            $rz->type = 2;
            $rz->date = $request->date;
            $rz->save();
        }

        return Redirect::back()->with('success', 'Record added ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partykanta  $partykanta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Party::where('id', $id)->first();
        $data2 = PartyKanta::where('partyid', $id)->get();
        //dd($data2);
        return view('pages.partykanta.index', ['party' => $data, 'kanta' => $data2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partykanta  $partykanta
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        // dd($request->input('type'));
        $data = Partykanta::where('id', $request->id)->first();
        return view('pages.partykanta.edit', ['data' => $data, 'type' => $request->type]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partykanta  $partykanta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->input('type'));

        if ($request->type == 1) {
            $partykanta = Partykanta::find($request->id);
            $partykanta->title = $request->input('title');
            $partykanta->partyid = $request->partyid;
            $partykanta->adah = $request->amount;
            $partykanta->date = $request->date;
            $partykanta->save();
        }
        if ($request->type == 3) {
            $partykanta = Partykanta::find($request->id);
            $partykanta->title = $request->input('title');
            $partykanta->partyid = $request->partyid;
            $partykanta->wasol = $request->amount;
            $partykanta->date = $request->date;
            $partykanta->save();
        }
        if ($request->type == 2) {

            $partykanta = Partykanta::find($request->id);
            $partykanta->partyid = $request->partyid;
            $partykanta->trucknumber = $request->trucknumber;
            $partykanta->mazdori = $request->mazdori;
            $partykanta->karcha = $request->karcha;
            $partykanta->gate = $request->gate;
            $partykanta->item = $request->item;
            $partykanta->title = $request->title;
            $partykanta->rate = $request->rate;
            $partykanta->date = $request->date;

            $total = $request->gate + $request->mazdori + $request->karcha + ($request->item * $request->rate);
            $partykanta->wasol = $total;
            // dd($total);
            $partykanta->save();

        }

        // $reditect = "/partykanta".'/'.$request->partyid.'';
        return redirect('/Partykanta/' . $request->partyid)->with('success', 'record updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partykanta  $partykanta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = Partykanta::find($request->id);
        $data->delete();
        return Redirect::back()->with('danger', 'Record Delete');
    }
    public function displayReport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $partyname = $request->input('partyname');
        $partyid = $request->input('partyid');

        $title = 'Party Kanta Report'; // Report title

        $queryBuilder = Partykanta::select(['*']) // Do some querying..
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('partyid', $partyid)
            ->orderBy('date');
        // $party = Partykanta::find($request->id);
        $meta = [ // For displaying filters description on header
            'Date:' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
            'Party' => $partyname,
            'Total Balance' => $queryBuilder->sum('wasol') - $queryBuilder->sum('adah'),
        ];

        $credit = 0;
        $debit = 0;

        $columns = [ // Set Column to be displayed
            'Date',
            'Truck#' => 'trucknumber',
            'Unit' => 'item',
            'Title' => 'title',
            'Rate' => 'rate',
            'Rasta-Karcha' => 'karcha',
            'Mazdori' => 'mazdori',
            'Gate-Karcha' => 'gate', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            'Debit' => function ($result) { // You can do if statement or any action do you want inside this closure
                if ($result->adah == '') {
                    global $debit;
                    $debit += $result->wasol;
                    return $result->wasol;
                }
            },
            'Credit' => function ($result) {
                global $credit; // You can do if statement or any action do you want inside this closure
                $credit += $result->adah;
                return $result->adah;
            },
            'Balance' => function ($result) { // You can do if statement or any action do you want inside this closure
                global $debit, $credit;
                $balance = (int) $debit - (int) $credit;
                return $balance;
            },

        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns, $credit, $debit)
            ->editColumn('Date', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function ($result) {
                    return date('d-m-y', strtotime($result->date));
                },
                'class' => 'left',
            ])
            ->editColumns(['Credit', 'Debit', 'Balance'], [ // Mass edit column
                'class' => 'right bold',
            ])
            ->editColumns(['Truck#', 'Unit'], [ // Mass edit column
                'class' => 'right',
            ])
            ->editColumns(['Title'], [ // Mass edit column
                'class' => 'center',
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'Credit' => 'point',
                'Debit' => 'point',
                // 'Balance' => 'point' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->setOrientation('landscape')
        //->setPaper('a4')
        // ->limit(1000) // Limit record to be showed
            ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
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
        $data_yesterday = Partykanta::where('partyid', $partyid)->whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();

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
        $data = Partykanta::select(['*']) // Do some querying..
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('partyid', $partyid)
            ->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.partykanta.print', compact('data', 'fromDate', 'toDate', 'balance', 'partyname'));

        $pdf->setPaper('A4', 'landscape');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Party Kanta (' . $partyname . ') ' . $fromDate . ' to ' . $toDate . '.pdf');

    }

}
