@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1>Salary Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<form method="post" action="{{ route('add_salary') }}">
    @csrf
    <div class="row ">
        <div class="col">
            <input type="text" name="name" required class="form-control" placeholder="Name">
        </div>
        <div class="col">
            <input type="text" name="fname" required class="form-control" placeholder="Father Name">
        </div>
        <div class="col">
            <input type="text" name="address" required class="form-control" placeholder="Address">
        </div>
    </div>
        <div class="row">
            <div class="col">
                <input type="text" name="cnic" required class="form-control" placeholder="CNIC Number">
            </div>
            <div class="col">
                <input type="text" name="job" required class="form-control" placeholder="Job Title">
            </div>
            <div class="col">
                <input type="number" name="amount" required class="form-control" placeholder="Salary Amount">
            </div>
        </div>
            <div class="row">
                <div class="col align">
                    <br>
                    <input type="submit" value="Add Salary" class="btn btn-info">
                </div>
                
            </div>
    
</form>

<br>
<form class="form form-inline" target="_blank" action="{{route('salary-print')}}" method="post">
    @csrf
    <button class="btn btn-danger" type="submit">Print</button>
</form>


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
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Address</th>
                        <th>CNIC</th>
                        <th>Job Title</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Address</th>
                        <th>CNIC</th>
                        <th>Job Title</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($salary as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->fathername}}</td>
                        <td>{{$data->address}}</td>
                        <td>{{$data->cnic}}</td>
                        <td>{{$data->job}}</td>
                        <td>{{$data->amount}}</td>
                        <td><a class="btn btn-success" href="/SalaryDetails/{{$data->id}}">Details</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
