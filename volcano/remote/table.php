<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
  session_destroy();
  header("Location: ../../index.php");
}
$limit = "SELECT * FROM viewremotestation WHERE record_status != 'Archived'";

$rs_result1 = mysqli_query($conn, $limit);
$select = "SELECT * FROM tbl_station";
$rs_result2 = mysqli_query($conn, $select);
$select = "SELECT * FROM tbl_remote_stationtype";
$rs_result3 = mysqli_query($conn, $select);


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
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
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
  <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
  <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
  <script type="text/javascript" src="js/api.js"> </script>
  <script type="text/javascript" src="js/table.js"></script>
  <script type="text/javascript" src="js/addRemote.js"></script>
  <script type="text/javascript" src="js/updateRemote.js"></script>
  <script type="text/javascript" src="js/archive.js"></script>

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

  .btnView {
    background-color: #017469;
    border: none;
    color: white;
    padding: 6px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
  }

  .btnUpdate {
    background-color: #DB8131;
    border: none;
    color: white;
    padding: 6px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
  }

  a.btnUpdate:hover,
  a.btnView:hover,
  a.btnTrash:hover,
  a.btnAdd:hover,
  .btnAdd:hover,
  .btnView:hover {
    color: white;
    background-color: #3D4A50;
  }

  .btnViewSearch,
  .btnAdd {
    background-color: #02887B;
    border: none;
    color: white;
    padding: 7px 15px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
  }

  body {
    background-color: #9ef0ff;
  }

  tbody {
    background-color: white;
  }

  .modal-header .close {
    display: none;
  }

  th:nth-child(5),
  th:nth-child(6),
  th:nth-child(7),
  th:nth-child(8) {
    display: none;

  }

  td:nth-child(5),
  td:nth-child(6),
  td:nth-child(7),
  td:nth-child(8) {
    display: none;
  }
