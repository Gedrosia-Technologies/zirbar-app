@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1><i class='fas fa-gas-pump'></i> Units Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<div class="row">
    <!-- Button trigger modal -->
    <div class="col">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#unitModal">
            <i class='fas fa-plus'></i> Add new unit
        </button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#rateModal">
            <i class="fas fa-edit"></i> Change rate
        </button>
    </div>
</div>


<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all Units</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Counter Value</th>
                        <th>Rate</th>
                        @if(auth()->user()->isadmin)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Counter Value</th>
                        <th>Rate</th>
                        @if(auth()->user()->isadmin)
                        <th>Action</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($units as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{$data->type}}</td>
                        <td>{{$data->counter}}</td>
                        <td>{{$data->rate}}</td>

                        @if(auth()->user()->isadmin)
                        <td class="d-flex justify-content-around">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                data-id="{{$data->id}}" data-action="{{route('delete_unit')}}"><i class="fa fa-trash"
                                    aria-hidden="true"></i> Delete</button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal"
                                data-id="{{$data->id}}" data-title="{{$data->title}}" data-type="{{$data->type}}"
                                data-counter="{{$data->counter}}"><i class="fa fa-edit" aria-hidden="true"></i>
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


<!-- update model -->

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
                <form method="post" action="{{route('update_unit')}}" onsubmit="check('Update')">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input id="title" class="form-control title" type="text" name="title">
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control type" name="type" id="type">
                            <option value="Diesel">Diesel</option>
                            <option value="Petrol">Petrol</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="counter">Counter:</label>
                        <input type="number" class="form-control counter" id="counter" name="counter" required>
                    </div>

                    <input type="hidden" class="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add New Unit Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unitModalLabel">Add New Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add_unit') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input id="title" class="form-control" type="text" name="title" placeholder="Eg: Unit # 1"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select name="type" id="type" class="form-control">
                            <option value="Diesel">Diesel</option>
                            <option value="Petrol">Petrol</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="counter">Counter Value:</label>
                        <input id="counter" class="form-control" type="number" name="counter" value="0" step=".01"
                            required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Unit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Chnage rate Modal -->
<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="rateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rateModalLabel">Change rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('update_rate') }}">
                    @csrf
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select name="type" id="type" class="form-control">
                            <option value="Diesel">Diesel</option>
                            <option value="Petrol">Petrol</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rate">New Rate</label>
                        <input id="rate" class="form-control" type="number" name="rate">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Save Change</button>
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
        var title = button.data('title')
        var type = button.data('type')
        var counter = button.data('counter')

        var modal = $(this)
        modal.find('.modal-body .title').val(title)
        modal.find('.modal-body .id').val(id)
        modal.find('.modal-body .type').val(type)
        modal.find('.modal-body .counter').val(counter).change();


    })

</script>
@endsection