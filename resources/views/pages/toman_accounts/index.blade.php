@extends('layouts.theme')
@section('content')
<div class="row">

    <div class="col-sm">
        <h1><i class="fas fa-money-check-alt"></i> Toman Accounts Details</h1>
    </div>
</div>
<div class="row">
    <div class="col-7">
        <form class="form form-inline" target="_blank" action="{{route('toman-accounts-print')}}" method="post">
            @csrf
            From date: &nbsp;<input type="date" name="from_date" value="{{date('Y-m-d')}}" required
                class="form-control">
            &nbsp;
            To date: &nbsp;<input type="date" name="to_date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <button class="btn btn-danger" type="submit">Print</button>
        </form>
    </div>
    <div class="col-5">
        <form class="form form-inline" action="{{route('toman-accounts-get-date')}}" method="post">
            @csrf
            Goto Date: &nbsp;<input type="date" name="date" value="{{date('Y-m-d')}}" required class="form-control">
            &nbsp;
            <button class="btn btn-warning" type="submit">Fetch</button>
        </form>
    </div>
</div>
<hr>
<h3 class="text-center text-primary">Accounts PKR</h3>
<div class="row">
    <div class="col">
        <h5>Spent : <span class="balance">{{number_format($pkrBalance['outgoing'],2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Earned : <span class="balance">{{number_format($pkrBalance['incoming'],2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Balance : <span class="balance">{{number_format($pkrBalance['balance'],2)}}</span></h5>
    </div>
</div>
<hr>

<hr>
<h3 class="text-center text-primary">Toman Stock</h3>
<div class="row">
    <div class="col">
        <h5>Purchase : <span class="balance">{{number_format($tomanBalance['incoming'],2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Sale : <span class="balance">{{number_format($tomanBalance['outgoing'],2)}}</span></h5>
    </div>
    <div class="col">
        <h5>Balance : <span class="balance">{{number_format($tomanBalance['balance'],2)}}</span></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#PurchaseModal">Purchase Toman</button>
    </div>
    <div class="col">
        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#SellModal">Sell Toman</button>
    </div>
</div>

<br>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Roznamcha List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Party</th>
                        <th>Account Type</th>
                        <th>Toman</th>
                        <th>Rate</th>
                        <th>Amount PKR</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Party</th>
                        <th>Account Type</th>
                        <th>Toman</th>
                        <th>Rate</th>
                        <th>Amount PKR</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($data as $row)
                    <tr>
                        <td>{{$row->id}}</td>
                        <td>{{date("d-m-Y", strtotime($row->date))}}</td>
                        <td>
                            @if($row->type == 1)
                            <span class="badge badge-success">Purchase</span>
                            @elseif($row->type == 2)
                            <span class="badge badge-warning">Sell</span>
                            @endif
                        </td>
                        <td>
                            @if($row->type == 1)
                                <?php $party =  \App\Models\TomanSupplier::where('id', $row->partyid)->first(); ?>
                                {{$party->name}}
                            @elseif($row->type == 2)
                                <?php $party =  \App\Models\TomanClient::where('id', $row->partyid)->first(); ?>
                                {{$party->name}}
                            @endif
                        </td>
                        <td>
                            @if($row->acctype == 1)
                            <span class="badge badge-success">Credit</span>
                            @elseif($row->acctype == 2)
                            <span class="badge badge-warning">Debit</span>
                            @endif
                        </td>
                        <td>{{number_format($row->toman)}}</td>
                        <td>{{number_format($row->rate)}}</td>
                        <td>{{number_format($row->amount)}}</td>
                        <td>
                            <a class="btn btn-success" href="/TomanTransactionDetails/{{$row->id}}">Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>




<!-- Add New Sell Modal -->
<div class="modal fade" id="SellModal" tabindex="-1" role="dialog" aria-labelledby="SellModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SellModalLabel">Add New Sell</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" id="sellform" action="{{ route('toman_sell') }}">
                    @csrf
                    <input type="hidden" name="type" value="2">
                    <div class="form-group">
                        <label for="title">Date:</label>
                        <input id="title" class="form-control" type="date" name="date" value="{{date('Y-m-d')}}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="type">Client:</label>
                        <select name="clientid" required data-live-search="true"  class="form-control selectpicker">
                            <option value="">-----Please Select Client------</option>
                            <?php 
                            $clients = App\Models\TomanClient::all();
                             ?>
                            @foreach($clients as $client)
                            <option value="{{$client->id}}" data-counter="{{$client->id}}">
                                {{$client->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tomaninputsell">Toman Value:</label>
                        <input id="tomaninputsell" class="form-control" type="number" name="toman" min="" value="0"
                            step=".01" required>
                        <small class="form-text text-danger" id="tomanhelpsell"></small>
                    </div>

                    <div class="form-group">
                        <label for="rateinput">Rate:</label>
                        <input id="rateinputsell" class="form-control" type="number" name="rate" min="" value="0"
                            step=".01" required>
                        <small class="form-text text-danger" id="ratehelpsell"></small>
                    </div>
                    <div class="form-group">
                        <label for="acctype">Sell As:</label>
                        <select name="acctype" class="form-control">
                            <option value="1">
                                Credit
                            </option>
                            <option value="2">
                                Debit
                            </option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="btnsub" type="submit" class="btn btn-primary submit">Add Sell</button>
                </form>
            </div>
        </div>
    </div>
</div>







<!-- Add New Purchase Modal -->
<div class="modal fade" id="PurchaseModal" tabindex="-1" role="dialog" aria-labelledby="SellModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SellModalLabel">Add New Purchase</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="submit" id="purchaseform" action="{{ route('toman_purchase') }}">
                    @csrf
                    <input type="hidden" name="type" value="1">
                    <div class="form-group">
                        <label for="title">Date:</label>
                        <input id="title" class="form-control" type="date" name="date" value="{{date('Y-m-d')}}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="type">Supplier:</label>
                        <select name="supplierid" required data-live-search="true"  class="form-control selectpicker">
                            <option value="">-----Please Select Supplier------</option>
                            <?php 
                            $supplier = App\Models\TomanSupplier::all();
                             ?>
                            @foreach($supplier as $party)
                            <option value="{{$party->id}}" data-counter="{{$party->id}}">
                                {{$party->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="counterInput">Toman Value:</label>
                        <input id="tomaninputpurchase" class="form-control" type="number" name="toman" min="" value="0"
                            step=".01" required>
                        <small class="form-text text-danger" id="tomanhelppurchase"></small>
                    </div>

                    <div class="form-group">
                        <label for="counterInput">Rate:</label>
                        <input id="rateinputpurchase" class="form-control" type="number" name="rate" min="" value="0"
                            step=".01" required>
                        <small class="form-text text-danger" id="ratehelppurchase"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="acctype">Purchase As:</label>
                        <select name="acctype" class="form-control">
                            <option value="1">
                                Credit
                            </option>
                            <option value="2">
                                Debit
                            </option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button id="btnsub" type="submit" class="btn btn-primary submit">Add Sell</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')

<!-- Add this script at the end of your HTML body or in a separate script file -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to initialize currency formatting for a specific form
        function initializeCurrencyFormatting(formId, inputId, helpId) {
            // Get the form, input, and help elements for the specific form
            var form = document.getElementById(formId);
            var input = form.querySelector('#' + inputId);
            var help = form.querySelector('#' + helpId);

            // Add an input event listener to the input field
            input.addEventListener('input', function () {
                // Get the entered value
                var inputValue = input.value;

                // Format the value using comma and k/m/b
                var formattedValue = formatCurrency(inputValue);

                // Update the help field with the formatted value
                help.textContent = formattedValue;
            });

            // Function to format currency
            function formatCurrency(value) {
                // Convert the value to a number
                var numericValue = parseFloat(value);

                // Check if the value is a number
                if (!isNaN(numericValue)) {
                    // Format the value with commas and k/m/b
                    if (numericValue >= 1000000000000) {
                        return (numericValue / 1000000000000) + 'T';
                    }if (numericValue >= 1000000000) {
                        return (numericValue / 1000000000) + 'B';
                    } else if (numericValue >= 1000000) {
                        return (numericValue / 1000000) + 'M';
                    } else if (numericValue >= 1000) {
                        return (numericValue / 1000) + 'K';
                    } else {
                        return numericValue;
                    }
                } else {
                    return ''; // Return an empty string for non-numeric values
                }
            }
        }

        // Initialize currency formatting for the first form
        initializeCurrencyFormatting('sellform', 'tomaninputsell', 'tomanhelpsell');

        // Initialize currency formatting for the second form
        initializeCurrencyFormatting('purchaseform', 'tomaninputpurchase', 'tomanhelppurchase');




        // Get the toman, rate, and ratehelp elements for the first form
        var tomanInput1 = document.getElementById('tomaninputsell');
        var rateInput1 = document.getElementById('rateinputsell');
        var rateHelp1 = document.getElementById('ratehelpsell');

        // Get the toman, rate, and ratehelp elements for the second form
        var tomanInput2 = document.getElementById('tomaninputpurchase');
        var rateInput2 = document.getElementById('rateinputpurchase');
        var rateHelp2 = document.getElementById('ratehelppurchase');

        // Add input event listeners to the toman and rate fields for the first form
        tomanInput1.addEventListener('input', function () {
            updateFormattedValue(tomanInput1, rateInput1, rateHelp1);
        });

        rateInput1.addEventListener('input', function () {
            updateFormattedValue(tomanInput1, rateInput1, rateHelp1);
        });

        // Add input event listeners to the toman and rate fields for the second form
        tomanInput2.addEventListener('input', function () {
            updateFormattedValue(tomanInput2, rateInput2, rateHelp2);
        });

        rateInput2.addEventListener('input', function () {
            updateFormattedValue(tomanInput2, rateInput2, rateHelp2);
        });

        // Function to format currency with commas
        function formatCurrencyWithCommas(value) {
            // Convert the value to a number
            var numericValue = parseFloat(value);

            // Check if the value is a number
            if (!isNaN(numericValue)) {
                // Format the value with commas
                return numericValue.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            } else {
                return ''; // Return an empty string for non-numeric values
            }
        }

        // Function to update formatted value for a specific form
        function updateFormattedValue(tomanInput, rateInput, rateHelp) {
            // Get the entered values
            var tomanValue = parseFloat(tomanInput.value) || 0;
            var rateValue = parseFloat(rateInput.value) || 0;

            // Calculate the total value (toman divided by rate)
            var totalValue = tomanValue / rateValue;

            // Round the total value to the nearest integer
            var roundedTotalValue = Math.round(totalValue);

            // Format the rounded total value with commas
            var formattedRoundedTotalValue = formatCurrencyWithCommas(roundedTotalValue);

            // Update the ratehelp field with the formatted rounded total value
            rateHelp.textContent = 'Total Amount PKR: ' + formattedRoundedTotalValue;
        }









    });
</script>



@endsection