</style>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include_once '../../partial/sidebar.php' ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php include_once '../../partial/topbar.php' ?>
        <!-- End of Topbar -->
        <!--Container Main start-->

        <div class="container-fluid">
          <div class="card rounded-2 shadow-lg" style="background-color: #FFFFFF; border: none;">
            <div class="card-header" style="background-color: #FFFFFF">
              <form method="POST">
                <div class="row" style="margin-bottom:-7px;">
                  <div class="col-md-2 mt-2">
                    <div class="form-group">
                      <select id="cboSearchStation" name="cboSearchStation" class="form-select" required="required">
                        <option value="" selected disabled>--Select Volcano--</option>
                        <?php
                        $selectedVolcano = isset($_POST['cboSearchStation']) && $_POST['cboSearchStation'] === 'all' ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars("all", ENT_QUOTES) . "' $selectedVolcano>" . htmlspecialchars("All Volcano", ENT_QUOTES) . "</option>";

                        mysqli_data_seek($rs_result2, 0);
                        while ($stationrow = mysqli_fetch_assoc($rs_result2)) {
                          $station = $stationrow['Station'];
                          $selected = isset($_POST['cboSearchStation']) && $_POST['cboSearchStation'] === $station ? 'selected' : '';
                          echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' $selected>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 mt-2">
                    <div class="form-group">
                      <select id="cboSearchCat" name="cboSearchCat" class="form-select" required="required">
                        <option value="" selected disabled>--Select Category--</option>

                        <?php
                        $selected = isset($_POST['cboSearchCat']) && $_POST['cboSearchCat'] === 'all' ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars("all", ENT_QUOTES) . "' $selected>" . htmlspecialchars("All Category", ENT_QUOTES) . "</option>";

                        mysqli_data_seek($rs_result3, 0);
                        while ($searchCat = mysqli_fetch_assoc($rs_result3)) {
                          $catResult = $searchCat['station_type'];
                          $selected = isset($_POST['cboSearchCat']) && $_POST['cboSearchCat'] === $catResult ? 'selected' : '';
                          echo "<option value='" . htmlspecialchars($catResult, ENT_QUOTES) . "' $selected>" . htmlspecialchars($catResult, ENT_QUOTES) . "</option>";
                        }
                        ?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 mt-2">
                    <input type="submit" name="btnRemoteSearchRecord" class="btnView btn" id="btnRemoteSearchRecord" value="View Record">
                  </div>
                  <div class="col-md-5 mt-2 ">
                    <input type="button" name="btnAdd" class="btnAdd float-end" id="btnAdd" value="New Record">
                  </div>
                </div>

              </form>
            </div>
            <div class="card-body ">
              <div class="table-responsive  mt-2">
                <table class="table table-hover align-middle" id="datatableid" style=" color: black; font-size: 16px;">
                  <thead class="table-dark" style="  font-size: 14px;">
                    <tr>
                      <th>Station</th>
                      <th>Station Name</th>
                      <th>Category</th>
                      <th>Type</th>
                      <th>Latitude</th>
                      <th>Longitude</th>
                      <th>Elevation</th>
                      <th>Instrument</th>
                      <th>Date Started</th>
                      <th>Date Destroyed</th>
                      <th>Municipality</th>
                      <th>Province</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($rs_result1)) {
                      echo "
                      <tr>
                      <td class='align-middle text-left'>" . $row['Station'] . "</td>
                      <td class='align-middle text-left'>" . $row['station_name'] . "</td>
                      <td class='align-middle text-left'>" . $row['station_type'] . "</td>
                      <td class='align-middle text-left'>" . $row['category'] . "</td>
                      <td class='align-middle text-left'>" . $row['latitude'] . "</td>
                      <td class='align-middle text-left'>" . $row['longitude'] . "</td>
                      <td class='align-middle text-left'>" . $row['elevation'] . "</td>
                      <td class='align-middle text-left'>" . $row['instrument'] . "</td>
                      <td class='align-middle text-left'>" . $row['date_started'] . "</td>
                      <td class='align-middle text-left'>" . $row['date_destroyed'] . "</td>
                      <td class='align-middle text-left'>" . $row['municipality'] . "</td>
                      <td class='align-middle text-left'>" . $row['province'] . "</td>              
                      <td class='d-flex justify-content-left justify-content-md-left align-middle'>
                      <a class='btnUpdate update' data-id=" . $row['id'] . "><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
                      <a class='view btnView' id='" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-eye'></i></a>
                      <a class='delete btnTrash' id='del_" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-trash'></i></a>
                      </td>
                      
                      </tr>";
                    }

                    if (isset($_POST['btnRemoteSearchRecord'])) {

                      $s_Station = $_POST['cboSearchStation'];
                      $s_Cat = $_POST['cboSearchCat'];
                      $query = "";

                      if ($s_Station == "all" && $s_Cat == "all") {
                        $query = "SELECT * FROM viewremotestation";
                      } else if ($s_Station == "all" && $s_Cat != "all") {
                        $query = "SELECT * FROM viewremotestation WHERE station_type = '$s_Cat'";
                      } else if ($s_Station != "all" && $s_Cat == "all") {
                        $query = "SELECT * FROM viewremotestation WHERE Station = '$s_Station'";
                      } else {
                        $query = "SELECT * FROM viewremotestation WHERE  Station = '$s_Station' AND station_type = '$s_Cat'";
                      }

                      if ($query != " ") {
                        $searchResult = mysqli_query($conn, $query);
                        echo "<script> $('tbody').children().remove() </script>";
                        while ($row = mysqli_fetch_array($searchResult)) {
                          #Print all values
                          echo "
                          <tr>
                          <td class='align-middle text-left'>" . $row['Station'] . "</td>
                          <td class='align-middle text-left'>" . $row['station_name'] . "</td>
                          <td class='align-middle text-left'>" . $row['station_type'] . "</td>
                          <td class='align-middle text-left'>" . $row['category'] . "</td>
                          <td class='align-middle text-left'>" . $row['latitude'] . "</td>
                          <td class='align-middle text-left'>" . $row['longitude'] . "</td>
                          <td class='align-middle text-left'>" . $row['elevation'] . "</td>
                          <td class='align-middle text-left'>" . $row['instrument'] . "</td>
                          <td class='align-middle text-left'>" . $row['date_started'] . "</td>
                          <td class='align-middle text-left'>" . $row['date_destroyed'] . "</td>
                          <td class='align-middle text-left'>" . $row['municipality'] . "</td>
                          <td class='align-middle text-left'>" . $row['province'] . "</td>              
                          <td class='d-flex justify-content-left justify-content-md-left align-middle'>
                          <a class='btnUpdate update' data-id=" . $row['id'] . "><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
                          <a class='view btnView' id='" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-eye'></i></a>
                          <a class='delete btnTrash' id='del_" . $row['id'] . "' data-id=" . $row['id'] . "><i class='fa fa-trash'></i></a>
                          </td>
                          
                          </tr>";
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
      <?php include_once '../../partial/footer.php' ?>
      <!-- End of Footer -->
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- add record -->
    <?php include_once 'crud_modals/add_remote.php'; ?>
    <!-- update -->
    <?php include_once 'crud_modals/update_remote.php'; ?>

    <!-- view modal -->
    <div class="modal fade" id="viewStationModal" style=" color: black">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <div class="container">
              <h4 class="modal-title">Remote Station Information</h4>
            </div>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div class="container viewCont mt-2">

            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
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
            <a class="btn btn-primary" href="../../logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
</body>

</html>