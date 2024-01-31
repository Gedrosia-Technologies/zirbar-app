<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>
<!-- balance calculation -->
<?php
$bb = \App\Models\Roznamcha::all();
$ti = 0;
$to = 0;
$petrol_stock = 0;
$diesel_stock = 0;
$petrol = \App\Models\Stock::where('type','Petrol')->first();
$diesel = \App\Models\Stock::where('type','Diesel')->first();
$diesel_rate = \App\Models\Unit::where('type','Diesel')->first();
$petrol_rate = \App\Models\Unit::where('type','Petrol')->first();

?>
@foreach($bb as $row)

@if($row->type == 1)
<?php
        $ti += $row->amount;
        ?>
@endif
@if($row->type == 2)
<?php
        $to += $row->amount;
        ?>
@endif


@endforeach
<!-- balance calulation end -->


{{-- stock calculation --}}

<?php 
$stock_details = \App\Models\Stock_detail::where('stockid',$petrol->id)->get();
    $liters = 0.00;
    $rliters = 0.00;
foreach ($stock_details as $row ) {
    if($row->status == 1){

        $liters +=  $row->liters;
    }else{
        $rliters += $row->liters;
    }
}

$petrol_stock = $liters - $rliters;

$stock_details = \App\Models\Stock_detail::where('stockid',$diesel->id)->get();
$liters = 0.00;
$rliters = 0.00;
foreach ($stock_details as $row ) {
if($row->status == 1){

$liters += $row->liters;
}else{
$rliters += $row->liters;
}
}
$diesel_stock = $liters - $rliters;


?>

<div class="card border-left-primary shadow h-100 ">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">
                    <p>Balance: <span class="balance">{{$ti - $to}}</span></p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card border-left-success shadow h-100 ml-3 ">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">
                    <p>Petrol Stock: <span class="balance">{{$petrol_stock}}</span></p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card border-left-warning shadow h-100 ml-3 ">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">
                    <p>Diesel Stock: <span class="balance">{{$diesel_stock}}</span></p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card border-left-success shadow h-100 ml-3 ">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">
                    <p>Petrol Rate: <span class="balance">{{$petrol_rate->rate}}</span></p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="card border-left-warning shadow h-100 ml-3 ">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ">
                    <p>Diessel Rate: <span class="balance">{{$diesel_rate->rate}}</span></p>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <div class="topbar-divider d-none d-sm-block">

    </div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
            <img class="img-profile rounded-circle" src="/theme/img/undraw_profile.svg">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/user/profile">
                <i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/logout" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>

</ul>