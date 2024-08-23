<?php
include '../../database/mydb.php';
if (isset($_GET["id"])) {
    // Retrieve info from the database
    $id = $_GET["id"];

    // Check if the ID is a valid integer
    if (!is_numeric($id)) {
        echo "<script> location.href='table.php'; </script>";
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $select = "SELECT * FROM tblremote WHERE id = ?";
    $stmt = mysqli_prepare($conn, $select);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if existing, otherwise return to the table page
    if (mysqli_num_rows($result) <= 0) {
        echo "<script> location.href='station.php'; </script>";
        exit;
    } else {
        // There's a record existing

        $row = mysqli_fetch_array($result);


    }
} else {
    echo "<script> location.href='Station.php'; </script>";
}

?>
<!DOCTYPE html>
<html>

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update</title>

    <!-- Custom fonts for this template -->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>
    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../css/sb-admin-2.css" rel="stylesheet">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>


</head>
<style type="text/css">
    .card {
        margin: 0 auto;
        /* Added */
        float: none;
        /* Added */
        margin-bottom: 10px;
        /* Added */
    }

    .btn.btn-dark {
        padding: 8px 16px;
        /* Adjust the padding as needed */
        font-size: 16px;
        /* Adjust the font size as needed */
    }

    .row,
    .form-control,
    .form-select {
        box-shadow: none !important;
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
            style="font-size: 14px;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class=""></i>
                </div>
                <div class="sidebar-brand-text mx-3">Administrator</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../../navigation.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Stocks
            </div>


            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="../../stocks/add.php">
                    <i class="fas fa-fw fa-solid fa-plus"></i>
                    <span>Add Stock</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="../../stocks/table.php">
                    <i class="fas fa-fw fa-solid fa-table"></i>
                    <span>View Stock</span></a>
            </li>




            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaction
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Active</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Select</h6>
                        <a class="collapse-item" href="../../transaction/addTransaction.php">New Transaction</a>
                        <a class="collapse-item" href="../../transaction/table.php">View Transaction</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages1"
                    aria-expanded="true" aria-controls="collapsePages1">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Old </span>
                </a>
                <div id="collapsePages1" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Select</h6>
                        <a class="collapse-item" href="../../transaction/old/add.php">Add Transaction</a>
                        <a class="collapse-item" href="../../transaction/old/table.php">View Transaction</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Utilities
            </div>
            <li class="nav-item">
                <a class="nav-link" href="../../utilities/equipment.php">
                    <i class="fas fa-fw fa-solid fa-toolbox"></i>
                    <span>Equipment Categories</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../../utilities/stations/station.php">
                    <i class="fas fa-fw fa-solid fa-warehouse"></i>
                    <span>Stations</span></a>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Reports
            </div>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                    aria-expanded="true" aria-controls="collapsePages2">
                    <i class="fas fa-fw fa-regular fa-file-pdf"></i>
                    <span>Select Report</span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Select</h6>
                        <a class="collapse-item" href="../../stocks/filterReport.php">Stocks</a>
                        <a class="collapse-item" href="../../transaction/filterReport.php">Active Transaction</a>
                        <a class="collapse-item" href="../../transaction/table.php">Old Database Transaction</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Volcano
            </div>
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3"
                    aria-expanded="true" aria-controls="collapsePages3">
                    <i class="fas fa-fw fa-regular fa-flag"></i>
                    <span>Remote Station</span>
                </a>
                <div id="collapsePages3" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Select</h6>
                        <a class="collapse-item" href="../../Volcano/Remote/Station.php">View Remote Station</a>
                        <a class="collapse-item" href="../../Volcano/Remote/add.php">Add Remote Station</a>
                        <a class="collapse-item" href="../../Volcano/Diagram/NetworkDiagram.php">Network Diagram</a>
                        <a class="collapse-item" href="../../Volcano/Network/Map.php">Network Map</a>
                        <a class="collapse-item" href="../../Volcano/Observatory/Observatory.php">Observatory Photo</a>
                        <a class="collapse-item" href="../../Volcano/Acquisition/Data.php">Data Acquisition System</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">





            <!-- Divider -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #f0f0f0">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h5 style="margin-left: 20px; color: black;"> VND Equipment Monitoring System</h5>

                    <!-- Topbar Search -->
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <!-- Nav Item - Messages -->


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Joy Delos Santos</span>
                                <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <!--Container Main start-->
                <div class="container-fluid" style="background-color: #f0f0f0">
                    <div class="card-header" style="background-color: #f0f0f0">

                        <div class="row">


                            <div class="col-md-4">
                                <h4 class="paragraph" style="color: black;"> </h4>

                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="paragraph" style="color: black;"> </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="font-family: Arial, sans-serif; color: black;">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Volcano</label>
                                    <select name="cboVolcano" id="cboVolcano" class="form-select" required="required"
                                        style="color: black;" style="color: black;">

                                        <option value="None" selected disabled>--Select Here--</option>
                                        <option value="Mayon">Mayon</option>
                                        <option value="Pinatubo">Pinatubo</option>
                                        <option value="Bulusan">Bulusan</option>
                                        <option value="Taal">Taal</option>
                                        <option value="Kanlaon">Kanlaon</option>
                                        <option value="Hibok-hibok">Hibok-hibok</option>
                                        <option value="Matutum Parker">Matutum Parker</option>

                                    </select>

                                    <?php echo '<script> document.getElementById("cboVolcano").value = "' . $row['VolcanoName'] . '"; </script>'; ?>

                                </div>
                                <div class="col-md-3">
                                    <label>Station Name </label>
                                    <input type="text" name="stationName" class="form-control" placeholder="required"
                                        required="required" data-error="Required"
                                        value="<?php echo isset($row['StationName']) ? htmlspecialchars($row['StationName'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">

                                </div>

                                <div class="col-md-3">

                                    <label>Station Code</label>
                                    <input type="text" name="stationCode" class="form-control" placeholder="optional"
                                        value="<?php echo isset($row['StationCode']) ? htmlspecialchars($row['StationCode'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">
                                </div>
                                <div class="col-md-3">
                                    <label>Station Type</label>
                                    <select name="cboStationType" id="cboStationType" class="form-select"
                                        required="required" style="color: black;" style="color: black;">

                                        <option value="None" selected disabled>--Select Here--</option>

                                        <option value="SHORT PERIOD / TILT">Short Period/Tilt</option>
                                        <option value="PLATFORM TILT">Platform Tilt</option>
                                        <option value="BROADBAND">Broadband</option>
                                        <option value="SHORT PERIOD">Short Period</option>
                                        <option value="REPEATER">Repeater</option>
                                        <option value="BOREHOLE SEISMIC">Borehole Seismic</option>
                                        <option value="BOREHOLE TILT">Borehole Tilt</option>
                                        <option value="PLATFORM TILT/BROADBAND">Platform/Tilt Broadband</option>
                                        <option value="CO2/AWS">CO2/AWS</option>
                                        <option value="AUXILIARY OBSERVATORY ">Auxiliary Observatory </option>
                                        <option value="BROADBAND +TILT">Boradband +Tilt</option>
                                        <option value="SHORT PERIOD/THERMAL">Short Period/Thermal</option>
                                        <option value="OBSERVATORY">Observatory</option>
                                    </select>
                                    <?php echo '<script> document.getElementById("cboStationType").value = "' . $row['StationType'] . '"; </script>'; ?>

                                </div>



                            </div> <br>


                            <div class="row">

                                <div class="col-md-3">
                                    <label>Latitude</label>
                                    <input type="text" name="latitude" class="form-control" placeholder="optional"
                                        value="<?php echo isset($row['Latitude']) ? htmlspecialchars($row['Latitude'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">
                                </div>
                                <div class="col-md-3">
                                    <label>Longitude</label>
                                    <input type="text" name="longitude" class="form-control" placeholder="optional"
                                        value="<?php echo isset($row['Longitude']) ? htmlspecialchars($row['Longitude'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">

                                </div>
                                <div class="col-md-3">
                                    <label>Elevation</label>
                                    <input type="number" name="elevation" class="form-control" placeholder="optional"
                                        value="<?php echo isset($row['Elevation']) ? htmlspecialchars($row['Elevation'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">


                                </div>
                                <div class="col-md-3">
                                    <label>Instrument</label>
                                    <input type="text" name="instrument" class="form-control" placeholder="optional"
                                        value="<?php echo isset($row['Instrument']) ? htmlspecialchars($row['Instrument'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">


                                </div>

                            </div> <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Start Date</label>
                                    <input type="text" name="startDate" class="form-control" placeholder="optional"
                                        value="<?php echo isset($row['StartDate']) ? htmlspecialchars($row['StartDate'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">

                                </div>
                                <div class="col-md-3">
                                    <label>Destroyed by Eruption Date (Optional)</label>
                                    <input type="date" name="dateDestroyed" class="form-control"
                                        value="<?php echo isset($row['DestroyedByEruptionDate']) ? htmlspecialchars($row['DestroyedByEruptionDate'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">
                                </div>
                                <div class="col-md-3">

                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control" placeholder="required"
                                        required="required" data-error="Required"
                                        value="<?php echo isset($row['Location']) ? htmlspecialchars($row['Location'], ENT_QUOTES) : ''; ?>"
                                        style="color: black;">

                                </div>
                                <div class="col-md-3">
                                    <label>Category</label>
                                    <select name="cboCategory" id="cboCategory" class="form-select" required="required"
                                        style="color: black;" style="color: black;">

                                        <option value="None" selected disabled>--Select Here--</option>
                                        <option value="Seismic">Seismic Station</option>
                                        <option value="Repeater">Repeater Station</option>
                                        <option value="Tiltmeter">Tiltmeter Station</option>
                                        <option value="Proposed">Proposed Station</option>
                                        <option value="Decommissioned">Decommissioned Station</option>
                                        <option value="Destroyed">Destroyed</option>
                                    </select>

                                    <?php echo '<script> document.getElementById("cboCategory").value = "' . $row['Category'] . '"; </script>'; ?>

                                </div>




                            </div><br>
                            <div class="row">
                                <div class="col-md-4">

                                    <label for="form_message">Remarks</label>
                                    <textarea id="form_message" name="Remarks" class="form-control"
                                        placeholder="Optional" rows="2"
                                        style="color: black;"><?php echo isset($row['Remarks']) ? htmlspecialchars($row['Remarks'], ENT_QUOTES) : ''; ?></textarea>

                                </div>


                            </div><br>

                            <div class="row">
                                <div class="col-md-2">
                                    <a><button class="btn  pt-2 btn-block" name="btnUpdate"
                                            style="background-color:#0B5694; color: white">Update Station</button></a>
                                </div>
                            </div>
                        </form>

                    </div>


                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Footer</span>
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
                    <a class="btn btn-primary" href="">Logout</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>



<?php
if (isset($_POST['btnUpdate'])) {
    $VolcanoName = $_POST['cboVolcano'];
    $StationName = $_POST['stationName'];
    $StationCode = $_POST['stationCode'];
    $StationType = $_POST['cboStationType'];
    $Latitude = $_POST['latitude'];
    $Longitude = $_POST['longitude'];
    $Elevation = $_POST['elevation'];
    $Instrument = $_POST['instrument'];
    $StartDate = $_POST['startDate'];
    $DestroyDate = $_POST['dateDestroyed'];
    $Location = $_POST['location'];
    $Category = $_POST['cboCategory'];
    $Remarks = $_POST['Remarks'];



    //SQL statement with placeholders
    $update = "UPDATE tblremote SET
	            VolcanoName = ?,
	            StationName = ?,
	            StationCode = ?,
	            Location = ?,
	            Latitude = ?,
	            Longitude = ?,
	            Elevation = ?,
	            StationType = ?,
	            Instrument = ?,
	            StartDate = ?,
	            Category = ?,
	            DestroyedByEruptionDate = ?,
	            Remarks = ?
	            WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($update);

    // Bind parameters to the placeholders
    $stmt->bind_param(
        "ssssssssssssss",
        $VolcanoName,
        $StationName,
        $StationCode,
        $Location,
        $Latitude,
        $Longitude,
        $Elevation,
        $StationType,
        $Instrument,
        $StartDate,
        $Category,
        $DestroyDate,
        $Remarks,
        $id
    );

    // Execute the statement
    if ($stmt->execute()) {
        echo '
		        <script>
		            swal({
		                title: "Confirm",
		                text: "Successfully Updated",
		                icon: "success"
		            }).then(okay => {
		                if (okay) {
		                    window.location.href = "Station.php";
		                    exit;
		                }
		            });
		        </script>';
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>