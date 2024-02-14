@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1><i class="fas fas fa-landmark"></i> Investment</h1>
    </div>
    <div class="col-sm"></div>
</div>
<hr>
<h3>Add New Account</h3>
<form method="post" class="submit" action="{{ route('add_account') }}">
    @csrf
    <div class="row ">
        <div class="col">
            <input type="text" name="title" required class="form-control" placeholder="Account Title">
        </div>
        <div class="col">
            <input type="text" name="description" required class="form-control" placeholder="Account Description">
        </div>

        <div class="col">
            <select name="type" id="type" class="form-control" required="required">
                <option value="0">Bank</option>
                <option value="1">Individual</option>
            </select>
        </div>


        <div class="col">
            <input type="submit" value="Add Account" class="btn btn-info submit">
        </div>
    </div>
</form>

<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all Accounts</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($accounts as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{$data->description}}</td>
                        @if($data->type == 0)
                        <td>Bank</td>
                        @elseif($data->type == 1)
                        <td>Individual</td>
                        @endif

                        <td class="d-flex justify-content-around">
                            <a class="btn btn-success" href="/AccountDetails/{{$data->id}}">Details</a>

                            @if(auth()->user()->isadmin)
                                <button class="btn btn-danger" data-id="{{$data->id}}" data-action="{{route('delete_account')}}" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <?php 
                            $typeName =  ($data->type == 0) ? "Bank" : "Individual";
                            ?>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#updateModal"
                                data-id="{{$data->id}}" data-title="{{$data->title}}" data-des="{{$data->description}}"
                                data-type="{{$data->type}}"  data-typename="{{$typeName}}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            @endif
                        </td>
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
                <form method="post" class="submit" action="{{route('update_account')}}" onsubmit="check('Update')">
                    @csrf

                    <div class="form-group">
                        <label for="quantity">Title</label>
                        <input id="quantity" class="form-control title" type="text" name="title">
                    </div>
                    <div class="form-group">
                        <label for="FishType">Description</label>
                        <input id="FishType" class="form-control des" type="text" name="des">
                    </div>
                    <div class="form-group">
                         <label for="type">Account Type</label>
                        <select name="type" id="type" class="form-control" required="required">
                            <option class="type" selected></option>
                            <option value="0">Bank</option>
                            <option value="1">Individual</option>
                        </select>
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
        var title = button.data('title')
        var des = button.data('des')
        var type = button.data('type')
        var typeName = button.data('typename')

        var modal = $(this)
        modal.find('.modal-body .title').val(title)
        modal.find('.modal-body .id').val(id)
        modal.find('.modal-body .des').val(des)
        modal.find('.modal-body .type').html(typeName)
        modal.find('.modal-body .type').val(type)


    })

</script>
@endsection
