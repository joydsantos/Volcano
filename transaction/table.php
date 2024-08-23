<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
  session_destroy();
  header("Location: ../index.php");
}

unset($_SESSION['update_new_transaction_id']);
unset($_SESSION['update_new_transaction_stock_id']);
include '../database/mydb.php';
$limit = "SELECT * FROM viewtransaction WHERE record_status != 'Archived' ORDER BY Date_Acquired DESC ";
$rs_result1 = mysqli_query($conn, $limit);

//query for stations 
$select = "SELECT * FROM tbl_station";
$rs_result2 = mysqli_query($conn, $select);


$select3 = "SELECT * FROM tbl_division";
$result3 = mysqli_query($conn, $select3);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Transaction</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet" />
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
  <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>

  <script src="division_modals/division.js"></script>
  <script src="js/table.js"></script>
  <script src="js/addtran.js"></script>
  <script src="js/updatetran.js"></script>
  <script src="js/archive.js"></script>
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
    margin-left: 5%;
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
  a.btnDownload:hover,
  .btnDivision:hover,
  .btnView:hover,
  a.btnNewTransfer:hover {
    color: white;
    background-color: #3D4A50;
  }

  .btnViewSearch {
    background-color: transparent;
    border: none;
    color: white;
    padding: 7px 15px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 0px;
    cursor: pointer;
  }

  .btnDivision {
    background-color: #017469;
    border: none;
    color: white;
    padding: 7px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-right: 2%;
    cursor: pointer;
  }

  .btnNewTran {
    background-color: transparent;
    border: none;
    color: white;
    padding: 2px 10px;
    border-radius: 20%;
    cursor: pointer;
  }

  .btnNewTran:hover {
    background-color: transparent;
  }

  .addIcon {

    color: #017469;
  }

  .addIcon:hover {
    color: #3D4A50;
  }

  .btnDownload {
    background-color: #F4C228;
    border: none;
    color: white;
    padding: 6px 16px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;

  }

  .btnNewTransfer {
    background-color: #0D3C65;
    border: none;
    color: white;
    padding: 6px 13px;
    font-size: 16px;
    border-radius: 5px;
    margin-left: 7px;
    cursor: pointer;
  }

  .btnViewSearch:hover body {
    background-color: #9ef0ff;
  }

  tbody {

    background-color: white;
  }

  .modal-header .close {
    display: none;
  }


  th:nth-child(3),
  th:nth-child(11) {
    display: none;
  }

  td:nth-child(3),
  td:nth-child(11) {
    display: none;
  }
