@extends('layouts.theme')
@section('content')


<div class="row">

    <div class="col-sm">
        @if ($tomanTransaction->type == 1)
            <h1><i class="fas fa-money-bill"></i> Toman Purchase Detail Page</h1>
            <?php $party =  \App\Models\TomanSupplier::where('id', $tomanTransaction->partyid)->first(); ?>
        @else
            <?php $party =  \App\Models\TomanClient::where('id', $tomanTransaction->partyid)->first(); ?>
            <h1><i class="fas fa-money-bill"></i>Toman Sell Detail Page</h1>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-3">
        <h6>PKR Amount: {{number_format($tomanTransaction->amount)}} </h6>
        <h6>Toman Amount: {{number_format($tomanTransaction->toman)}} </h6>
        <h6>Rate: {{number_format($tomanTransaction->rate)}} </h6>
        <h6>Party: {{$party->name}} </h6>
    </div>

    <div class="col-6">
        @if($remainingFunds != 0)
        <form  class="submit d-flex align-items-center" action="{{route('add_tomantransactiondetail')}}" method="POST">
            @csrf
                <input id="date" class="form-control" type="hidden" name="date" value="{{date('Y-m-d')}}"
                required>
                
                <div class="form-group col-4">
                    <label for="stockerid">Stocker</label>
                    <select id="stockerid" data-live-search="true" class="form-control selectpicker" required
                        name="stockerid">
                        <option value="" selected disabled>---Please Select Stocker---</option>
                        <?php $stockers =  \App\Models\TomanStocker::all(); ?>

                        @foreach($stockers as $stocker)
                            <option value="{{$stocker->id}}">
                                {{$stocker->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4">
                    <label for="amount">Toman amount</label>
                    <input required type="number" id="amount" name="amount" min="0" placeholder="Enter Toman Amount" class="form-control">
                </div>
                    <input id="ctn"  class="form-control" value="1" min="1" type="hidden" name="qty">
                <input type="hidden" name="transactionid" value="{{$tomanTransaction->id}}">
                <button type="submit" class="btn btn-primary submit mx-2 mt-3">Add</button>
            </form>
        @endif
    </div>
    <div class="col-3">
        <h6>Remaining Funds: {{number_format($remainingFunds)}} </h6>
        @if($remainingFunds == 0 && $tomanTransaction->isopen == 1)
            <button class="btn btn-warning submit" data-toggle="modal" data-target="#closeTransactions" >Make Close</button>
        @endif
    </div>

    {{-- <div class="col-2">
        @if(count($sellDetails) > 0)
            <form class="submit mb-1" action="{{route('close_bikesell')}}" method="POST">
                @csrf
                <input type="hidden" name="sellid" value="{{$sellList->id}}">
                <input type="hidden" name="client" value="{{$sellList->clientid}}">
                <input type="hidden" name="salesmanid" value="{{$sellList->salesmanid}}">
                <input type="hidden" name="amount" value="{{$grandtotal}}">
                <button class="btn btn-warning submit">Make Close</button>
            </form>

            <button type="button" class="btn btn-info mb-1" data-toggle="modal" data-target="#addChargesModal">
                 Add Register charges
            </button>
            
            <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#addDiscountModal">
               Update Discount
            </button>
            
        @endif
    </div>
     --}}
    {{-- <form class=" form form-inline" target="_blank" action="{{route('bikesell-single-print')}}"
        method="post">
        @csrf
        <input type="hidden" name="id" value="{{$sellList->id}}">
        <button class="btn btn-danger" type="submit"><i class="fa fa-print"
                aria-hidden="true"></i> Print</button>
    </form>  --}}
</div>
<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">List of Selected Stockers</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Stocker Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Stocker Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($tomanTransactionDetails as $data)

                    <tr>
                        <td>{{$data->id}}</td>
                        <td>
                            <?php $stocker = \App\Models\TomanStocker::find($data->stockerid);?>
                            {{$stocker->name}}
                        </td>
                        <td>
                        @if($data->type == 1)
                            <span class="badge badge-success">Purchase</span>
                            @elseif($data->type == 2)
                            <span class="badge badge-warning">Sell</span>
                        @endif
                        </td>
                        <td>{{$data->amount}}</td>

                        @if($tomanTransaction->isopen == 1)
                            <td class="d-flex justify-content-around">
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                        data-id="{{$data->id}}" data-resourseid="{{$data->sourceid}}"
                                        data-action="{{route('delete_tomantransactiondetail')}}"><i class="fa fa-trash"
                                            aria-hidden="true"></i> Delete</button>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- what -->
<!-- Add New Unit Modal -->
{{-- <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUnitModalLabel">Add Sell Units</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('add_selldetail') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Date:</label>
                        <input id="title" class="form-control" type="date" name="date" value="{{date('Y-m-d')}}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="product">Product</label>
                        <select id="product" data-live-search="true" class="form-control selectpicker" required
                            name="product">
                            <option value="" selected disabled>-----Please Select Product------</option>
                            <?php $products =  \App\Models\Product::where('product_type',1)->get(); ?>
                            @foreach($products as $product)
                            <?php $stock_product = \App\Models\Stock::where('productid',$product->id)->first(); ?>
                            @if($stock_product->wholesale_rate > 0 && $stock_product->retail_rate > 0 )
                            <option data-type="{{$product->product_type}}" value="{{$product->id}}">{{$product->title}}
                                -- {{$product->parts_code}}</option>
                            @else
                            <option value="{{$product->id}}" disabled style="color:red">
                                {{$product->title}} -- {{$product->parts_code}} (Rate NotSet)
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="selltype">Type</label>
                        <select id="selltype" class="form-control" name="selltype">
                            <?php $salesman = \App\Models\Salesman::find($sellList->salesmanid);?>
                            @if($salesman->id != 1){
                            <option value="2">Whole Sale</option>
                            <option value="3">Retail</option>
                            }
                            @else
                            <option value="2">Whole Sale</option>
                            <option value="3">Retail</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group" id="ctn-con">
                        <label for="ctn">Qty</label>
                        <input id="ctn" class="form-control" value="1" min="1" type="number" name="qty">
                    </div>
                    <input type="hidden" name="sellid" value="{{$sellList->id}}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Add Register Charges -->
<div class="modal fade" id="addChargesModal" tabindex="-1" role="dialog" aria-labelledby="addChargesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addChargesModalLabel">Add Register Charges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('add_Register_charges') }}">
                    @csrf

                    <div class="form-group">
                        <label for="ctn">Register Charges Amount</label>
                        <input class="form-control" type="text" placeholder="Register Charges Amount Eg 100" required
                            name="charges">
                    </div>
                    <input type="hidden" name="sellid" value="{{$sellList->id}}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{--  --}}

{{-- Transaction Close Confirmation Modal --}}
<div class="modal fade" id="closeTransactions" tabindex="-1" role="dialog" aria-labelledby="closeTransactionsLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeTransactionsLabel">Are you sure you want to close Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('close_tomantransaction') }}">
                    @csrf
                    <input type="hidden" id="transactionid" name="transactionid" value="{{$tomanTransaction->id}}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Add Register Charges -->
{{-- <div class="modal fade" id="addDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addChargesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addChargesModalLabel">Update Discount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" action="{{ route('close_tomantransaction') }}">
                    @csrf

                    <div class="form-group">
                        <label for="ctn">Discount Amount</label>
                        <input class="form-control" type="number" value="{{$sellList->discount}}" min="0" placeholder="Discount Amount Eg 1000" required
                            name="discount">
                    </div>
                    <input type="hidden" name="id" value="{{$sellList->id}}">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary submit">Add</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}


@endsection

@section('script')
<script>
    $('#addUnitModal').on('show.bs.modal', function (event) {
        $("#box-con").hide()
        
        const sellType = $("#selltype").change(function(event) {
            $("#box").val("0")
            $("#ctn").val("0")

            if(event.target.value == "1") {
                $("#box-con").hide()
            }else if(event.target.value == "2") {
                $("#box-con").show()

            }
        })

    });

</script>
<script>
    // Get the select element
  var select = document.getElementById('product');

  // Add event listener for the 'change' event
  select.addEventListener('change', function() {
    // Get the selected option
    var selectedOption = select.options[select.selectedIndex];

    // Retrieve the data attribute value
    var productType = selectedOption.getAttribute('data-type');

    // Do something with the product type value
   // console.log('Selected product type:', productType);
    var qtybox = document.getElementById('ctn-con');
        qtybox.innerHTML = '';
    if(productType == 1 || productType == 4){
        qtybox.innerHTML =`<div class="form-group" id="ctn-con">
            <label for="ctn">Liters</label>
            <input id="ctn" class="form-control" step=".01" value="0" type="number" name="qty">
        </div>`;
    }else{
        qtybox.innerHTML =`<div class="form-group" id="ctn-con">
            <label for="ctn">Qty</label>
            <input id="ctn" class="form-control" value="1" step="1" min="1"  type="number" name="qty">
        </div>`;
    }
  });

//       window.onload = function () {
//        const productSelector = document.querySelector('#product')
//        productSelector.nextSibling.click()
// }
</script>

@endsection