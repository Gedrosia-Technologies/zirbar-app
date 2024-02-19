@extends('layouts.theme')
@section('content')
<?php
        $total_credit = 0;
        $total_debit = 0;
        ?>
@foreach($kanta as $data)

<?php
        if($data->type == 1)
        $total_credit += $data->amount ;
        else
        $total_debit += $data->amount ;
    ?>

@endforeach

<br>
<div class="row">
    <div class="col">
        <h3>Party Name : {{$party->name}}</h3>
    </div>
    <div class="col">
        <h3> Party ID Number : {{$party->id}}</h3>
    </div>
    {{-- <div class="col-md-12">
        <form class="form form-inline" target="_blank" action="{{route('clientkanta-print')}}" method="post">
            @csrf
            From date: <input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: <input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <input type="hidden" name="partyname" value="{{$party->name}}">
            <input type="hidden" name="partyid" value="{{$party->id}}">
            <button class="btn btn-danger" type="submit">Print</button>

        </form>
    </div> --}}
</div>
<br>

<div class="row">
    <div class="col">
        <h5>Credit : <span class="balance">{{number_format($total_credit,2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Debit : <span class="balance">{{number_format($total_debit,2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Balance : <span class="balance">{{number_format($total_credit - $total_debit,2)}}</span></h5>
    </div>
</div>

<br>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Client Kanta Toman Balance List</h6>
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
                        @if(auth()->user()->isadmin)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Amount</th>
                        @if(auth()->user()->isadmin)
                        <th>Action</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($kanta as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{date("d-m-Y", strtotime($data->date))}}</td>
                        <td>{{$data->note}}</td>
                        <td>
                            @if($data->type == 1)
                            <span class="badge badge-success">Credit</span>
                            @elseif($data->type == 2)
                            <span class="badge badge-warning">Debit</span>
                            @endif
                        </td>
                        <td>{{number_format($data->amount,2)}}</td>
                        @if(auth()->user()->isadmin)
                        <td>                   
                            <form action="{{route('clientkanta-tomin-delete')}}" onsubmit="check('Delete')" class='form-inline submit'
                                method="post">
                                @csrf
                                <input type="hidden" value="{{$data->id}}" name="id">
                                <button class="btn btn-danger submit">X</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection