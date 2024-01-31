@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1><i class='fas fa-gas-pump'></i>Sell Detail Page</h1>
    </div>
    <div class="col-sm"></div>
</div>
<div class="row d-flex justify-content-around">
    <!-- Button trigger modal -->
    <?php
    $liters = 0;
    $debitAmount = 0;
    $CreditAmount = 0;
        foreach ($sellDetails as $data) {
            $liters += $data->liters;
          if($data->type == 2)
            {
                $debitAmount += $data->amount;
            }else{
                $CreditAmount += $data->amount;
            }
        }

        $closeAmount = $sellList->rate *($sellList->liters - $liters);
        $closeAmount += $CreditAmount;
    ?>



    @if($sellList->isclosed == false)
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#DiscountModal">
        <i class='fas fa-plus'></i> Discounted Sell
    </button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PartyModal">
        <i class='fas fa-plus'></i> Sell To Party
    </button>

    <form action="{{route('close_sell')}}" method="post">
        @csrf

        <input type="hidden" name="id" value="{{$sellList->id}}">
        <input type="hidden" name="rate" value="{{$sellList->rate}}">
        <input type="hidden" name="liters" value="{{$sellList->liters - $liters}}">
        <input type="hidden" name="total" value="{{($sellList->liters - $liters)*$sellList->rate}}">
        <input type="hidden" name="closeAmount" value="{{$closeAmount}}">
        <button type="submit" class="btn btn-danger">
            Close
        </button>
    </form>

    @endif



</div>
<br>

<div class="row d-flex justify-content-around">
    <div>
        <h4>Total Amount: {{number_format($closeAmount + $debitAmount,2)}}</h4>
    </div>
    <div>
        <h4>Total Debitor Amount: {{number_format($debitAmount,2)}}</h4>
    </div>

    <div>
        <h4>Closing Amount: {{number_format($closeAmount,2)}}</h4>
    </div>


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
                        <th>Sold-To</th>
                        <th>Rate</th>
                        <th>Liters</th>
                        <th>Total</th>
                        @if($sellList->isclosed == false)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Sold-To</th>
                        <th>Rate</th>
                        <th>Liters</th>
                        <th>Total</th>
                        @if($sellList->isclosed == false)
                        <th>Action</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($sellDetails as $data)

                    <tr>
                        <td>{{$data->id}}</td>
                        <td>
                            @if($data->type == 1)
                            Discounted Individual
                            @elseif($data->type == 2)
                            <?php $party = \App\Models\Party::find($data->partyid);?>
                            Party {{$party->name}}
                            @else
                            Automatic
                            @endif
                        </td>
                        <td>{{$data->rate}}</td>
                        <td>{{$data->liters}}</td>
                        <td>{{number_format($data->amount)}}</td>
                        @if($sellList->isclosed == false)
                        <td class="d-flex justify-content-around">
                            @if(auth()->user()->isadmin)
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                data-id="{{$data->id}}" data-resourseid="{{$data->sourceid}}"
                                data-action="{{route('delete_selldetail')}}"><i class="fa fa-trash"
                                    aria-hidden="true"></i> Delete</button>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach

                    @if($sellList->isclosed == false)
                    <tr>
                        <td>0</td>
                        <td>
                            Automatic Entry
                        </td>
                        <td>{{$sellList->rate}}</td>
                        <td>{{$sellList->liters - $liters}}</td>
                        <td>{{number_format($sellList->rate *($sellList->liters - $liters))}}</td>
                        <td class="d-flex justify-content-around">
                            Generated Entry
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add New Unit Modal -->
<div class="modal fade" id="DiscountModal" tabindex="-1" role="dialog" aria-labelledby="DiscountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DiscountModalLabel">Discount Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add_selldetail') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">Date:</label>
                        <input id="title" class="form-control" type="date" name="date" value="{{date('Y-m-d')}}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="rate">Rate:</label>
                        <input id="rate" class="form-control" type="number" name="rate" min="" placeholder="Eg (174.20)"
                            step=".01" required>
                    </div>

                    <div class="form-group">
                        <label for="liters">Liters:</label>
                        <input id="liters" class="form-control" type="number" name="liters" min="0.01"
                            max="{{$sellList->liters - $liters}}" value="0" step=".01" required>
                    </div>
                    <input type="hidden" name="type" value="1">
                    <input type="hidden" name="sellid" value="{{$sellList->id}}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- party sell modal --}}

<div class="modal fade" id="PartyModal" tabindex="-1" role="dialog" aria-labelledby="PartyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PartyModalLabel">Party Discount Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('add_selldetail') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">Date:</label>
                        <input id="title" class="form-control" type="date" name="date" value="{{date('Y-m-d')}}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="rate">Party:</label>
                        <select class="form-control" name="partyid" id="type" required>
                            <option selected disabled>-----Please Select-----</option>

                            <?php $parties = \App\Models\Party::all(); ?>
                            @foreach($parties as $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rate">Rate:</label>
                        <input id="rate" class="form-control" type="number" name="rate" min="" placeholder="Eg (174.20)"
                            step=".01" required>
                    </div>

                    <div class="form-group">
                        <label for="liters">Liters:</label>
                        <input id="liters" class="form-control" type="number" name="liters" min="0.01"
                            max="{{$sellList->liters - $liters}}" value="0" step=".01" required>
                    </div>
                    <input type="hidden" name="type" value="2">
                    <input type="hidden" name="sellid" value="{{$sellList->id}}">
                    <?php $unit = \App\Models\Unit::find($sellList->unitid) ?>
                    <input type="hidden" name="fueltype" value="{{$unit->type}}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')


@endsection