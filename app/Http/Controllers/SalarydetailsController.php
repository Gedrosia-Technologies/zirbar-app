<?php

namespace App\Http\Controllers;

use App\Models\Roznamcha;
use App\Models\salary;
use App\Models\salarydetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class SalarydetailsController extends Controller
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
    public function PaySalary(Request $request)
    {
        //
        ///crediting amount of salary based Salary AMount
        $salarydetails = new salarydetails;
        $salarydetails->note = "Salary Amount Credit";
        $salarydetails->salaryid = $request->salaryid;
        $salarydetails->type = 1;
        $salarydetails->date = date("Y-d-m");
        $salarydetails->amount = $request->amount;
        $salarydetails->save();

        //debiting in roznachma
        $table = new Roznamcha();
        $table->title = 'Account id(' . $request->salaryid . ') Salary Paid';
        $table->amount = $request->amount;
        $table->type = 2;
        $table->date = date("Y-d-m");
        $table->save();

        $roz_id = $table->id;

        $salarydetails = new salarydetails;
        $salarydetails->note = "Salary Paid";
        $salarydetails->salaryid = $request->salaryid;
        $salarydetails->type = 2;
        $salarydetails->roz_id = $roz_id;
        $salarydetails->date = date("Y-d-m");
        $salarydetails->amount = $request->amount;
        $salarydetails->save();

        return Redirect::back()->with('success', 'Salary Paid ');
    }

    public function store(Request $request)
    {
        //
        $salarydetails = new salarydetails;
        $salarydetails->note = $request->input('title');
        $salarydetails->salaryid = $request->salaryid;
        $salarydetails->type = $request->type;
        $salarydetails->date = $request->date;
        $salarydetails->amount = $request->amount;
        $salarydetails->save();
        if ($request->type == 2) {
            $table = new Roznamcha();
            $table->title = 'Account id(' . $request->salaryid . ') Salary Paid';
            $table->amount = $request->amount;
            $table->type = 2;
            $table->date = $request->date;
            $table->save();
        }

        return Redirect::back()->with('success', 'Record added ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\salarydetails  $salarydetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = salary::where('id', $id)->first();
        $data2 = salarydetails::where('salaryid', $id)->get();
        //dd($data2);
        return view('pages.salary_details.index', ['salary' => $data, 'details' => $data2]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\salarydetails  $salarydetails
     * @return \Illuminate\Http\Response
     */
    public function edit(salarydetails $salarydetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\salarydetails  $salarydetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sd = salarydetails::find($request->id);
        // dd($sd);
        if ($sd->type == 2) {
            $roznamcha = Roznamcha::find($sd->roz_id);
            $roznamcha->amount = $request->amount;
            $roznamcha->date = $request->date;
            $roznamcha->save();
        }
        $sd->note = $request->input('title');
        $sd->date = $request->date;
        $sd->amount = $request->amount;
        $sd->save();

        return Redirect::back()->with('info', 'record updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\salarydetails  $salarydetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sd = salarydetails::find($request->id);
        if ($sd->type == 2) {
            $roznamcha = Roznamcha::find($sd->roz_id);
            $roznamcha->delete();
        }
        $sd->delete();

        return Redirect::back()->with('danger', 'Record Removed');

    }
    public function displayReport2(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $salaryname = $request->input('salaryname');
        $salaryid = $request->input('salaryid');

        $yesterday = date("Y-m-d", strtotime($fromDate . '-1 days'));
        $data_yesterday = salarydetails::whereDate('date', '>', '2000-01-01')->whereDate('date', '<=', $yesterday)->get();
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

        $details = salarydetails::select(['*'])
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('salaryid', $salaryid)
            ->orderBy('date')->get();

        // $karcha = salary::where('purchaseid', $purchaseid)->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $pdf = PDF::loadView('pages.salary_details.print', compact('balance', 'details', 'salaryname', 'fromDate', 'toDate'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Salary.pdf');

    }
}
