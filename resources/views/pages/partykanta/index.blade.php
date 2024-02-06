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

<div class="row">
    <div class="col">
        <h3>Party Name : {{$party->name}}</h3>
    </div>
    <div class="col">
        <h3> Party ID Number : {{$party->id}}</h3>
    </div>
    <div class="col-md-12">
        <form class="form form-inline" target="_blank" action="{{route('partykanta-print')}}" method="post">
            @csrf
            From date: <input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: <input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <input type="hidden" name="partyname" value="{{$party->name}}">
            <input type="hidden" name="partyid" value="{{$party->id}}">
            <button class="btn btn-danger" type="submit">Print</button>

        </form>
    </div>

    <div class="col-6">
        <h3 class="text-center">Debit
        </button> &nbsp;<button type="button" class="btn btn-warning" data-toggle="modal"
            data-target="#exampleModal4">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </button></h3>
    </div>
    <div class="col-6">
        <h3 class="text-center">Credit <button type="button" class="btn btn-success" data-toggle="modal"
            data-target="#exampleModal">
            <i class="fa fa-plus" aria-hidden="true"></i></button></h3>
    </div>
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


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Party Kanta List</h6>
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
                            <form action="{{route('partykanta-delete')}}" onsubmit="check('Delete')" class='form-inline'
                                method="post">
                                @csrf
                                <input type="hidden" value="{{$data->id}}" name="id">
                                <button class="btn btn-danger">X</button>
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


<!-- ada modal -->
<div class="modal fade model-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Credit Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add-partykanta') }}">
                    @csrf

                    <div class="form-group">
                        <label for="">Type:</label>
                        <select name="type" class="form-control" required>
                            <option value="1">Credit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control">
                    </div>
                    <?php $accounts = \App\Models\Account::where('type',0)->get(); ?>

                    <div class="form-group">
                        <label for="">Account:</label>
                        <select name="account" class="form-control" required>
                            @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->title}} - {{$account->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Amount:</label>
                        <input type="text" name="amount" value="0" required class="amount-field form-control"
                            placeholder="Amount">
                        <small class="form-text text-center text-info"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Note:</label>
                        <input type="text" name="title" required class="form-control" placeholder="Note">
                    </div>




                    <div class="form-group">
                        <input type="hidden" name="partyid" value="{{$party->id}}">

                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">submit </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->



<!-- ada modal -->
<div class="modal fade model-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Debit Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add-partykanta') }}">
                    @csrf

                    <div class="form-group">
                        <label for="">Type:</label>
                        <select name="type" class="form-control" required>
                            <option value="2">Debit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Note:</label>
                        <input type="text" name="title" required class="form-control" placeholder="Note">
                    </div>
                    <div class="form-group">
                        <label for="">Amount:</label>
                        <input type="text" name="amount" value="0" required class="amount-field form-control"
                            placeholder="Amount">
                        <small class="form-text text-center text-info"></small>
                    </div>




                    <div class="form-group">
                        <input type="hidden" name="partyid" value="{{$party->id}}">

                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">submit </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->

@endsection