<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Shipment;
use App\Models\shipmentdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PDF;

class PagesController extends Controller
{
    //
    public function index()
    {

    }
    public function box()
    {
        $data = Box::all();
        $shipment = Shipment::all();
        return view('pages.boxes.index', ['box' => $data, 'shipments' => $shipment]);
    }
    public function shipment()
    {
        $shipment = Shipment::all();
        return view('pages.shipment.index', ['shipments' => $shipment]);
    }
    public function newshipment(Request $request)
    {
        $table = new Shipment();
        $table->title = $request->title;
        $table->date = $request->date;
        $table->save();
        return Redirect::back()->with('success', 'New Shipment Added');
    }

    public function addshipment(Request $request)
    {
        //dd()
        $boxRow = Box::where('id', $request->id)->first();
        $table = new shipmentdetail();
        $table->shipid = $request->shipment; //this shipment
        $table->rate = $request->rate;
        $table->boxid = $request->boxid;
        $table->qty = $request->quantity;
        $table->amount = $request->rate * $request->quantity;
        $table->fid = $boxRow->fid;
        $table->date = $request->date;
        $table->save();

        $checkQty = $boxRow->qty - $request->quantity;
        if ($checkQty == 0) {
            $update = Box::find($request->id);
            $update->delete();
        } else {
            $update = Box::find($request->id);
            $update->qty = $checkQty;
            $update->amount = $checkQty * $boxRow->rate;
            $update->save();
        }
        return Redirect::back()->with('success', 'New Shipment Added');

    }
    public function displayReport2(Request $request)
    {
        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $data = Roznamcha::select(['*']) // Do some querying..
        // ->whereBetween('date', [$fromDate, $toDate])->get();
        //    $yesterday = date("Y-m-d", strtotime(  $fromDate .'-1 days' ) );
        //    $data_yesterday = inventory::whereDate('date','>','2000-01-01')->whereDate('date','<=', $yesterday)->get();

        $data = Box::all();

        // $data = inventory::whereBetween('date', [$fromDate, $toDate])->orderBy('date')->get();
        //$date = Carbon::now()->format('d/m/Y');
        // dd($data);
        $date = date('d-m-y h:i:s');
        $pdf = PDF::loadView('pages.boxes.print', compact('data', 'date'));

        $pdf->setPaper('A4', 'portrait');
        // $dompdf->set_base_path("/www/public/css/");
        return $pdf->stream('Box-Inventory ' . $date . '.pdf');

    }

}
