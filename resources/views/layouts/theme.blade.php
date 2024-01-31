<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MK-Filling Station</title>

    <!-- Custom fonts for this template-->
    <link href="{!! asset('theme/vendor/fontawesome-free/css/all.min.css') !!}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{!! asset('theme/css/sb-admin-2.min.css') !!}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-gas-pump"></i>
                </div>
                <div class="sidebar-brand-text mx-3">MK-Filling Station<sup></sup></div>
            </a>


            <li class="nav-item">
                <a class="nav-link" href="/Roznamcha">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Roznamcha</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Purchase">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span>Purchase</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Sell">
                    <i class="fas fa-gas-pump"></i>
                    <span>Sell</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Stock">
                    <i class="fas fa-database"></i>
                    <span>Stock</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Party">
                    <i class="fas fa-address-book"></i>
                    <span>Party Kanta</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/Expenditure">
                    <i class="fas fa-money-bill"></i>
                    <span>Expenditures</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Salary">
                    <i class="fas fa-users"></i>
                    <span>Salary</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Units">
                    <i class="fas fa-gas-pump"></i>
                    <span>Units</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Investment">
                    <i class="fas fas fa-landmark"></i>
                    <span>Investment</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="/Shipment">
                    <i class="fas fa-truck"></i>
                    <span>Shipment</span></a>
            </li> --}}


            {{--
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2"
                    aria-expanded="false" aria-controls="collapseUtilities2">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Accounts Tab</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/Accounts">
                            <i class="fas fa-money-check-alt"></i>
                            <span>Accounts</span></a>

                        <a class="collapse-item" href="/Broker">
                            <i class="fas fa-money-check-alt"></i>
                            <span>Brokers</span></a>

                    </div>
                </div>
            </li>




            <li class="nav-item">
                <a class="nav-link" href="/FishTypes">
                    <i class="fas fa-fish"></i>
                    <span>Fish & Box Types</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Purchase">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Purchase List</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="false" aria-controls="collapseUtilities">
                    <i class="fas fa-warehouse"></i>
                    <span>Waste Tab</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/WasteInventory">
                            <i class="fas fa-warehouse"></i>
                            <span>Waste Inventory</span></a>
                        <a class="collapse-item" href="/WasteInventory/processlog">
                            <i class="fas fa-warehouse"></i>
                            <span>Waste Processed log</span></a>
                        <a class="collapse-item" href="/WasteInventory/wastesoldlog">
                            <i class="fas fa-warehouse"></i>
                            <span>Waste Sold log</span></a>
                    </div>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/BoxInventory">
                    <i class="fas fa-warehouse"></i>
                    <span>Box Inventory</span></a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="/Freezer">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Freezer</span></a>
            </li> --}}

            <!-- <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="/hawala">
                <i class="fas fa-money-check-alt"></i>
                    <span>Hawala Kanta</span></a>
            </li>
            <hr class="sidebar-divider"> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="/diesel">
                    <i class="fa fa-book"></i>
                    <span>Diesel Esaab tomin</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/diesel/stock">
                    <i class="fa fa-book"></i>
                    <span>Diesel Stock</span></a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                    <i class="fas fa-gas-pump"></i>
                    <span>Diesel</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Diesel</h6>
                        <a class="collapse-item" href="/diesel">Diesel Esaab tomin</a>
                        <a class="collapse-item" href="/diesel/stock">Diesel Stock</a>
                    </div>
                </div>
            </li> -->


            <!-- <hr class="sidebar-divider"> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="/maal">
                    <i class="fa fa-book"></i>
                    <span>Item List</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/gd/party/add">
                    <i class="fa fa-book"></i>
                    <span>GD Party Kanta</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/gd">
                    <i class="fa fa-book"></i>
                    <span>GD Clearance</span></a>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="false" aria-controls="collapseUtilities2">
                <i class="fas fa-truck-moving"></i>
                    <span>GD</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">GD</h6>
                        <a class="collapse-item" href="/maal">Item List</a>
                        <a class="collapse-item" href="/gd/party/add">GD Party Kanta</a>
                        <a class="collapse-item" href="/gd">GD Clearance</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider"> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="/cementorder">
                    <i class="fa fa-book"></i>
                    <span>Cement Orders/Kanta </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/cement/stock">
                    <i class="fa fa-book"></i>
                    <span>Cement Stock </span></a>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3" aria-expanded="false" aria-controls="collapseUtilities3">
                <i class="fas fa-layer-group"></i>
                    <span>Cement</span>
                </a>
                <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar" style="">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Cement</h6>
                        <a class="collapse-item" href="/cementorder">Cement Orders/Kanta </a>
                        <a class="collapse-item" href="/cement/stock">Cement Stock</a>
                    </div>
                </div>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link" href="/Stock">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Stock</span></a>
            </li> -->

            <!-- <li class="nav-item">
                <a class="nav-link" href="/Currency">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Currency</span></a>
            </li> -->
            <!--          
            <li class="nav-item">
                <a class="nav-link" href="/users">
                    <i class="fa fa-user"></i>
                    <span>Users</span></a>
            </li> -->


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    @include('layouts.navbar')
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @include('pages.messages')
                    <!-- Page Heading -->
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Majid Kalmati Filling Station 2022 </span>
                        <span>Developed By &#174;</span>
                        <a href="https://gedrosia.tech/" target="_blank" rel="noopener noreferrer">Gedrosia Technologies
                            SMC Pvt. Ltd.</a>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal-->

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center">Are you sure you want to delete this item?</p>
                    <form action="" method="post" id="deleteform">
                        @csrf
                        <input type="hidden" id="deleteid" value="" name="id">
                        <input type="hidden" id="resourseid" value="" name="sourceid">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="{!! asset('theme/vendor/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{!! asset('theme/vendor/jquery-easing/jquery.easing.min.js') !!}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{!! asset('theme/js/sb-admin-2.min.js') !!}"></script>

    <!-- Page level plugins -->
    <script src="{!! asset('theme/vendor/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') !!}"></script>

    <!-- Page level custom scripts -->
    <script src="{!! asset('theme/js/demo/datatables-demo.js') !!}"></script>

    <!-- Page level custom scripts -->
    <script src="{!! asset('js/script.js') !!}"></script>

    @yield('script')


</body>

</html>