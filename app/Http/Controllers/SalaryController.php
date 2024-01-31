<?php

namespace App\Http\Controllers;

use App\Models\salary;
use App\Models\salarydetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = salary::all();
        return view('pages.salary.index', ['salary' => $data]);
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
        $salary = new salary();
        $salary->name = $request->name;
        $salary->fathername = $request->fname;
        $salary->address = $request->address;
        $salary->cnic = $request->cnic;
        $salary->job = $request->job;
        $salary->amount = $request->amount;
        $salary->save();
        return Redirect::back()->with('msg', 'Person added to salary record');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(salary $salary)
    {
        //
    }
    public function displayReport2(Request $request)
    {
        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $partyname = $request->input('partyname');
        // $purchaseid = $request->input('id');

        $accounts = salary::all(); // Do some querying..
        // Do some querying..

        $SalaryData = [];
        foreach ($accounts as $account) {
            $details = salarydetails::where('salaryid', $account->id)->whereMonth('date', Carbon::now()->month)->get();
            $advance = 0;
            foreach ($details as $detail) {
                if ($detail->type == 2) {
                    $advance = $advance + $detail->amount;
                }
            }

            array_push($SalaryData, (object) array(
                'name' => $account->name,
                'cnic' => $account->cnic,
                'job' => $account->job,
                'salary' => $account->amount,
                'advance' => $advance,
            ));
        }
        //  var_dump($SalaryData);
        // ->whereBetween('date', [$fromDate, $toDate])
        // ->where('purchaseid', $purchaseid)
        // ->orderBy('amount')->get();
        // $karcha = salary::where('purchaseid', $purchaseid)->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.salary.print', compact('SalaryData'));

        $pdf->setPaper('A4', 'landscape');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Salary.pdf');

    }
}
