<?php

namespace App\Http\Controllers;

use App\Models\Roznamcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;
use PdfReport;

class RoznamchaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = Roznamcha::all();
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

        $balance = $incoming - $outgoing;

        return view('pages.roznamcha.index', ['data' => $data, 'balance' => $balance]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function date(Request $request)
    {
        //
        $yesterday = date("Y-m-d", strtotime($request->date . '-1 days'));
        $data_yesterday = Roznamcha::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
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

        $today = Roznamcha::whereDate('date', date("Y-m-d", strtotime($request->date)))->get();
        return view('pages.roznamcha.date', ['view_date' => $request->date, 'data' => $today, 'balance' => $balance]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = new Roznamcha;
        $table->title = $request->title;
        $table->amount = $request->amount;
        $table->type = $request->type;
        $table->date = $request->date;
        $table->save();

        return Redirect::back()->with('success', 'added new record');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roznamcha  $roznamcha
     * @return \Illuminate\Http\Response
     */
    public function show(Roznamcha $roznamcha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roznamcha  $roznamcha
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $data = Roznamcha::where('id', $request->id)->first();
        return view('pages.roznamcha.edit', ['data' => $data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roznamcha  $roznamcha
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roznamcha $roznamcha)
    {
        //

        if ($request->type == 1) {

            $table = Roznamcha::find($request->id);
            $table->title = $request->title;
            $table->rate = $request->rate;
            $table->unit = $request->unit;
            $total_amount = $request->rate * $request->unit;
            $table->amount = $total_amount;
            $table->type = $request->type;
            $table->date = $request->date;
            $table->save();
        }

        //for storing money to money incoming
        if ($request->type == 2) {
            $table = Roznamcha::find($request->id);
            $table->title = $request->title;
            $table->amount = $request->amount;
            $table->type = $request->type;
            $table->date = $request->date;
            $table->save();
        }

        //for storing per item in incoming
        if ($request->type == 3) {

            $table = Roznamcha::find($request->id);
            $table->title = $request->title;
            $table->rate = $request->rate;
            $table->unit = $request->unit;
            $total_amount = $request->rate * $request->unit;
            $table->amount = $total_amount;
            $table->type = $request->type;
            $table->date = $request->date;
            $table->save();
        }

        //for storing money to money incoming
        if ($request->type == 4) {
            $table = Roznamcha::find($request->id);
            $table->title = $request->title;
            $table->amount = $request->amount;
            $table->type = $request->type;
            $table->date = $request->date;
            $table->save();
        }
        return redirect('/Roznamcha')->with('success', 'updated record');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roznamcha  $roznamcha
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = Roznamcha::find($request->id);
        $data->delete();
        return redirect('/Roznamcha')->with('danger', 'Record Delete');

    }

    public function displayReport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $sortBy = $request->input('sort_by');

        $title = 'RozNaamcha Report'; // Report title

        $meta = [ // For displaying filters description on header
            'Date:' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
        ];

        $queryBuilder = Roznamcha::select(['*']) // Do some querying..
            ->whereBetween('date', [$fromDate, $toDate]);
        // ->orderBy($sortBy);

        $columns = [ // Set Column to be displayed
            'Date',
            //'Truck#' => 'trucknumber',
            'Title' => 'title',
            // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
            'Unit' => 'unit',
            'Rate' => 'rate',
            'Credit' => function ($result) { // You can do if statement or any action do you want inside this closure
                if ($result->type == 1 || $result->type == 2) {
                    return $result->amount;
                }
            },
            'Debit' => function ($result) { // You can do if statement or any action do you want inside this closure
                if ($result->type == 3 || $result->type == 4) {
                    return $result->amount;
                }
            },
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
            ->editColumn('Date', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function ($result) {
                    return date('d-n-Y', strtotime($result->date));
                },
                'class' => 'left',
            ])
            ->editColumns(['Credit', 'Debit'], [ // Mass edit column
                'class' => 'right bold',
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'Credit' => 'point',
                'Debit' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])

        // ->limit(1000) // Limit record to be showed
            ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = Roznamcha::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
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
        $data = Roznamcha::whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.roznamcha.print', compact('data', 'fromDate', 'toDate', 'balance'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Roznamcha ' . $fromDate . ' to ' . $toDate . '.pdf');

    }

}
