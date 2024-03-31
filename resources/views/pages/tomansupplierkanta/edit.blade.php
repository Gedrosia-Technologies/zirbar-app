@extends('layouts.theme')
@section('content')

<form method="post" action="{{ route('partykanta-update') }}">
    @csrf

    <div class="form-group">
        <label for="">Date:</label>
        <input type="date" name="date" value="{{$data->date}}" required class="form-control">
    </div>
    @if($type == 2)
    <div class="form-group">
        <label for="">Truck-Number:</label>
        <input type="text" name="trucknumber" value="{{$data->trucknumber}}" required class="form-control"
            placeholder="truck number">
    </div>

    <div class="form-group">
        <label for="">unit:</label>
        <input type="number" name="item" value="{{$data->item}}" required class="form-control" placeholder="Note">


        <label for="">item:</label>
        <input type="text" class="form-control" name="title" value="{{$data->title}}" id="">

        <label for="">Unit Price:</label>
        <input type="number" name="rate" value="{{$data->rate}}" required class="amount-field form-control"
            placeholder="Note">
        <small class="form-text text-center text-info"></small>
    </div>
    <div class="form-group">
        <label for="">Rasta-Karcha:</label>
        <input type="number" name="karcha" value="{{$data->karcha}}" required class="amount-field form-control"
            placeholder="Rasta Karcha">
        <small class="form-text text-center text-info"></small>
    </div>
    <div class="form-group">
        <label for="">Mazdori:</label>
        <input type="number" name="mazdori" value="{{$data->mazdori}}" required class="amount-field form-control"
            placeholder="Mazdori Karcha">
        <small class="form-text text-center text-info"></small>
    </div>
    <div class="form-group">
        <label for="">Gate-Karcha:</label>
        <input type="number" name="gate" value="{{$data->gate}}" required class="amount-field form-control"
            placeholder="Gate Karcha">
        <small class="form-text text-center text-info"></small>
    </div>
    @endif

    @if($type == 1)
    <label for="">Title:</label>
    <input type="text" class="form-control" name="title" value="{{$data->title}}" id="">
    <div class="form-group">
        <label for="">Amount:</label>
        <input type="number" name="amount" value="{{$data->adah}}" required class="amount-field form-control"
            placeholder="Amount">
        <small class="form-text text-center text-info"></small>
    </div>
    @endif
    @if($type == 3)
    <label for="">Title:</label>
    <input type="text" class="form-control" name="title" value="{{$data->title}}" id="">
    <div class="form-group">
        <label for="">Amount:</label>
        <input type="number" name="amount" value="{{$data->wasol}}" required class="amount-field form-control"
            placeholder="Amount">
        <small class="form-text text-center text-info"></small>
    </div>
    @endif


   

    <div class="form-group">
        <input type="hidden" name="id" value="{{$data->id}}">
        <input type="hidden" name="partyid" value="{{$data->partyid}}">
        <input type="hidden" name="type" value="{{$type}}">
    </div>


    <button type="submit" class="btn btn-success">Update</button>
</form>

@endsection