<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Roznamcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Expenditure::all();
        return view('pages.expenditure.index', ['data' => $data]);
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

        $table = new Roznamcha;
        $table->title = "Expendiure | " . $request->detail;
        $table->amount = $request->amount;
        $table->type = 2;
        $table->date = $request->date;
        $table->save();

        $roz_id = $table->id;

        $table = new Expenditure();
        $table->date = ($request->date);
        $table->roz_id = ($roz_id);
        $table->amount = ($request->amount);
        $table->details = ($request->detail);
        $table->save();
        return Redirect::back()->with('success', 'Added Item to expenditure');
    }

    public function date(Request $request)
    {
        $today = Expenditure::whereDate('date', date("Y-m-d", strtotime($request->date)))->get();
        return view('pages.expenditure.index', ['data' => $today]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show(Expenditure $expenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenditure $expenditure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $table = Roznamcha::find($request->roz_id);
        $table->title = "Expendiure | " . $request->detail;
        $table->amount = $request->amount;
        $table->type = 2;
        $table->date = $request->date;
        $table->save();

        $roz_id = $table->id;

        $table = Expenditure::find($request->id);
        $table->date = ($request->date);
        $table->roz_id = ($roz_id);
        $table->amount = ($request->amount);
        $table->details = ($request->detail);
        $table->save();
        return Redirect::back()->with('success', 'Updated Item from expenditure');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ex = Expenditure::find($request->id);
        $rozNamcha = Roznamcha::find($ex->roz_id);
        $ex->delete();
        $rozNamcha->delete();
        return back()->with('danger', 'Removed Item from expenditure');

    }

    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = Expenditure::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
        $data = Expenditure::whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.expenditure.print', compact('data', 'fromDate', 'toDate'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Expenditure ' . $fromDate . ' to ' . $toDate . '.pdf');

    }
}
