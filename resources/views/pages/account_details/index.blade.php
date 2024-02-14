@extends('layouts.theme')
@section('content')
<?php
        $grand_total_debit = 0;
        ?>

<div class="row">
    <div class="col">
        <h3>Title : {{$account->title}}</h3>
    </div>
    <div class="col">
        <h3>Account : {{$account->description}}</h3>
    </div>
    <div class="col">
        @if($account->type == 0)
        <h3>Account Type : Bank</h3>
        @elseif($account->type == 1)
        <h3>Account Type : Individual</h3>
        @endif
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <form class="form form-inline" target="_blank" action="{{route('accountdetails-print')}}" method="post">
            @csrf
            From date: <input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: <input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <input type="hidden" name="accounttitle" value="{{$account->title}}">
            <input type="hidden" name="accountdescription" value="{{$account->description}}">
            <input type="hidden" name="accountid" value="{{$account->id}}">
            <button class="btn btn-danger" type="submit">Print</button>
        </form>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm border-right centered ">
        <h3 class="text-center">Credit <button type="button" class="btn btn-success" data-toggle="modal"
                data-target="#exampleModal4">
                <i class="fa fa-plus" aria-hidden="true"></i>
        </h3>
        <hr>
        <?php
        $grand_total = 0;
        ?>
        @foreach($details as $data)
        @if($data->type == 0)
        <div class="row">
            <div class="col-9"><b>{{date("d-m-Y", strtotime($data->date))}}</b></div>
            <div class="col-1">
                @if(auth()->user()->isadmin)
                <button class="btn btn-danger" data-id="{{$data->id}}" data-action="{{route('accountdetails-delete')}}" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#updateModal"
                    data-id="{{$data->id}}" data-date="{{$data->date}}"  data-des="{{$data->description}}"
                    data-amount="{{$data->amount}}">
                    <i class="fa fa-edit" aria-hidden="true"></i></button>

                @endif
            </div>
            <div class="col">
                <p>Description <br />{{$data->description}}</p>
            </div>
            <div class="col">
                <p>Amount<br />{{$data->amount}}</p>
            </div>

        </div>
        <hr>


        <?php
        $grand_total += $data->amount ;
        ?>
        @elseif($data->type ==1)
        <?php
        $grand_total_debit += $data->amount;
        ?>
        @endif


        @endforeach
        <div class="row">
            <div class="col">
                <span class="balance">{{$grand_total}}</span> Grand total
                <br>
                <span class="balance">- {{$grand_total_debit}}</span> Debit Balance
                <hr>
                <span class="balance">{{$grand_total - $grand_total_debit}}</span> Balance
            </div>
        </div>
    </div>
    <div class="col-sm border-left">
        <h3 class="text-center">Debit <button type="button" class="btn btn-warning" data-toggle="modal"
                data-target="#exampleModal">
                <i class="fa fa-plus" aria-hidden="true"></i></button></h3>
        <hr>
        <?php
        //$grand_total_debit = 0;
        ?>
        @foreach($details as $data)
        @if($data->type ==1)

        <div class="row">
            <div class="col-md-9"><b>{{date("d-m-Y", strtotime($data->date))}}</b></div>
            <div class="col-1">
                @if(auth()->user()->isadmin)
                    <button class="btn btn-danger" data-id="{{$data->id}}" data-action="{{route('accountdetails-delete')}}" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" aria-hidden="true"></i></button>    
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#updateModal"
                    data-id="{{$data->id}}" data-date="{{$data->date}}"  data-des="{{$data->description}}"
                    data-amount="{{$data->amount}}">
                    <i class="fa fa-edit" aria-hidden="true"></i></button>

                @endif
            </div>
            <div class="col-md-10">
                <p>Description<br />{{$data->description}}</p>
            </div>
            <div class="col-md-2">
                <p>Amount<br />{{$data->amount}}</p>
            </div>
        </div>
        <hr />
        @endif



        <?php
    //   $grand_total_debit += $data->amount ;
        ?>

        @endforeach


        <div class="row">
            <div class="col">
                <span class="balance">{{$grand_total_debit}}</span> Grand total
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
                <h5 class="modal-title" id="exampleModalLabel">Debit Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('add-account-details') }}">
                    @csrf

                    <input type="hidden" name="account" value="{{$account->id}}">
                    <div class="form-group">
                        <label for="">Type:</label>
                        <select name="type" class="form-control" required>
                            <option value="1">Debit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Description:</label>
                        <input type="text" name="description" required class="form-control" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="">Amount:</label>
                        <input type="text" name="amount" value="0" required class="amount-field form-control"
                            placeholder="Amount">
                        <small class="form-text text-center text-info"></small>
                    </div>

                    <input type="hidden" class="id" name="id">

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
                <h5 class="modal-title" id="exampleModalLabel">Credit new balance form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('add-account-details') }}">
                    @csrf

                    <input type="hidden" name="account" value="{{$account->id}}">
                    <div class="form-group">
                        <label for="">Type:</label>
                        <select name="type" class="form-control" required>
                            <option value="0">Credit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Description:</label>
                        <input type="text" name="description" required class="form-control" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="">Amount:</label>
                        <input type="text" name="amount" value="0" required class="amount-field form-control"
                            placeholder="Amount">
                        <small class="form-text text-center text-info"></small>
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


<!-- update credit modal -->

<div class="modal fade model-lg" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{route('accountdetails-update')}}" onsubmit="check('Update')">
                    @csrf
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="{{date('Y-m-d')}}"  required class="form-control date">
                    </div>
                    <div class="form-group">
                        <label for="">Description:</label>
                        <input type="text" name="des" required class="form-control des" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="">Amount:</label>
                        <input type="text" name="amount" value="0" required class="amount-field form-control amount"
                            placeholder="Amount">
                        <small class="form-text text-center text-info"></small>
                    </div>

                    <input type="hidden" class="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info submit">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection


@section('script')
<script>
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var des = button.data('des')
        var amount = button.data('amount')
        var date = button.data('date')
        
        var modal = $(this)
        modal.find('.modal-body .id').val(id)
        modal.find('.modal-body .des').val(des)
        modal.find('.modal-body .amount').val(amount)
        modal.find('.modal-body .date').val(date)
    })

</script>

@endsection
