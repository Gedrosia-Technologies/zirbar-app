<?php

namespace App\Http\Controllers;

use App\Models\TomanSupplier;
use App\Http\Controllers\Controller;
use App\Models\TomanSupplierKanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TomanSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $data = TomanSupplier::all();
        return view('pages.toman_suppliers.index',['party' => $data]);
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
        $client = new TomanSupplier();
        $client->name = $request->title;
        $client->save();
        return Redirect::back()->with('msg', 'The Message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(TomanSupplier $tomanSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanSupplier $tomanSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanSupplier  $tomanSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanSupplier $tomanSupplier)
    {
        //
    }

 
    public function destroy(Request $request)
    {
         //
         $data = TomanSupplier::find($request->id);
         $kanta = TomanSupplierKanta::where('supplierid', $request->id)->get();
        //  $balance = 0;
        //  foreach ($kanta as $record) {

        //     if($record->type == 1) {
        //         $balance += $record->amount;
        //     }
        //     else {
        //         $balance -= $record->amount ;
        //     }
        //  }
        //  if($balance > 0) {
        //     return Redirect::back()->with('danger', 'Record can not deleted. Because Stocker still holds Balance.');
        // }else {
            $data->delete();
            foreach ($kanta as $record) {
                $record->delete();
            }
        // }
         return Redirect::back()->with('danger', 'Record Deleted');
    }
}