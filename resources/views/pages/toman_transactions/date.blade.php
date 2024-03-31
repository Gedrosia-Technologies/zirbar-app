@extends('layouts.theme')
@section('content')
{{-- PKR --}}
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

{{-- Toman --}}
<?php
$total_incomingtom = 0;
$total_outgoingtom = 0;
$balancetom = 0;

?>
@foreach($data as $row)

@if($row->type == 1)
<?php
        $total_incomingtom += $row->toman;
        ?>
@endif
@if($row->type == 2)
<?php
        $total_outgoingtom += $row->toman;
        ?>
@endif


@endforeach

<?php $balancetom = $total_incomingtom - $total_outgoingtom ?>

<div class="row">

    <div class="col-sm">
        <h1><i class="fas fa-money-check-alt"></i> Toman Accounts Details</h1>
    </div>
</div>
<div class="row">
    <div class="col-7">
        <form class="form form-inline" target="_blank" action="{{route('roznamcha-print')}}" method="post">
            @csrf
            From date: &nbsp;<input type="date" name="from_date" value="{{date('Y-m-d')}}" required
                class="form-control">
            &nbsp;
            To date: &nbsp;<input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <button class="btn btn-danger" type="submit">Print</button>
        </form>
    </div>
    <div class="col-5">
        <form class="form form-inline" action="{{route('roznamcha-get-date')}}" method="post">
            @csrf
            Goto Date: &nbsp;<input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <button class="btn btn-warning" type="submit">Fetch</button>
        </form>
        <a href="/TomanAccounts" class="btn btn-danger">Reset Date</a>
    </div>
</div>
<hr>
<h3 class="text-center text-primary">PKR</h3>
<div class="row">
    <div class="col">
        <h5>incoming : <span class="balance">{{number_format($total_incoming,2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Outgoing : <span class="balance">{{number_format($total_outgoing,2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Balance : <span class="balance">{{number_format($balance,2)}}</span></h5>
    </div>
</div>
<hr>

<hr>
<h3 class="text-center text-primary">Toman</h3>
<div class="row">
    <div class="col">
        <h5>incoming : <span class="balance">{{number_format($total_incomingtom,2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Outgoing : <span class="balance">{{number_format($total_outgoingtom,2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Balance : <span class="balance">{{number_format($balancetom,2)}}</span></h5>
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
                        <th>Type</th>
                        <th>Party</th>
                        <th>Account Type</th>
                        <th>Toman</th>
                        <th>Rate</th>
                        <th>Amount PKR</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Party</th>
                        <th>Account Type</th>
                        <th>Toman</th>
                        <th>Rate</th>
                        <th>Amount PKR</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($data as $row)
                    <tr>
                        <td>{{$row->id}}</td>
                        <td>{{date("d-m-Y", strtotime($row->date))}}</td>
                        <td>
                            @if($row->type == 1)
                            <span class="badge badge-success">Purchase</span>
                            @elseif($row->type == 2)
                            <span class="badge badge-warning">Sell</span>
                            @endif
                        </td>
                        <td>
                            @if($row->type == 1)
                                <?php $party =  \App\Models\TomanSupplier::where('id', $row->partyid)->first(); ?>
                                {{$party->name}}
                            @elseif($row->type == 2)
                                <?php $party =  \App\Models\TomanClient::where('id', $row->partyid)->first(); ?>
                                {{$party->name}}
                            @endif
                        </td>
                        <td>
                            @if($row->acctype == 1)
                            <span class="badge badge-success">Credit</span>
                            @elseif($row->acctype == 2)
                            <span class="badge badge-warning">Debit</span>
                            @endif
                        </td>
                        <td>{{number_format($row->toman)}}</td>
                        <td>{{number_format($row->rate)}}</td>
                        <td>{{number_format($row->amount)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>











@endsection


@section('script')




@endsection