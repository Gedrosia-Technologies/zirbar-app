@extends('layouts.theme')
@section('content')

<?php
        $dieselstock = 0;
        $petrolstock = 0;
        $petrolid = 2;
        $dieselid = 1;
        // confirm id's
        foreach ($stock as $row) {
            if($row->type == 'Diesel'){
                $dieselid = $row->id;
            }
            if($row->type == 'Petrol'){
                $petrolid = $row->id;
            }
        }

        foreach ($stockdetails as $details) {
            if($details->stockid == $dieselid){ //diesel
                if($details->status == 1) //purchase
                {
                    $dieselstock += $details->liters;
                }
                elseif ($details->status == 2) { //sell
                    $dieselstock -= $details->liters;
                }
            }
            elseif($details->stockid == $petrolid){ //petrol
                if($details->status == 1) //purchase
                {
                    $petrolstock += $details->liters;
                }
                elseif ($details->status == 2) { //sell
                    $petrolstock -= $details->liters;
                }
            }
        }
    ?>
<div class="row">
    <input type="hidden" id="dieselStock" value="{{$dieselstock}}">
    <input type="hidden" id="petrolStock" value="{{$petrolstock}}">

    <div class="col-sm">
        <h1><i class='fas fa-gas-pump'></i>Sell Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<div class="row">
    <!-- Button trigger modal -->
    <?php
    $All_Closed = true;
        foreach ($sold as $data) {
            if(!$data->isclosed){
                $All_Closed = false;
            }
        }
    ?>

    @if($All_Closed)
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#SellModal">
        <i class='fas fa-plus'></i> Add new Sell list
    </button>
    @endif

</div>


<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all Sold</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unit</th>
                        <th>Pervious Counter</th>
                        <th>Current Counter</th>
                        <th>Rate</th>
                        <th>Liters</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Unit</th>
                        <th>Pervious Counter</th>
                        <th>Current Counter</th>
                        <th>Rate</th>
                        <th>Liters</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($sold as $data)

                    <tr>
                        <td>{{$data->id}}</td>
                        <td>
                            <?php $unit = \App\Models\Unit::find($data->unitid) ?>
                            {{$unit->title}} - {{$unit->type}}
                        </td>
                        <td>{{$data->pcounter}}</td>
                        <td>{{$data->counter}}</td>
                        <td>{{$data->rate}}</td>
                        <td>{{$data->liters}}</td>
                        <td>{{$data->date}}</td>
                        <td>
                            @if($data->isclosed)
                            <span class="badge badge-danger">Closed</span>
                            @else
                            <span class="badge badge-success">Open</span>
                            @endif
                        </td>

                        <td class="d-flex justify-content-around">
                            <a href="SellDetail/{{$data->id}}" class="btn btn-info">Details</a>
                            @if(!$data->isclosed)
                            @if(auth()->user()->isadmin)
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                data-id="{{$data->id}}" data-action="{{route('delete_sell')}}"><i class="fa fa-trash"
                                    aria-hidden="true"></i> Delete</button>
                            @endif
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
                <form method="post" action="{{route('update_unit')}}" onsubmit="check('Update')">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input id="title" class="form-control title" type="text" name="title">
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control type" name="type" id="type">
                            <option value="diesel">Diesel</option>
                            <option value="petrol">Petrol</option>
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
<div class="modal fade" id="SellModal" tabindex="-1" role="dialog" aria-labelledby="SellModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SellModalLabel">Add New Sell List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add_sell') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">Date:</label>
                        <input id="title" class="form-control" type="date" name="date" value="{{date('Y-m-d')}}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="type">Unit:</label>
                        <select name="unitid" id="unitSelected" class="form-control">
                            <option value="null">-----Please Select Unit------</option>
                            <?php 
                            $units = App\Models\Unit::all();
                             ?>
                            @foreach($units as $unit)
                            <option value="{{$unit->id}}" data-counter="{{$unit->counter}}" data-type="{{$unit->type}}">
                                {{$unit->title}} -
                                {{$unit->type}} - {{$unit->counter}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="counterInput">Counter Value:</label>
                        <input id="counterInput" class="form-control" type="number" name="counter" min="" value="0"
                            step=".01" required>
                        <small class="form-text text-danger" id="counterHelp"></small>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="btnsub" type="submit" class="btn btn-primary">Add Sell List</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')
<script>
    let petrolStock = parseFloat($('#petrolStock').val());
    let dieselStock = parseFloat($('#dieselStock').val());
    $("#unitSelected").change(function () {
        let input = parseFloat($("#counterInput").val());
        let type = $("#unitSelected option:selected").data("type");
        checkstock(type, input);
        var prop = $("#unitSelected option:selected").data("counter");
        prop = parseInt(prop) +0.01;
        $("#counterInput").attr("min", prop);
    });

    $('#btnsub').prop('disabled', true);

    $("#counterInput").bind('keyup mouseup', function () {
        let input = parseFloat($("#counterInput").val());
        let type = $("#unitSelected option:selected").data("type");
        
        checkstock(type, input);
    
    });


    function checkstock(type, input){
        if(input == ""){
            $('#btnsub').prop('disabled', true);
            $('#counterHelp').html("");
        }
        if(type=="Petrol"){ //petrol
            if(input <= petrolStock){
                $('#btnsub').prop('disabled', false);
                $('#counterHelp').html("");
            }
            else{
                $('#btnsub').prop('disabled', true);
                $('#counterHelp').html(`You don't have enough ${type} stock`);
            }
        }
        if(type == "Diesel"){ //diesel
            if(input <= dieselStock){
                $('#btnsub').prop('disabled', false);
                $('#counterHelp').html("");
            }
            else{
                $('#btnsub').prop('disabled', true);
                $('#counterHelp').html(`You don't have enough ${type} stock`);
            }
        }
    }
</script>
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


    });

</script>

@endsection