@extends('layouts.theme')
@section('content')
<?php
        $total_credit = 0;
        $total_debit = 0;
        ?>
@foreach($details as $data)

<?php
        if($data->type == 1)
        $total_credit += $data->amount ;
        else
        $total_debit += $data->amount ;
    ?>

@endforeach

<div class="row">
    <div class="col">
        <h3>Name : {{$salary->name}}</h3>
    </div>
    <div class="col">
        <h3>ID Number : {{$salary->id}}</h3>
    </div>
    <div class="col">
        <h3>Salary Amount : {{number_format($salary->amount)}}</h3>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-8">
        <form class="form form-inline" target="_blank" action="{{route('salarydetails-print')}}" method="post">
            @csrf
            From date: <input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: <input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <input type="hidden" name="salaryname" value="{{$salary->name}}">
            <input type="hidden" name="salaryid" value="{{$salary->id}}">
            <button class="btn btn-danger" type="submit">Print</button>
        </form>
    </div>
    <div class="col-md-4">
        <form class="form form-inline" action="{{route('salarydetails-paysalary')}}" method="post">
            @csrf
            <input type="hidden" name="salaryid" value="{{$salary->id}}">
            <input type="hidden" name="amount" value="{{$salary->amount}}">
            <button class="btn btn-info" type="submit">Pay Salary</button>
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

        @foreach($details as $data)
        @if($data->type == 2)
        <div class="row">
            <div class="col-md-10"><b>{{date("d-m-Y", strtotime($data->date))}}</b></div>
            <div class="col-1">
                @if(auth()->user()->isadmin)
                <form action="{{route('salarydetails-delete')}}" onsubmit="check('Delete')" class='form-inline'
                    method="post">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <button class="btn btn-danger">X</button>
                </form>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#UpdateModal"
                    data-id="{{$data->id}}" data-date="{{date('Y-m-d', strtotime($data->date))}}"
                    data-title="{{$data->note}}" data-type="{{$data->type}}" data-amount="{{$data->amount}}"><i
                        class="fa fa-edit" aria-hidden="true"></i>
                    Edit</button>
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

        @foreach($details as $data)
        @if($data->type == 1)

        <div class="row">
            <div class="col-md-10"><b>{{date("d-m-Y", strtotime($data->date))}}</b></div>
            <div class="col-1">
                @if(auth()->user()->isadmin)
                <form action="{{route('salarydetails-delete')}}" onsubmit="check('Delete')" class='form-inline'
                    method="post">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <button class="btn btn-danger">X</button>
                </form>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#UpdateModal"
                    data-id="{{$data->id}}" data-title="{{$data->note}}"
                    data-date="{{date('Y-m-d', strtotime($data->date))}}" data-type="{{$data->type}}"
                    data-amount="{{$data->amount}}"><i class="fa fa-edit" aria-hidden="true"></i>
                    Edit</button>

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
                <form method="post" action="{{ route('add-salarydetails') }}">
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
                        <input type="hidden" name="salaryid" value="{{$salary->id}}">

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
                <form method="post" action="{{ route('add-salarydetails') }}">
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
                        <input type="hidden" name="salaryid" value="{{$salary->id}}">

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
<div class="modal fade model-lg" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="UpdateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateModalLabel">Update Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('salarydetails-update') }}">
                    @csrf

                    <div class="form-group">
                        <label for="">Type:</label>
                        <select name="type" class="form-control" required>
                            <option id="type" value="2">Debit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="" id="date" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Note:</label>
                        <input type="text" name="title" id="title" required class="form-control" placeholder="Note">
                    </div>
                    <div class="form-group">
                        <label for="">Amount:</label>
                        <input type="text" name="amount" value="0" id="amount" required
                            class="amount-field form-control" placeholder="Amount">
                        <small class="form-text text-center text-info"></small>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
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


@section('script')
<script>
    $('#UpdateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var date = button.data('date')
            var amount = button.data('amount')
            var type = button.data('type')
           // console.log(date);
           var typeInner = "";
           if(type == 1){
            typeInner = "Credit Update"
           }else{
            typeInner = "Debit Update"
           }

            var modal = $(this)
            modal.find('.modal-body #title').val(title)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #date').val(date)
            modal.find('.modal-body #amount').val(amount)
            modal.find('.modal-body #type').val(type)
            modal.find('.modal-body #type').html(typeInner)
        })

</script>
@endsection