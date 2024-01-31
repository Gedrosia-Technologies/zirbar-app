@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1>Expenditures Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<div class="row">
    <div class="col-md-4">
        <form class="form form-inline" action="{{route('expenditure-get-date')}}" method="post">
            @csrf
            Goto Date: <input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control"> &nbsp;
            <button class="btn btn-warning" type="submit">Fetch</button>
        </form>
    </div>
    <div class="col-md-8">
        <form class="form form-inline" target="_blank" action="{{route('expenditure-print')}}" method="post">
            @csrf
            From date: <input type="date" name="from_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            To date: <input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <button class="btn btn-info" type="submit">Print</button>
        </form>
    </div>
</div>
<hr>
<div class="col-md-12">
    <form method="post" action="{{ route('add_expenditure') }}">
        @csrf
        <div class="row ">
            <div class="col">
                <label for="date">Date:</label>
                <input type="date" required name="date" class="form-control" value="{{date('Y-m-d')}}">
            </div>
            <div class="col">
                <label for="amount">Amount</label>
                <input type="number" name="amount" required class="form-control" placeholder="Amount in rupees">
            </div>
            <div class="col">
                <label for="detail">Details</label>
                <input type="text" name="detail" required class="form-control" placeholder="Detail / Note">
            </div>
            <button class="btn btn-info" type="submit">Add Item</button>
        </div>
    </form>

    <div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of all Parties</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered " id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Details</th>
                                @if(auth()->user()->isadmin)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Details</th>
                                @if(auth()->user()->isadmin)
                                <th>Action</th>
                                @endif
                            </tr>
                        </tfoot>
                        <tbody>

                            @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{date('d-m-Y', strtotime($row->date))}}</td>
                                <td>{{$row->amount}}</td>
                                <td>{{$row->details}}</td>
                                @if(auth()->user()->isadmin)
                                <td class="d-flex justify-content-around">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{$row->id}}" data-action="{{route('expenditure-delete')}}"><i
                                            class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#updateModal" data-id="{{$row->id}}" data-title="{{$row->details}}"
                                        data-rozid="{{$row->roz_id}}"
                                        data-date="{{date('Y-m-d', strtotime($row->date))}}"
                                        data-amount="{{$row->amount}}"><i class="fa fa-edit" aria-hidden="true"></i>
                                        Edit</button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



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
                        <form method="post" action="{{route('expenditure-update')}}" onsubmit="check('Update')">
                            @csrf


                            <div class="form-group">
                                <label for="counter">Date:</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="counter">Amount:</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>


                            <div class="form-group">
                                <label for="title">Detail:</label>
                                <input id="title" class="form-control" id="title" type="text" name="detail">
                            </div>
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="rozid" name="roz_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
            var rozid = button.data('rozid')
            var title = button.data('title')
            var date = button.data('date')
            var amount = button.data('amount')
           // console.log(date);

            var modal = $(this)
            modal.find('.modal-body #title').val(title)
            modal.find('.modal-body #id').val(id)
            modal.find('.modal-body #rozid').val(rozid)
            modal.find('.modal-body #date').val(date)
            modal.find('.modal-body #amount').val(amount)


        })

        </script>
        @endsection