</style>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include_once '../partial/sidebar.php' ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php include_once '../partial/topbar.php' ?>
        <!-- End of Topbar -->
        <!-- Begin Page Content Modal -->
        <!--Container Main start-->
        <div class="container-fluid">
          <div class="card rounded-2 shadow-lg" style="background-color: white; border: none;">
            <div class="card-header" style="background-color: #F5F5F5">
              <form method="POST">
                <div class="row" style="margin-bottom:-7px;">
                  <div class="col-md-2 mt-2">
                    <div class="form-group">
                      <select name="cbosearchActiveStation" id="cbosearchActiveStation" class=" form-select" required>
                        <option value="" selected disabled>Station</option>
                        <option value="All" <?php echo (isset($_POST['cbosearchActiveStation']) && $_POST['cbosearchActiveStation'] == 'All' ? 'selected' : ''); ?>>All Station</option>
                        <?php
                        # Loop through the result 
                        mysqli_data_seek($rs_result2, 0);
                        while ($row1 = mysqli_fetch_assoc($rs_result2)) {
                          $station = $row1['Station'];
                          $staId = $row1['id'];
                          $selected = (isset($_POST['cbosearchActiveStation']) && $_POST['cbosearchActiveStation'] == $station) ? 'selected' : '';
                          echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($staId, ENT_QUOTES) . "' $selected>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                        }
                        ?>
                      </select>
                      <input type="hidden" name="searchstationActiveId" id="searchstationActiveId" class="form-control shadow-sm" value="">
                    </div>
                  </div>
                  <div class="col-md-1 mt-2">
                    <div class="form-group">
                      <select name="cbosearchActiveStationCode" id="cbosearchActiveStationCode" class="form-select" required>
                        <option value="" selected disabled>Code</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 mt-2">
                    <div class="form-group">
                      <select name="cbosearchActiveEquipStatus" id="cbosearchActiveEquipStatus" class="form-select" required>
                        <option value="" selected disabled>Status</option>
                        <?php
                        $equipStatusOptions = array("All", "Damage", "Missing", "Ongoing Repair", "Serviceable", "Pulled Out", "For Disposal", "Unrepairable", "Others");
                        foreach ($equipStatusOptions as $status) {
                          $selectedStatus = (isset($_POST['cbosearchActiveEquipStatus']) && $_POST['cbosearchActiveEquipStatus'] == $status) ? 'selected' : '';
                          echo "<option value='" . htmlspecialchars($status, ENT_QUOTES) . "' $selectedStatus>" . htmlspecialchars($status, ENT_QUOTES) . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 mt-2">
                    <input type="date" id="newTrandateFrom" name="newTrandateFrom" class="form-control" value="<?php echo isset($_POST['dateFrom']) ? $_POST['dateFrom'] : ''; ?>">
                  </div>
                  <div class="col-md-2 mt-2">
                    <input type="date" id="newTrandateTo" name="newTrandateTo" class="form-control" value="<?php echo isset($_POST['dateTo']) ? $_POST['dateTo'] : ''; ?>">
                  </div>
                  <div class="col-md-3 mt-2">
                    <input type="checkbox" id="newTranallDate" name="newTranallDate" <?php echo isset($_POST['newTranallDate']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="allDate"> All Date</label>
                    <button type="submit" name="btnSearchActiveRecord" class="btnView" id="btnSearchActiveRecord">Search</button>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-2 mt-4">
                    <button type="button" name="btnNewTran" class="btnNewTran" id="btnNewTran"><i class="fas fa-plus fa-2x addIcon"></i></button>
                  </div>
                  <div class="col-md-10 mt-4">
                    <input type="button" name="btnDivision" class="btnDivision float-end" id="btnDivision" value="Manage Division / Section Head">

                  </div>
                </div>
              </form>
            </div>
            <div class="card-body ">
              <div class="table-responsive mt-2">
                <table class="table table-sm  table-hover align-middle" id="datatableid" style=" color: black; font-size: 15px;">
                  <thead class="table-dark" style=" font-size: 16px;">
                    <tr>
                      <th>Transaction Number</th>
                      <th>Stock Number</th>
                      <th>Serial</th>
                      <th>Qty</th>
                      <th>Date Acquired</th>
                      <th>Transferred From</th>
                      <th>Transferred To</th>
                      <th>Installed At</th>
                      <th>Receipt</th>
                      <th>Action</th>
                      <th>Code</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($rs_result1)) {
                      echo '
                              <tr>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Transaction_Number']) . '</td>
                                  <td class="align-middle text-left"> ' . htmlspecialchars($row['stockId']) . '</td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Serial_Number']) . '</td>                              
                                  <td class="align-middle text-left">' . htmlspecialchars($row['qty']) . '</td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Date_Acquired']) . '</td>
                                  <td class="align-middle text-left"> ' . htmlspecialchars($row['Transferred_From']) . '</td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Transferred_To']) . '</td>                                     
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Station']) . '</td>
                                  <td class="align-middle text-left"><a href="OR/' . htmlspecialchars($row['Filepath']) . '" class="btnDownload" style="text-decoration: none;" download>
                                  <i class="fa fa-download" aria-hidden="true"></i></a></td>                                
                                  <td class="d-flex text-left">
                                     <a class="update btnUpdate" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                      <a class="view btnView" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-eye"></i></a>
                                      <a class="delete btnTrash" id="del_' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-trash"></i></a>
                                      <a class="transfer btnNewTransfer" id="trans_' . htmlspecialchars($row['Transaction_Number']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-exchange"></i></a>
                                  </td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Station_Code']) . '</td>
                              </tr>
                          ';
                    }
                    #search result
                    if (isset($_POST['btnSearchActiveRecord'])) {
                      $dateFrom = isset($_POST['newTrandateFrom']) ? $_POST['newTrandateFrom'] : null;
                      $dateTo = isset($_POST['newTrandateTo']) ? $_POST['newTrandateTo'] : null;
                      $s_Station = $_POST['cbosearchActiveStation'];
                      $s_Code = $_POST['cbosearchActiveStationCode'];
                      $s_Status = $_POST['cbosearchActiveEquipStatus'];
                      $query = "";

                      if (isset($_POST['newTranallDate'])) {
                        if ($s_Station == "All" && $s_Code == "All Code" && $s_Status == "All") {
                          $query = "SELECT * FROM viewtransaction";
                        } else if ($s_Station == "All" && $s_Code == "All Code" && $s_Status != "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Status = '$s_Status'";
                        } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status == "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station'";
                        } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status != "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Status='$s_Status'";
                        } else if ($s_Station != "All" && $s_Code != "All Code" && $s_Status == "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code'";
                        } else {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code' AND Status='$s_Status'";
                        }
                      } else {
                        if ($s_Station == "All" && $s_Code == "All Code" && $s_Status == "All") {

                          $query = "SELECT * FROM viewtransaction WHERE Date_Acquired BETWEEN COALESCE('$_POST[newTrandateFrom]', '0000-00-00') AND COALESCE('$_POST[newTrandateTo]', '9999-12-31') ";
                        } else if ($s_Station == "All" && $s_Code == "All Code" && $s_Status != "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Status = '$s_Status' AND Date_Acquired BETWEEN COALESCE('$_POST[newTrandateFrom]', '0000-00-00') AND COALESCE('$_POST[newTrandateTo]', '9999-12-31') ";
                        } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status == "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Date_Acquired BETWEEN COALESCE('$_POST[newTrandateFrom]', '0000-00-00') AND COALESCE('$_POST[newTrandateTo]', '9999-12-31')";
                        } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status != "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Status='$s_Status' AND Date_Acquired BETWEEN COALESCE('$_POST[newTrandateFrom]', '0000-00-00') AND COALESCE('$_POST[newTrandateTo]', '9999-12-31')";
                        } else if ($s_Station != "All" && $s_Code != "All Code" && $s_Status == "All") {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code' AND Date_Acquired BETWEEN COALESCE('$_POST[newTrandateFrom]', '0000-00-00') AND COALESCE('$_POST[newTrandateTo]', '9999-12-31')";
                        } else {
                          $query = "SELECT * FROM viewtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code' AND Status='$s_Status' AND Date_Acquired BETWEEN COALESCE('$_POST[newTrandateFrom]', '0000-00-00') AND COALESCE('$_POST[newTrandateTo]', '9999-12-31')";
                        }
                      }
                      if ($query != "") {
                        $searchResult = mysqli_query($conn, $query);
                        echo "<script> $('tbody').children().remove() </script>";
                        while ($row = mysqli_fetch_array($searchResult)) {
                          echo '
                              <tr>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Transaction_Number']) . '</td>
                                  <td class="align-middle text-left"> ' . htmlspecialchars($row['stockId']) . '</td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Serial_Number']) . '</td>                               
                                  <td class="align-middle text-left">' . htmlspecialchars($row['qty']) . '</td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Date_Acquired']) . '</td>
                                  <td class="align-middle text-left"> ' . htmlspecialchars($row['Transferred_From']) . '</td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Transferred_To']) . '</td>                                     
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Station']) . '</td>
                                  <td class="align-middle text-left"><a href="OR/' . htmlspecialchars($row['Filepath']) . '" class="btnDownload" style="text-decoration: none;" download>
                                  <i class="fa fa-download" aria-hidden="true"></i></a></td>                                 
                                  <td class="d-flex text-left">
                                     <a class="update btnUpdate" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                      <a class="view btnView" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-eye"></i></a>
                                      <a class="delete btnTrash" id="del_' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-trash"></i></a>
                                  </td>
                                  <td class="align-middle text-left">' . htmlspecialchars($row['Station_Code']) . '</td>
                              </tr>
                          ';
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
      </div>
      <!-- End of Main Content -->
      <!-- division -->
      <?php include_once 'division_modals/division.php' ?>
      <!-- view modal -->
      <?php include_once 'crud_modals/view.php' ?>
      <!-- add modal -->
      <?php include_once 'crud_modals/add.php' ?>
      <!-- update -->
      <?php include_once 'crud_modals/update.php' ?>
      <!-- Footer -->
      <?php include_once '../partial/footer.php' ?>
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
          <a class="btn btn-primary" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>