@extends('layouts.theme')
@section('content')
<br>
<?php


?>
<div class="row">
    <div class="col-md-7">
        {{-- <form class="form form-inline" target="_blank" action="{{route('purchase-details-print')}}" method="post"> --}}
            {{-- @csrf --}}
            <!-- From date: <input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: <input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp; -->
            {{-- <button class="btn btn-info" type="submit">Print</button> --}}
        {{-- </form> --}}
    </div>
</div>
<hr>

<!-- Purchase List -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Purchases Details</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Purchase ID</th>
                        <th>Sale ID</th>
                        <th>Liters</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Purchase ID</th>
                        <th>Sale ID</th>
                        <th>Liters</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($list as $data)
                    <tr>
                             <td>{{$data->id}}</td>
                     
                        <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                        <td>{{$data->purchaseid}}</td>
                        <td>{{$data->saleid}}</td>
                        <td>{{$data->liters}}</td>
                        <td></td>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr>


@endsection