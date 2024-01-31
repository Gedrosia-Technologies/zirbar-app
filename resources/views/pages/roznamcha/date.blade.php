@extends('layouts.theme')
@section('content')

<?php
$total_incoming = 0;
$total_outgoing = 0;

?>
@foreach($data as $row)

@if($row->type == 1)
<?php
        $total_incoming += $row->amount;
        ?>
@endif
@if($row->type == 2)
<?php
        $total_outgoing += $row->amount;
        ?>
@endif


@endforeach


<div class="row">

    <div class="col-sm">
        <h1><i class="fas fa-money-check-alt"></i> Roznamcha</h1>
        <h3 class="text-primary">Date: {{date("d-m-Y", strtotime($view_date))}}</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-7">
        <form class="form form-inline" target="_blank" action="{{route('roznamcha-print')}}" method="post">
            @csrf
            From date: &nbsp;<input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: &nbsp;<input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <button class="btn btn-danger" type="submit">Print</button>
        </form>
    </div>
    <div class="col-5">
        <form class="form form-inline" action="{{route('roznamcha-get-date')}}" method="post">
            @csrf
            Goto Date: &nbsp;<input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control"> &nbsp;
            <button class="btn btn-warning" type="submit">Fetch</button>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <h5 class="text-muted">Previous Balance: <span class="balance text-success">{{$balance}}</span></h5>
    </div>
    <div class="col">
        <h5>Total incoming Amount : <span class="balance">{{$total_incoming}}</span></h5>
    </div>
    <div class="col">
        <h5>Total Amount Plus Balance : <span class="balance">{{$balance + $total_incoming}}</span></h5>
    </div>
    <div class="col">
        <h5>Total Outgoing Amount : <span class="balance">{{$total_outgoing}}</span></h5>
    </div>
    <div class="col">
        <h5>Today Balance Amount : <span
            class="balance">{{($balance + $total_incoming) - $total_outgoing}}</span></h5>
    </div>
</div>
<hr>

<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Roznamcha List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($data as $row)
                    <tr>
                        <td>{{$row->id}}</td>
                        <td>{{date("d-m-Y", strtotime($row->date))}}</td>
                        <td>{{$row->title}}</td>
                        <td>
                            @if($row->type == 1)
                            <span class="badge badge-success">Credit</span>
                            @elseif($row->type == 2)
                            <span class="badge badge-warning">Debit</span>
                            @endif
                        </td>
                        <td>{{$row->amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection