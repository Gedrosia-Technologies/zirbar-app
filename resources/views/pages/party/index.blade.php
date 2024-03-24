@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1>Party Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<form method="post" class="submit" action="{{ route('add_party') }}">
    @csrf
    <div class="row ">
        <div class="col">
            <input type="text" name="title" required class="form-control" placeholder="Party Name">
        </div>
        <div class="col">
            <select name="type" class="form-control" id="" required>
                <option value="" selected disabled>---Please Select Account Type---</option>
                <option value="Client">Client</option>
                {{-- <option value="Supplier">Supplier</option> --}}
            </select>
        </div>
        
        <div class="col">
            <input type="submit" value="Add Party" class="btn btn-info submit">
        </div>
    </div>
</form>

<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all Parties</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title/Name</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Title/Name</th>
                        <th>Account Type</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($party as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->type}}</td>
                        <td><a class="btn btn-success" href="/Partykanta/{{$data->id}}">Khanta</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
