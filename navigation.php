<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: index.php");
}
include 'database/mydb.php';
//include 'stocksNav.php';

#sum of stocks   
$select = "SELECT SUM(Qty) as totalStocks FROM tblstocks WHERE record_status != 'Archived'";
$result = mysqli_query($conn, $select);

if ($result === false) {
    // Query execution failed
    echo "Error: " . mysqli_error($conn);
    // Additional error handling if necessary
} else {
    $row = mysqli_fetch_assoc($result);
    $total = $row['totalStocks'];
}

if (is_null($total)) {
    $total = 0;
}
#sumSFunctional
$totalSFunctional = "SELECT SUM(Qty) as totalSFunctional FROM tblstocks  WHERE Status = 'Functional' AND  record_status != 'Archived'";
$resultFunctional = mysqli_query($conn, $totalSFunctional);
$rowFunctional = mysqli_fetch_assoc($resultFunctional);
$totalSFunctional = $rowFunctional['totalSFunctional'];

if (is_null($totalSFunctional)) {
    $totalSFunctional = 0;
}

#sumSFunctional
$totalSDefective = "SELECT SUM(Qty) as totalSDefective FROM tblstocks  WHERE Status = 'Defective' AND  record_status != 'Archived'";
$resultDefective = mysqli_query($conn, $totalSDefective);
$rowDefective = mysqli_fetch_assoc($resultDefective);
$totalSDefective = $rowDefective['totalSDefective'];

if (is_null($totalSDefective)) {
    $totalSDefective = 0;
}




#sumdeployed
$deployed = "SELECT SUM(Qty) as totaldeployed FROM viewtransaction  WHERE Status !='Missing' AND Status !='Pulled Out' AND  record_status != 'Archived'";
$resultdeployed = mysqli_query($conn, $deployed);
$rowdeployed = mysqli_fetch_assoc($resultdeployed);
$totaldeployed = $rowdeployed['totaldeployed'];

if (is_null($totaldeployed)) {
    $totaldeployed = 0;
}


#sumserviceable
$functional = "SELECT SUM(Qty) as totalserviceable FROM viewtransaction WHERE Status ='Serviceable' AND  record_status != 'Archived'";
$resulttotalserviceable = mysqli_query($conn, $functional);
$rowtotalserviceable = mysqli_fetch_assoc($resulttotalserviceable);
$totalserviceable = $rowtotalserviceable['totalserviceable'];

if (is_null($totalserviceable)) {
    $totalserviceable = 0;
}

#sumdeffectivez
$defective = "SELECT SUM(Qty) as totaldefective FROM viewtransaction  WHERE Status ='Damage' AND  record_status != 'Archived' ";
$resultdefective = mysqli_query($conn, $defective);
$rowdefective = mysqli_fetch_assoc($resultdefective);
$totaldamage = $rowdefective['totaldefective'];

if (is_null($totaldamage)) {
    $totaldamage = 0;
}

#ongoing repair
$OngoingRepair = "SELECT SUM(Qty) as totalOngoingRepair FROM viewtransaction  WHERE Status ='Ongoing Repair' AND  record_status != 'Archived'";
$resultOngoingRepair = mysqli_query($conn, $OngoingRepair);
$rowOngoingRepair = mysqli_fetch_assoc($resultOngoingRepair);
$totalOngoingRepair = $rowOngoingRepair['totalOngoingRepair'];

if (is_null($totalOngoingRepair)) {
    $totalOngoingRepair = 0;
}


# PulledOut
$PulledOut = "SELECT SUM(Qty) as totalPulledOut FROM viewtransaction  WHERE Status ='Pulled Out' AND  record_status != 'Archived'";
$resultPulledOut = mysqli_query($conn, $PulledOut);
$rowPulledOut = mysqli_fetch_assoc($resultPulledOut);
$totalPulledOut = $rowPulledOut['totalPulledOut'];

if (is_null($totalPulledOut)) {
    $totalPulledOut = 0;
}

#Missing
$missing = "SELECT SUM(Qty) as totalmissing FROM viewtransaction  WHERE Status ='Missing' AND  record_status != 'Archived'";
$resultmissing = mysqli_query($conn, $missing);
$rowmissing = mysqli_fetch_assoc($resultmissing);
$totalmissing = $rowmissing['totalmissing'];

if (is_null($totalmissing)) {
    $totalmissing = 0;
}

#total active tran
$transaction = "SELECT COUNT(id) as totaltransaction FROM viewtransaction WHERE record_status != 'Archived' ";
$resulttransaction = mysqli_query($conn, $transaction);
$rowtransaction = mysqli_fetch_assoc($resulttransaction);
$totaltransaction = $rowtransaction['totaltransaction'];

if (is_null($totaltransaction)) {
    $totaltransaction = 0;
}

#total for disposal
$disposal = "SELECT SUM(Qty) as totaldisposal FROM viewtransaction  WHERE Status ='For Disposal' AND  record_status != 'Archived'";
$resultdisposal = mysqli_query($conn, $disposal);
$rowdisposal = mysqli_fetch_assoc($resultdisposal);
$totaldisposal = $rowdisposal['totaldisposal'];

if (is_null($totaldisposal)) {
    $totaldisposal = 0;
}

#total unrep
$unrepairable = "SELECT SUM(Qty) as totalunrepairable FROM viewtransaction  WHERE Status ='Unrepairable' AND  record_status != 'Archived'";
$resultunrepairable = mysqli_query($conn, $unrepairable);
$rowunrepairable = mysqli_fetch_assoc($resultunrepairable);
$totalunrepairable = $rowunrepairable['totalunrepairable'];

if (is_null($totalunrepairable)) {
    $totalunrepairable = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">


</head>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500');
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include_once 'partial/sidebar.php' ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once 'partial/topbar.php' ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <!--Container Main start-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3  mb-4 ">
                            <a href="">
                                <div class="card border-left-success shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Available Stocks</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $total ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3  mb-4 ">
                            <a href="">
                                <div class="card border-left-success   shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Functional</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalSFunctional; ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3  mb-4 ">
                            <a href="">
                                <div class="card border-left-success  shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Defective</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalSDefective ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3  mb-4 ">
                            <a href="">
                                <div class="card border-left-warning shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Serviceable</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalserviceable ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <a href="">
                                <div class="card border-left-warning shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Ongoing Repair</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalOngoingRepair ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <a href="">
                                <div class="card border-left-warning shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Pulled Out</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalPulledOut ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <a href="">
                                <div class="card border-left-warning  shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Missing</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalmissing ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4 ">
                            <a href="">
                                <div class="card border-left-warning shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Damage</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totaldamage ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3  mb-4 ">
                            <a href="">
                                <div class="card border-left-warning shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total for Disposal</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totaldisposal ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-3  mb-4 ">
                            <a href="">
                                <div class="card border-left-warning shadow h-100 py-2 ">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Unrepairable</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span>
                                                        <?php echo $totalunrepairable ?>
                                                    </span></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-9 col-lg-6">
                            <div class="card shadow mb-4 border-left-danger">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Recent Activity</h5>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Option</div>
                                            <a class="dropdown-item" href="#">Option 1</a>
                                            <a class="dropdown-item" href="#">Option 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Option 3</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card shadow mb-4 border-left-danger">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Philippine Volcano Active Map</h5>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <img src="img/nav.png " class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php include_once 'partial/footer.php' ?>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>