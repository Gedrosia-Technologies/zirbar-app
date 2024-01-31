<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Stock_detail;
use Illuminate\Http\Request;

class StockDetailController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock_detail  $stock_detail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Stock::where('id', $id)->first();
        $data2 = Stock_detail::where('stockid', $id)->get();//
        return view('pages.stockdetails.index',['stock' => $data,'list' =>$data2]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock_detail  $stock_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock_detail $stock_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock_detail  $stock_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock_detail $stock_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock_detail  $stock_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock_detail $stock_detail)
    {
        //
    }
}
