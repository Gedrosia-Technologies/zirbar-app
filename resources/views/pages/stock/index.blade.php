@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1><i class='fas fa-gas-pump'></i> Stock Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<div class="row">

</div>


<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of all Stocks</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Liters</th>
                        <th>Liters Sold</th>
                        <th>Remaining Liters</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Liters</th>
                        <th>Liters Sold</th>
                        <th>Remaining Liters</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($stock as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->type}}</td>
                        <?php 
                        $stock_details = \App\Models\Stock_detail::where('stockid',$data->id)->get();
                         $liters = 0.00;
                         $rliters = 0.00;
                        foreach ($stock_details as $row ) {
                            if($row->status == 1){

                                $liters +=  $row->liters;
                            }else{
                                $rliters += $row->liters;
                            }
                        }
                        ?>
                        <td>{{$liters}}</td>
                        <td>
                            {{$rliters}}
                        </td>
                        <td>
                            {{$liters - $rliters}}
                        </td>
                        <td class="d-flex justify-content-around">
                            @if(auth()->user()->isadmin)
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal"
                                data-id="{{$data->id}}" data-type="{{$data->type}}" data-counter="{{$data->liters}}"><i
                                    class="fa fa-edit" aria-hidden="true"></i>
                                Edit</button>
                            @endif
                            <a class="btn btn-success" href="/StockDetails/{{$data->id}}">Details</a>
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