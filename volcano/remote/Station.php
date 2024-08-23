<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
	session_destroy();
	header("Location: ../../index.php");
}
$limit = "SELECT * FROM tblremote ";
$rs_result1 = mysqli_query($conn, $limit);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Remote Station</title>
    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <!-- Custom styles for this template-->
      <link href="../../css/sb-admin-2.css" rel="stylesheet">
      <!-- Bootstrap core JavaScript-->
      <script src="../../vendor/jquery/jquery.min.js"></script>
      <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="../../js/sb-admin-2.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet"/>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
      <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
    </head>
    <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500');
    .pagination a {
    color: black;
    padding: 8px 16px;
    text-decoration: none;
    margin: 0 2px;
    }
    .btnTrash {
    background-color: #7d0000;
    border: none;
    color: white;
    padding: 6px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
    }
    .btnView{
    background-color:#017469;
    border: none;
    color: white;
    padding: 6px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
    }
    .btnUpdate {
    background-color:#DB8131;
    border: none;
    color: white;
    padding: 6px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
    }
    a.btnUpdate:hover,  a.btnView:hover,   a.btnTrash:hover
    {
    color: white; background-color: #3D4A50;
    }
    .btnViewSearch{
    background-color:#02887B;
    border: none;
    color: white;
    padding: 7px 15px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
    }
    body
    {
    background-color: #9ef0ff;
    }
    tbody {
    background-color: white;
    }
    .modal-header .close {
    display:none;
    }
    .row,.form-control, .form-select,.form-check-input
    {
    box-shadow: none !important;
    }
    </style>
    <script>
    $(document).ready(function () {
    // Delete
    $('.delete').click(function () {
    var el = this;
    // Delete id
    var deleteid = $(this).data('id');
    // Confirm box
    bootbox.confirm("Do you really want to delete record?", function (result)  {
    if (result) {
    // AJAX Request
    $.ajax({
    url: 'deletestation.php',
    type: 'POST',
    data: {id: deleteid},
    success: function (response) {
    // Removing row from HTML Table
    if (response == 1) {
    $(el).closest('tr').css('background', 'tomato');
    $(el).closest('tr').fadeOut(800, function () {
    $(this).remove();
    });
    swal({
    title: "Confirm",
    text: "Sucessfully Deleted",
    icon: "success"}).then(okay => {
    if (okay) {
    window.location.href = "Station.php";
    exit;
    }
    });
    }
    else if (response == 4){
    swal("Can not be deleted", "Error");
    }
    else {
    swal("Can not be deleted", "Something went wrong");
    }
    }
    });
    }
    });
    });
    });
    $(document).ready(function(){
    $('.view').click(function(){
    stockid = $(this).attr('id');
    //console.log( stockid);
    $.ajax({url: "view.php",
    method:'POST',
    data:{ stockid: stockid},
    success: function(result){
    $(".modal-body").html(result);
    }});
    $('#viewModal').modal("show");
    })
    })
    function toggleCheckbox(isChecked) {
    if(isChecked) {
    $('input[id="chck"]').each(function() {
    this.checked = true;
    });
    } else {
    $('input[id="chck"]').each(function() {
    this.checked = false;
    });
    }
    }
    function toggleCheckbox1(isChecked) {
    if(isChecked) {
    }
    else
    {
    $('input[id="chckAll"]').each(function() {
    this.checked =false;
    });
    }
    }
    $(document).ready(function()
    {
    $('#datatableid').DataTable();
    });
    </script>
    <body id="page-top" >
      <!-- Page Wrapper -->
      <div id="wrapper" >
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
              <li class="nav-item">
                <a class="nav-link" href="../../transaction/old/table.php">
                  <i class="fas fa-fw fa-solid fa-table"></i>
                  <span>Old Record</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../table.php">
                    <i class="fas fa-fw fa-solid fa-table"></i>
                    <span>On Stock</span></a>
                  </li>
                  <!-- Nav Item - Pages Collapse Menu -->
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
                      <li class="nav-item">
                        <a class="nav-link" href="../../utilities/user/vnd-user.php">
                          <i class="fas fa-fw  fa-user"></i>
                          <span>Users</span></a>
                        </li>
                        <hr class="sidebar-divider">
                        <!-- Heading -->
                        <div class="sidebar-heading">
                          Volcano
                        </div>
                        <!-- Nav Item - Tables -->
                        <li class="nav-item">
                          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true"
                            aria-controls="collapsePages3">
                            <i class="fas fa-fw fa-regular fa-flag"></i>
                            <span>Remote Station</span>
                          </a>
                          <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
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
                      <div id="content-wrapper" class="d-flex flex-column">
                        <!-- Sidebar -->
                        <!-- End of Sidebar -->
                        <!-- Content Wrapper -->
                        <div id="content-wrapper" class="d-flex flex-column">
                          <!-- Main Content -->
                          <div id="content"    >
                            <!-- Topbar -->
                            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                              <!-- Sidebar Toggle (Topbar) -->
                              <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                              <i class="fa fa-bars"></i>
                              </button>
                              <h5 style="margin-left: 20px; color: black"> VND Equipment Monitoring System</h5>
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
                                    <img class="img-profile rounded-circle"
                                    src="../../img/undraw_profile.svg">
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
                            <!-- Begin Page Content Modal -->
                            <div class="modal" id="viewModal" style=" color: black">
                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Station Information</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <!-- Add the content for the modal body here -->
                                  </div>
                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--Container Main start-->
                            <div class="container-fluid">
                              <div class="card" style="background-color: #9ef0ff; border: none;">
                                <div class="card-header" style="background-color: #F7F7F7;">
                                  <form method="POST">
                                    <div class="row  mt-3 ">
                                      <div class=" col-md-2"> <!-- Increased col-md-1 to col-md-2 to accommodate the checkbox -->
                                      <div class="form-group">
                                        <?php
