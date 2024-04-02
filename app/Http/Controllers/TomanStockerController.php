<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TomanStocker;
use App\Models\TomanStockerKanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TomanStockerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  
        $data = TomanStocker::all();
        return view('pages.toman_stockers.index',['party' => $data]);
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
        $stocker = new TomanStocker();
        $stocker->name = $request->title;
        $stocker->save();
        return Redirect::back()->with('msg', 'Toman Stocker added successfully!');
    }

    
    public function destroy(Request $request)
    {
         //
         $data = TomanStocker::find($request->id);
         $kanta = TomanStockerKanta::where('stockerid', $request->id)->get();
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
