@extends('layouts.theme')
@section('content')
<div class="row">

<div class="col-sm"><h1>Users Page</h1></div>
<div class="col-sm"></div>
<div class="col-sm"><button type="button" style="float:right" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
Add New User
</button></div>


</div>

            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of all users</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                   
                                        @foreach($users as $data)
                                        <tr>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>{{$data->password}}</td>
                                         
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add users Form
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form action="{{route('adduserbyclass')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="" >User's Name</label>
                                        <input type="name" class="form-control" placeholder="name" name="name" value="">

                                        </div>
                                        <div class="form-group">
                                      <label for="" >Email</label>
                                        <input type="email" class="form-control" name="email" value="">
                                        </div>
                                        <div class="form-group">


                                        <label for="">Password <small>Password must be atleast 8 character long</small> </label>
                                        <input type="password" class="form-control" name="password" value="">
                                        </div>
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


@endsection