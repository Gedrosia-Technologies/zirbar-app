@extends('layouts.theme')
@section('content')

<form method="post" action="{{ route('cement-kanta-update') }}">
                    @csrf
                        <input type="hidden" name="orderid" value="{{$data->cementid}}">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <div class="form-group">
                        <label for="">Entry Date:</label>
                        <input type="date" name="date" value="{{$data->date}}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Truck Number:</label>
                        <input type="text" name="truck" value="{{$data->truck}}" placeholder="Truck Number" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Cement Quantity:</label>
                        <input type="number" name="quantity"  value="{{$data->quantity}}"  placeholder="Cement Quantity" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Ton:</label>
                        <input type="number" name="ton"  value="{{$data->ton}}"  placeholder="Ton" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Rate:</label>
                        <input type="number" name="rate"  value="{{$data->rate}}"  placeholder="Per Ton Rate" required class="amount-field form-control">
                        <small class="form-text text-center text-info"></small>
                    </div>
                    <div class="form-group">
                        <label for="">Kiraya:</label>
                        <input type="number" name="kiraya"  value="{{$data->kiraya}}"  placeholder="Kiraya" required class="amount-field form-control">
                        <small class="form-text text-center text-info"></small>
                    </div>
                        <button type="submit" class="btn btn-success">Update</button>
                </form>
                
@endsection
