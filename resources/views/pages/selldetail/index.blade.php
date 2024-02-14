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

    <form class="submit" action="{{route('close_sell')}}" method="post">
        @csrf

        <input type="hidden" name="id" value="{{$sellList->id}}">
        <input type="hidden" name="rate" value="{{$sellList->rate}}">
        <input type="hidden" name="liters" value="{{$sellList->liters - $liters}}">
        <input type="hidden" name="total" value="{{($sellList->liters - $liters)*$sellList->rate}}">
        <input type="hidden" name="closeAmount" value="{{$closeAmount}}">
        <button type="submit" class="btn btn-danger submit">
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
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Sold-To</th>
                        <th>Rate</th>
                        <th>Liters</th>
                        <th>Total</th>
                       
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
                   
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection

@section('script')


@endsection