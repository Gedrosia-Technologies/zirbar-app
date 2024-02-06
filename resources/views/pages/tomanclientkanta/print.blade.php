<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Kanta Print</title>
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
$total_incoming = 0;
$total_outgoing = 0;
$count = 0;
?>
@foreach($data as $row)

@if($row->type == 1)
<?php
        $total_incoming += $row->amount;
        ?>
@endif
@if($row->type == 2)
<?php
        $total_outgoing += $row->amount;
        ?>
@endif


@endforeach
<?php
$cal_balance = $balance;
?>
 <!-- <div id="logo">
        <img width="500px" height="" src="http://humsafar.gedrosia.tech/black.png">
      </div> -->
<h1>Client Kanta Report ({{$partyname}})</h1>
    <!-- <header class="clearfix">
     </header> 
       <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div> 
      </div>
      <div id="project">
        <div><span>Date:</span> {{$fromDate}} TO {{$toDate}}</div>
         <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
        <div><span>DUE DATE</span> September 17, 2015</div> 
      </div> 
    </header> -->
    <div><span>Date:</span> {{date('d-m-y',strtotime($fromDate))}} TO {{date('d-m-y',strtotime($toDate))}}</div>
    <div  style="float:right; margin-top:-25px"><h3> <span>Previouse Balance:</span> {{number_format($balance)}}</h3></div>
<hr>
    <main>
      <table>
        <thead>
          <tr>
           
            <th class="service">Date</th>
            <th class="desc">Description</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
      
        @foreach($data as $row)
        <tr>
            <?php
            $count++;
            ?>
            <td class="service">({{$count}}) - {{date('d-m-y',strtotime($row->date))}}</td>
            <td class="desc">{{$row->note}}</td>

            <td class="total">@if($row->type == 1)
                <?php
                    $cal_balance += $row->amount;
                ?>
            {{number_format($row->amount)}}
            @endif
            </td>
            <td class="total">@if($row->type == 2)
                 <?php
                    $cal_balance -= $row->amount;
                ?>
            {{number_format($row->amount)}}
            @endif</td>

             <td class="total">{{number_format($cal_balance)}}</td>
            
        </tr>
        @endforeach
      
         <tr>
            <td class="service"><b> Grand Total</b></td>
            <td class="desc"></td>
            <td class="total"><b>{{number_format($total_incoming)}}</b></td>
            <td class="total"><b>{{number_format($total_outgoing)}}</b></td>
            <td class="total"><b>{{ number_format($cal_balance)}}</b></td>
          </tr> 
        </tbody>
      </table>
    
    </main>

  </body>
</html>