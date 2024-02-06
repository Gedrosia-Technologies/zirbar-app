@extends('layouts.theme')
@section('content')

<form method="post" action="{{ route('roznamcha-update') }}">
                    @csrf
                        <input type="hidden" name="type" value="{{$data->type}}">
                        <input type="hidden" name="id" value="{{$data->id}}">
                        @if($data->type == 1 || $data->type == 3)  
                        <label for="">Unit:</label>
                        <input type="number" name="unit" required value="{{$data->unit}}" class="amount-field form-control" placeholder="unit">
                       
                        <label for="">Rate:</label>
                        <input type="number" name="rate" required value="{{$data->rate}}" class="amount-field form-control" placeholder="rate">
                        @endif
                        <label for="">Title/Note:</label>
                        <input type="text" name="title" value="{{$data->title}}" required class="form-control"
                            placeholder="Note Exmaple (hawala diya ghani ko)">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" value="{{$data->date}}" required class="form-control">
                        @if($data->type == 2 || $data->type == 4)
                        <label for="">Amount:</label>
                        <input type="number" name="amount" required value="{{$data->amount}}" class="amount-field form-control" placeholder="amount">
                        <small class="form-text text-center text-info"></small>
                        @endif
                    </div>
                        <button type="submit" class="btn btn-success">Update</button>
                </form>
                
@endsection
