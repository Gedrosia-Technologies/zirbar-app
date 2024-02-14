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
</div>
<br>
<div class="row">
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
</div>
<br>
<div class="row">
    <div class="col-sm border-right centered ">
        <h3 class="text-center">Debit
            </button> &nbsp;<button type="button" class="btn btn-warning" data-toggle="modal"
                data-target="#exampleModal4">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button></h3>
        <hr>

        @foreach($kanta as $data)
        @if($data->type == 2)
        <div class="row">
            <div class="col-md-10"><b>{{date("d-m-Y", strtotime($data->date))}}</b></div>
            <div class="col-1">
                @if(auth()->user()->name == 'admin')
                <form action="{{route('partykanta-delete')}}" onsubmit="check('Delete')" class='form-inline submit'
                    method="post">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <button class="btn btn-danger submit">X</button>
                </form>
            </div>
            <div class="col-1">
                <form action="{{route('partykanta-edit')}}" onsubmit="check('Update')" class='form-inline submit'
                    method="post">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <input type="hidden" value="{{$party->id}}" name="partyid">
                    <input type="hidden" value="3" name="type">
                    <button class="btn btn-info submit"><i class="fa fa-edit" aria-hidden="true"></i></button>
                </form>

                @endif
            </div>
            <div class="col-md-10">
                <p>{{$data->note}}</p>
            </div>
            <div class="col-md-2">
                <p><b>{{number_format($data->amount)}}</b></p>
            </div>
        </div>
        <hr>
        @endif
        @endforeach
        <div class="row">
            <div class="col">
                <span class="balance">{{number_format($total_credit)}}</span> total credit
                <br>
                <span class="balance">- {{number_format($total_debit)}}</span> Total debit
                <hr>
                <?php $balance = $total_credit - $total_debit ?>
                <span class="balance">{{number_format($balance)}}</span> Balance
            </div>
        </div>
    </div>
    <div class="col-sm border-left">
        <h3 class="text-center">Credit <button type="button" class="btn btn-success" data-toggle="modal"
                data-target="#exampleModal">
                <i class="fa fa-plus" aria-hidden="true"></i></button></h3>
        <hr>

        @foreach($kanta as $data)
        @if($data->type == 1)

        <div class="row">
            <div class="col-md-10"><b>{{date("d-m-Y", strtotime($data->date))}}</b></div>
            <div class="col-1">
                @if(auth()->user()->name == 'admin')
                <form action="{{route('partykanta-delete')}}" onsubmit="check('Delete')" class='form-inline submit'
                    method="post">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <button class="btn btn-danger submit">X</button>
                </form>
            </div>
            <div class="col-1">
                <form action="{{route('partykanta-edit')}}" onsubmit="check('Update')" class='form-inline submit'
                    method="post">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <input type="hidden" value="{{$party->id}}" name="partyid">
                    <input type="hidden" value="1" name="type">
                    <button class="btn btn-info submit"><i class="fa fa-edit" aria-hidden="true"></i></button>
                </form>

                @endif
            </div>
            <div class="col-md-10">
                <p>{{$data->note}}</p>
            </div>
            <div class="col-md-2">
                <p><b>{{number_format($data->amount)}}</b></p>
            </div>
        </div>
        <hr />
        @endif




        @endforeach


        <div class="row">
            <div class="col">
                <span class="balance">{{number_format($total_credit)}}</span> Total Credit
            </div>
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
                <form method="post" class="submit" action="{{ route('add-partykanta') }}">
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
                <button type="submit" class="btn btn-success submit">submit </button>
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
                <form method="post" class="submit" action="{{ route('add-partykanta') }}">
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
                <button type="submit" class="btn btn-success submit">submit </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->

@endsection