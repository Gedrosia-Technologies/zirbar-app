<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report Print</title>
    <style>
        .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 27cm;  
  height: 21cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 5px;
  /* text-align: right; */
}

table td.service {
  font-size: .8em;
}

table td.unit,
table td.qty,
table td.total
table td.desc {
  font-size: 1.2em;
  text-align:center;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
</head>
<body>

<?php
$total = 0;
$totalw = 0;
$total_Cqty = 0;
$grandtotal = 0;
$grandtotalw = 0;
$grandtotalq = 0;
$grandtotalp = 0;
$grandtotalc = 0;
$total_Karcha = 0;
$count = 0;
$date;
foreach($data as $row)
{
    $total = ($row->qty * $row->orate);
    $totalw = ($row->qty * $row->rate);
    $grandtotal += $total;
    $grandtotalw += $totalw;
    $grandtotalq += $row->qty;
    $grandtotalp += $row->pt;
    $total_Cqty += $row->cqty;
    $date = $row->date;
}
foreach($karcha as $karch)
{
    $total_Karcha += $karch->amount;
}
$perItemKarcha = 0;
if($total_Karcha != 0 )
{
    $perItemKarcha = $total_Karcha / $total_Cqty;
}
?>
<!-- @foreach($data as $row)
  $total = ($row->qty * $row->orate);
  $grandtotal += $total;

@endforeach -->

 <!-- <div id="logo">
        <img width="500px" height="" src="http://humsafar.gedrosia.tech/black.png">
      </div> -->
<h1>Purchase Report ({{$partyname}})</h1>
<div><span>Date:</span> {{date('d-m-y',strtotime($date))}}</div>
   <hr>
    <main>
      <table>
        <thead>
          <tr>
           
            <th class="service">Date</th>
            <th>Fish Type</th>
            <th>Rate</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Waste</th>
            <th>Payble Rate</th>
            <th>Amount Payble</th>
            <th>Rate With Expense</th>
            <th>Current Amount</th>
          </tr>
        </thead>
        <tbody>
      
        @foreach($data as $row)
        <tr>
            <?php
            $count++;
            ?>
            <td class="service">({{$count}}) - {{date('d-m-y',strtotime($row->date))}}</td>
            <td>
              <?php $type =  \App\Models\Fish_Type::where('id',$row->type)->first(); ?>
              {{$type->type}}
            </td>
            <td class="total">{{$row->orate}}</td>
            <td class="total">{{$row->qty}}</td>
            <td class="total">{{($row->qty * $row->orate)}}</td>
            <td>{{$row->pt}}%</td>
            <td>{{$row->rate}}</td>
            <td>{{number_format(($row->qty * $row->rate))}}</td>
            <?php 
              $Crate = $row->rate + $perItemKarcha;
              $Camount = ($row->qty * $Crate);
              $grandtotalc += $Camount;
            ?>
            <td>{{  number_format($Crate,2 ) }}</td>
            <td>{{  number_format($Camount) }}</td>
            
            
        </tr>
        @endforeach
      
         <tr>
            <td class="service"><b> Grand Total</b></td>
            <td></td>
            <td></td>
            <td class="total"><b>{{$grandtotalq}}</b></td>
            <td class="total"><b>{{ number_format($grandtotal)}}</b></td>
            <td class="total"><b>{{ number_format($grandtotalp)}}%</b></td>
            <td></td>
            <td class="total"><b>{{ number_format($grandtotalw)}}</b></td>
            <td></td>
            <td><b>{{ number_format($grandtotalc)}}</b></td>
            
          </tr> 
        </tbody>
      </table>
    
    </main>

  </body>
</html>