<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salary Print</title>
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
      border-top: 1px solid #5D6975;
      border-bottom: 1px solid #5D6975;
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
    table td.desc {
      font-size: 1.2em;
      text-align: center;
    }

    table td.total {
      font-size: 1.4em;
      text-align: center;
    }

    table td.grand {
      border-top: 1px solid #5D6975;
      ;
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
        $grand_salary = 0;
        $grand_advance = 0;
        $grand_balance = 0;
        $count = 0;
        ?>
  @foreach($SalaryData as $row)

  <?php
        $grand_salary += $row->salary;
        $grand_advance += $row->advance;
        $grand_balance += ($row->salary - $row->advance);
       
?>

  @endforeach
  <?php
// $cal_balance = $balance;
?>
  <!-- <div id="logo">
        <img width="500px" height="" src="http://humsafar.gedrosia.tech/black.png">
      </div> -->
  <h1>Salary Report</h1>

  <hr>
  <main>
    <table>
      <thead>
        <tr>
          <th>S.NO</th>
          <th>Employee Name</th>
          <th>Designation</th>
          <th>C.N.I.C Number</th>
          <th>Allocated Salary</th>
          <th>Advance</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>

        @foreach($SalaryData as $row)
        <tr>
          <?php
            $count++;
            ?>
          <td class="unit">({{$count}})</td>
          <td class="unit">{{$row->name}}</td>
          <td class="unit">{{$row->job}}</td>
          <td class="unit">{{$row->cnic}}</td>
          <td class="qty"> {{number_format($row->salary)}}</td>
          <td class="qty"> {{number_format($row->advance)}}</td>
          <td class="qty"> {{number_format($row->salary - $row->advance)}}</td>


        </tr>
        @endforeach

        <tr>
          <td class="total"><b> Grand Total</b></td>
          <td></td>
          <td class="desc"></td>
          <td class="unit"></td>
          <td class="total"><b>{{number_format($grand_salary)}}</b></td>
          <td class="total"><b>{{number_format($grand_advance)}}</b></td>
          <td class="total"><b>{{number_format($grand_balance)}}</b></td>
        </tr>
      </tbody>
    </table>

  </main>

</body>

</html>