$volcanoOptions = array(
	'all' => 'All Volcano',
	'Mayon' => 'Mayon',
	'Pinatubo' => 'Pinatubo',
	'Hibok-Hibok' => 'Hibok-Hibok',
	'Taal' => 'Taal',
	'Kanlaon' => 'Kanlaon',
	'Bulusan' => 'Bulusan',
	'Matutum Parker' => 'Matutum and Parker',
);
?>
                                        <select id="form_need" name="cboVolcano" class="form-select" required="required">
                                          <?php
foreach ($volcanoOptions as $value => $label) {
	$selected = (isset($_POST['cboVolcano']) && $_POST['cboVolcano'] == $value) ? 'selected' : '';
	echo "<option value=\"$value\" $selected>$label</option>";
}
?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <div class="form-group">
                                        <?php
$stationOptions = array(
	'all' => 'All Station',
	'Seismic' => 'Seismic Station',
	'Repeater' => 'Repeater Station',
	'Tiltmeter' => 'Tiltmeter Station',
	'Proposed' => 'Proposed Station',
	'Decommissioned' => 'Decommissioned Station',
	'Destroyed' => 'Destroyed by Eruption',
);
?>
                                        <select name="cboStation" id="cboStation" class="form-select" required="required">
                                          <?php
foreach ($stationOptions as $value => $label) {
	$selected = (isset($_POST['cboStation']) && $_POST['cboStation'] == $value) ? 'selected' : '';
	echo "<option value=\"$value\" $selected>$label</option>";
}
?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-md-1 ">
                                      <input type="submit" name="btnView" class="btnViewSearch" value="View Station"  >
                                    </div>
                                  </div>
                                </form>
                              </div>
                              <div class="card-body " style="background-color: #F7F7F7; ">
                                <div class="table-responsive  mt-2">
                                  <table class="table table-hover align-middle" id="datatableid" style=" color: black; font-size: 16px;">
                                    <thead class="table-dark" style="  font-size: 14px;">
                                      <tr>
                                        <th>Volcano</th>
                                        <th>Station</th>
                                        <th>Code</th>
                                        <th>Location</th>
                                        <th>Elevation</th>
                                        <th>Type</th>
                                        <th>Station</th>
                                        <th>Date Installed</th>
                                        <th >Action</th>
                                      </tr>
                                    </thead>
                                    <tbody >
                                      <?php
while ($row = mysqli_fetch_array($rs_result1)) {
	echo "
                                      <tr>
                                        <td class='align-middle text-left'>" . $row['VolcanoName'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StationName'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StationCode'] . "</td>
                                        <td class='align-middle text-left'>" . $row['Location'] . "</td>
                                        <td class='align-middle text-left'>" . $row['Elevation'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StationType'] . "</td>
                                        <td class='align-middle text-left'>" . $row['Category'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StartDate'] . "</td>
                                        <td class='d-flex justify-content-left justify-content-md-end align-middle'>
                                          <a class='btnUpdate ' href='update.php?id=" . $row['id'] . "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
                                          <a class='view btnView' id='" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-eye'></i></a>
                                          <a class='delete btnTrash' id='del_" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-trash'></i></a>
                                        </td>
                                      </tr>";
}
if (isset($_POST['btnView'])) {
	$volcano = $_POST['cboVolcano'];
	$station = $_POST['cboStation'];
	# $catg = $_POST['cboViewCat'];
	$query = "";
	#check f wala naka slect
	if ($volcano == "all" && $station == "all") {
	} else if ($volcano == "all" && $station != "all") {
		$query = "SELECT * FROM tblremote WHERE Category ='$station'";
	} else if ($volcano != "all" && $station == "all") {
		$query = "SELECT * FROM tblremote WHERE VolcanoName ='$volcano'";
	} else if ($volcano != "all" && $station != "all station") {
		$query = "SELECT * FROM tblremote WHERE VolcanoName ='$volcano' AND Category = '$station'";
	}
	if ($query != "") {
		$catResult = mysqli_query($conn, $query);
		echo "<script> $('tbody').children().remove() </script>";
		while ($row = mysqli_fetch_array($catResult)) {
			#Print all values
			echo "
                                      <tr>
                                        <td class='align-middle text-left'>" . $row['VolcanoName'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StationName'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StationCode'] . "</td>
                                        <td class='align-middle text-left'>" . $row['Location'] . "</td>
                                        <td class='align-middle text-left'>" . $row['Elevation'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StationType'] . "</td>
                                        <td class='align-middle text-left'>" . $row['Category'] . "</td>
                                        <td class='align-middle text-left'>" . $row['StartDate'] . "</td>
                                        <td class='d-flex justify-content-center justify-content-md-end align-middle'>
                                          <a class='btnUpdate ' href='update.php?id=" . $row['id'] . "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
                                          <a class='view btnView' id='" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-eye'></i></a>
                                          <a class='delete btnTrash' id='del_" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-trash'></i></a>
                                        </td>
                                      </tr>
                                      ";
		}
	}
}
?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
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
                            <a class="btn btn-primary" href="../../logout.php">Logout</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </body>
                </html>