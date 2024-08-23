<?php
include '../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
  session_destroy();
  header("Location: ../index.php");
}
unset($_SESSION['stock_Id']);
$limit = "SELECT * FROM viewstocks WHERE record_status != 'Archived'";
$rs_result1 = mysqli_query($conn, $limit);


$query = "SELECT * FROM tbl_equipmentcategory";
$sanitizedQuery = mysqli_real_escape_string($conn, $query);
$rs_result = mysqli_query($conn, $sanitizedQuery);


$unitquery = "SELECT * FROM tbl_unit_measurement";
$sanitizedQuery1 = mysqli_real_escape_string($conn, $unitquery);
$rs_result2 = mysqli_query($conn, $sanitizedQuery1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Stocks</title>
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
  <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>


  <script src="../vendor/sweetalert/sweetalert.min.js"></script>
  <script src="js/table.js"></script>
  <script src="js/addstock.js"></script>
  <script src="js/archive.js"></script>

</head>

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
        <!--Container Main start-->
        <div class="container-fluid">
          <div class="card rounded-2 shadow-lg" style="background-color: #FFFFFF; border: none;">
            <div class="card-header" style="background-color: #FFFFFF">
              <form method="POST">
                <div class="row mt-3">
                  <div class=" col-md-2">
                    <!-- Increased col-md-1 to col-md-2 to accommodate the checkbox -->
                    <div class="form-group">
                      <select id="form_need" name="cboViewStat" class="form-select">
                        <?php
                        $statusOptions = array('all' => 'All Items', 'Functional' => 'Functional', 'Defective' => 'Defective');
                        foreach ($statusOptions as $value => $label) {
                          $selected = (isset($_POST['cboViewStat']) && $_POST['cboViewStat'] == $value) ? 'selected' : '';
                          echo "<option value=\"$value\" $selected>$label</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="cboViewCat" class="form-select">
                        <option value="all" <?php if (isset($_POST['cboViewCat']) && $_POST['cboViewCat'] == 'all')
                                              echo "selected='selected'"; ?>>All Category</option>
                        <?php

                        $querycat = "SELECT category FROM tbl_equipmentcategory";
                        $rs_resultcat = mysqli_query($conn, $querycat);
                        // Loop through the result set and create an option for each category.
                        while ($row = mysqli_fetch_assoc($rs_resultcat)) {
                          $category = $row['category'];
                          $selected = isset($_POST['cboViewCat']) && $_POST['cboViewCat'] === $category ? 'selected' : '';
                          echo "<option value='" . htmlspecialchars($category, ENT_QUOTES) . "' $selected>$category</option>";
                        }
                        ?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-1 mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chckAll" name="chckAll" value="All" <?php if (isset($_POST['chckAll']))
                                                                                                                echo "checked='checked'"; ?> onClick="toggleCheckbox(this.checked);">
                      <label class="form-check-label" for="chckAll">All Stocks</label>
                    </div>
                  </div>
                  <div class="col-md-1 mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chck" name="chcHigh" value="High Stocks" <?php if (isset($_POST['chcHigh']))
                                                                                                                      echo "checked='checked'"; ?> onClick="toggleCheckbox1(this.checked);">
                      <label class="form-check-label">High Stocks</label>
                    </div>
                  </div>
                  <div class="col-md-1 mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="chck" name="chckLow" value="Low Stocks" <?php if (isset($_POST['chckLow']))
                                                                                                                    echo "checked='checked'"; ?> onClick="toggleCheckbox1(this.checked);">
                      <label class="form-check-label">Low Stock</label>
                    </div>
                  </div>
                  <div class="col-md-1 mt-2">
                    <div class="form-group">

                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="chck" name="chckOut" value="Out of Stocks" <?php if (isset($_POST['chckOut']))
                                                                                                                          echo "checked='checked'"; ?> onClick="toggleCheckbox1(this.checked);">
                        <label class="form-check-label" style="font-size: 15px;">Out of
                          Stocks</label>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-1">
                    <input type="submit" name="btnViewStock" class="btnViewSearch" value="Search">
                  </div>
                  <div class="row">
                    <div class="col-md-12 mt-2">

                      <button type="button" name="btnAddStock" class="btnAddStock" id="btnAddStock"> <i class="fas fa-plus fa-2x addIcon"></i></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-body ">
              <div class="table-responsive  mt-2">
                <table class="table table-sm table-hover stock-table" id="datatableid" style=" color: black; font-size: 15px;">
                  <thead class="table-dark" style="  font-size: 16px;">
                    <tr>
                      <th>Stock Number</th>
                      <th>Item Name</th>
                      <th>Serial Number</th>
                      <th>Property Number</th>
                      <th>MAC</th>
                      <th>Received</th>
                      <th>Total</th>
                      <th>Remaining</th>
                      <th>Unit</th>
                      <th>PAR/ICS Assignee</th>
                      <th>Receipt</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($rs_result1)) { ?>
                      <tr>
                        <td><?= htmlspecialchars($row['stockId']) ?></td>
                        <td><?= htmlspecialchars($row['Item_Name']) ?></td>
                        <td><?= htmlspecialchars($row['Serial_Number']) ?></td>
                        <td><?= htmlspecialchars($row['Property_Number']) ?></td>
                        <td><?= htmlspecialchars($row['MAC']) ?></td>
                        <td><?= htmlspecialchars($row['Date_Recieved']) ?></td>
                        <td><?= htmlspecialchars($row['total_Recieved']) ?></td>
                        <td>
                          <?php
                          if ($row['Qty'] <= 10 && $row['Special_Qty'] === "Special") {
                            echo '<span class="badge badge-pill badge-warning">' . $row['Qty'] . '</span>';
                          } else if ($row['Qty'] <= 10 && $row['Special_Qty'] === "Regular") {
                            echo '<span class="badge badge-pill badge-danger">' . $row['Qty'] . '</span>';
                          } else {
                            echo '<span class="badge badge-pill badge-success">' . $row['Qty'] . '</span>';
                          }
                          ?>
                        </td>
                        <td><?= htmlspecialchars($row['Unit'])  ?></td>
                        <td><?= htmlspecialchars($row['Par']) ?></td>
                        <td class="align-middle text-left"><a href="OR/<?= htmlspecialchars($row['Filepath']) ?>" class="btnDownload" style="text-decoration: none;" download>
                            <i class="fa fa-download" aria-hidden="true"></i></a></td>

                        <td class="d-flex text-left">
                          <a class="update btnUpdate" id="<?= htmlspecialchars($row['id']) ?>" data-id="<?= htmlspecialchars($row['id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          <a class="view btnView" id="<?= htmlspecialchars($row['id']) ?>" data-id="<?= htmlspecialchars($row['id']) ?>"><i class="fa fa-eye"></i></a>
                          <a class="delete btnTrash" id="del_<?= htmlspecialchars($row['stockId']) ?>" data-id="<?= htmlspecialchars($row['stockId']) ?>"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                    <?php }
                    if (isset($_POST['btnViewStock'])) {

                      $stats = $_POST['cboViewStat'];
                      $catg = $_POST['cboViewCat'];
                      $query = "";

                      //checkbox function
                      if (isset($_POST['chckAll'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' ";
                          }
                        }
                        ####

                      } else if (isset($_POST['chckLow']) && isset($_POST['chcHigh']) && isset($_POST['chckOut'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' ";
                          }
                        }
                      }
                      ###
                      else if (isset($_POST['chckLow']) && isset($_POST['chcHigh'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE Qty  >'1'  ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg' AND Qty  >'1'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Qty  >'1'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' AND Qty  >'1'";
                          }
                        }
                      }
                      ###
                      else if (isset($_POST['chckOut']) && isset($_POST['chcHigh'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE Qty  > '3' OR  Qty < '1'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg' AND  Qty  >'3' OR  Qty < '1'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Qty < '1' OR Qty  > '3' ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' AND Qty  >'3' OR  Qty < '1'";
                          }
                        }
                      }
                      ###
                      else if (isset($_POST['chckOut']) && isset($_POST['chckLow'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE Qty  <='3' OR  Qty < '1'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg' AND  Qty  <='3' OR  Qty < '1'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Qty <='3'OR Qty  < '1' ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' AND Qty  <='3' OR  Qty < '1'";
                          }
                        }
                      } else if (isset($_POST['chckLow'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE Qty > '1' AND Qty <= '3'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg' AND Qty > '1' AND Qty <= '3'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Qty > '1' AND Qty <= '3' ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' AND Qty > '1' AND Qty <= '3'";
                          }
                        }
                      } else if (isset($_POST['chcHigh'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE Qty > '3'";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg' AND Qty > '3'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Qty > '3' ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' AND Category ='$catg' AND Qty > '3'";
                          }
                        }
                      } else if (isset($_POST['chckOut'])) {
                        //check status for query
                        if ($stats == "all") {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE Qty < '1' ";
                          } else {
                            $query = "SELECT * FROM viewstocks WHERE Category ='$catg' AND Qty < '1'";
                          }
                        } else {
                          if ($catg == "all") {
                            $query = "SELECT * FROM viewstocks WHERE status ='$stats' and  Qty < '1'";
                          } else {
                            $query = "SELECT * FROM viewstocks where status ='$stats' AND Category ='$catg' AND Qty < '1'";
                          }
                        }
                      } else {
                      }
                      if ($query != "") {
                        $catResult = mysqli_query($conn, $query);
                        echo "<script> $('tbody').children().remove() </script>";
                        while ($row = mysqli_fetch_array($catResult)) {
                          #Print all values
                          echo '
                          <tr>     
                          <td>' . htmlspecialchars($row['stockId']) . '</td>                       
                            <td>' . htmlspecialchars($row['Item_Name']) . '</td>
                            <td>' . htmlspecialchars($row['Serial_Number']) . '</td>
                            <td>' . htmlspecialchars($row['Property_Number']) . '</td>
                            <td>' . htmlspecialchars($row['MAC']) . '</td>                       
                            <td>' . htmlspecialchars($row['Date_Recieved']) . '</td>
                            <td>' . htmlspecialchars($row['total_Recieved']) . '</td>
                            <td>' . htmlspecialchars($row['Qty']) . '</td>
                            <td>' . htmlspecialchars($row['Unit']) . '</td>     
                            <td>' . htmlspecialchars($row['Par']) . '</td>                    
                            <td class="align-middle text-left"><a href="OR/' . htmlspecialchars($row['Filepath']) . '" class="btnDownload" style="text-decoration: none;" download>
                          <i class="fa fa-download" aria-hidden="true"></i></a></td>
                            <td class="d-flex text-left">
                              <a class="update btnUpdate" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                              <a class="view btnView" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-eye"></i></a>
                              <a class="delete btnTrash" id="del_' . htmlspecialchars($row['stockId']) . '" data-id="' . htmlspecialchars($row['stockId']) . '"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>';
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

  <!-- view stock modal -->
  <div class="modal fade" id="viewModal" style=" color: black">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <div class="container">
            <h4 class="modal-title">Equipment Information</h4>
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
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- add stock  modal-->
  <div class="modal fade" id="addStockModal" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <div class="container">
            <h5 class="modal-title">EQUIPMENT INFORMATION</h5>
          </div>
        </div>
        <div class="modal-body stockBody">
          <div class="container">
            <div class="row ">
              <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
            </div>
          </div>
          <div class="container-fluid mt-2">
            <form method="POST" id="stock-form">

              <div class="row ">
                <div class="col-md-4">
                  <label>Serial Number</label>
                  <input type="text" name="SerialNum" id="SerialNum" class="form-control shadow-sm" value="">
                </div>
                <div class="col-md-4">
                  <label>Property Number</label>
                  <input type="text" name="PropertyNum" id="PropertyNum" class="form-control shadow-sm" value="">
                </div>
                <div class="col-md-4">
                  <label>MAC Address </label>
                  <input type="text" name="MAC" id="MAC" class="form-control shadow-sm" value="">
                </div>
              </div> <br>
              <div class="row">

                <div class="col-md-12">
                  <label>Item Name</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="text" name="ItemName" id="ItemName" class="form-control shadow-sm" value="" required="required">
                </div>
              </div><br>
              <div class="row">

                <div class="col-md-12">
                  <label>Description</label>
                  <textarea class="form-control shadow-sm" id="Description" name="description" rows="5"></textarea>
                </div>
              </div><br>
              <div class="row">

                <div class="col-md-3">
                  <label>Quantity</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="Number" name="qty" id="qty" class="form-control shadow-sm" value="" required="required">
                </div>
                <div class="col-md-3">
                  <label>Qty Type</label><span class="text-danger  font-weight-bold"> *</span>
                  <select name="cboQtyType" id="cboQtyType" class="form-select shadow-sm" required="required">
                    <option value="" selected disabled>Select Here</option>
                    <option value="Special">Special</option>
                    <option value="Regular">Regular</option>
                  </select>

                </div>
                <div class="col-md-3">
                  <label>Date Received</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="date" name="dateRecieved" id="dateRecieved" class="form-control shadow-sm" value="" required="required">
                </div>

                <div class="col-md-3">
                  <label>Par/ICS Assignee</label>
                  <input type="text" name="par" id="par" class="form-control shadow-sm" value="">
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Category</label> <span class="text-danger  font-weight-bold"> *</span><br>
                    <select name="cboCategory" id="cboCategory" class="form-select shadow-sm" required="required">
                      <option value="" selected disabled>--Select Here--</option>
                      <?php
                      mysqli_data_seek($rs_result, 0); // Reset the result set 
                      // Loop through the result set and create an option for each category.
                      while ($row = mysqli_fetch_assoc($rs_result)) {
                        $category = $row['category'];
                        $catId = $row['id'];
                        echo "<option value='" . htmlspecialchars($category, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($catId, ENT_QUOTES) . "'>" . htmlspecialchars($category, ENT_QUOTES) . "</option>";
                      }
                      ?>
                    </select><input type="hidden" name="catId" id="catId" class="form-control shadow-sm" value="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Unit Type</label><span class="text-danger  font-weight-bold"> *</span><br>
                    <select name="cboUnit" id="cboUnit" class="form-select shadow-sm" required="required" placeholder="">
                      <option value="" selected disabled>--Select Here--</option>
                      <?php
                      //mysqli_data_seek($rs_result, 0); // Reset the result set 
                      // Loop through the result set and create an option for each category.
                      while ($row = mysqli_fetch_assoc($rs_result2)) {
                        $unit = $row['measurement'];
                        $unitId = $row['id'];
                        echo "<option value='" . htmlspecialchars($unitId, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($unitId, ENT_QUOTES) . "'>" . htmlspecialchars($unit, ENT_QUOTES) . "</option>";
                      }
                      ?>


                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Status</label><span class="text-danger font-weight-bold"> *</span><br>
                    <select name="cboStatus" id="cboStatus" class="form-select shadow-sm" required="required">
                      <option value="" selected disabled>--Select Here--</option>
                      <option value="Functional">Functional</option>
                      <option value="Defective">Defective</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Remarks</label>
                  <input type="text" name="Remarks" id="Remarks" class="form-control shadow-sm" value="">
                </div>
                <div class="col-md-6">
                  <label for="formFile" class="form-label">Original PAR/ICS Document</label>
                  <input class="form-control shadow-sm" id="stockUploadFile" type="file" name="stockUploadFile" accept="application/pdf" onchange="validateStockFile()">
                </div>
              </div><br>
              <div class="row mt-3">
                <div class="col-md-6">

                </div>
                <div class="col-md-3">
                  <button id="btnSubmitStock" class="btn  pt-2 btn-block shadow-sm" name="btnAdd" style="background-color:#388E3C; color: white">Add
                  </button>
                </div>
                <div class="col-md-3">
                  <button type="button" class="btn  pt-2 btn-block shadow-sm" id="closeButton" data-dismiss="modal" name="btnAdd" style="background-color:#0277BD; color: white">Close
                  </button>
                </div>
              </div>
              <div class="row mt-4">
                <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="stockAlert">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Update Modal-->
  <div class="modal fade" id="updateStockModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <div class="container">
            <div class="row">
              <div class="col-md-2">
                <h5 class="modal-title">UPDATE STOCK: </h5>
              </div>
              <div class="col-md-5">

              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row mb-3">
              <label class=" font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
            </div>
          </div>
          <div class="container-fluid mt-2">
            <form method="POST" id="updatestock-form">
              <div class="row ">
                <div class="col-md-4">
                  <label>Stock Number</label>
                  <input type="text" id="updateStockNum" class="form-control shadow-sm" value="" disabled>
                </div>
                <div class="col-md-4">
                  <label>Serial Number</label>
                  <input type="text" name="updateSerialNum" id="updateSerialNum" class="form-control shadow-sm" value="">
                </div>
                <div class="col-md-4">
                  <label>Property Number</label>
                  <input type="text" name="updatePropertyNum" id="updatePropertyNum" class="form-control shadow-sm" value="">
                </div>

              </div> <br>
              <div class="row">
                <div class="col-md-6">
                  <label>Item Name</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="text" name="updateItemName" id="updateItemName" class="form-control shadow-sm" value="" required="required">
                </div>
                <div class="col-md-6">
                  <label>MAC Address </label>
                  <input type="text" name="updateMAC" id="updateMAC" class="form-control shadow-sm" value="">
                </div>
              </div><br>
              <div class="row">

                <div class="col-md-12">
                  <label>Description</label>
                  <textarea class="form-control shadow-sm" id="updateDescription" name="updateDescription" rows="5"></textarea>
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-2">
                  <label>Total Received Item</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="Number" name="updateqty" id="updateqty" class="form-control shadow-sm" value="" required="required">
                </div>
                <div class="col-md-2">
                  <label>Total Availabe</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="Number" name="updateavqty" id="updateavqty" class="form-control shadow-sm" value="" required="required" disabled="">
                </div>
                <div class="col-md-2">
                  <label>Qty Type</label><span class="text-danger  font-weight-bold"> *</span>
                  <select name="updatecboQtyType" id="updatecboQtyType" class="form-select shadow-sm" required="required">
                    <option value="" selected disabled>Select Here</option>
                    <option value="Special">Special</option>
                    <option value="Regular">Regular</option>
                  </select>

                </div>
                <div class="col-md-3">
                  <label>Date Received</label><span class="text-danger  font-weight-bold"> *</span>
                  <input type="date" name="updatedateRecieved" id="updatedateRecieved" class="form-control shadow-sm" value="" required="required">
                </div>
                <div class="col-md-3">
                  <label>Par/ICS Assignee</label>
                  <input type="text" name="updatepar" id="updatepar" class="form-control shadow-sm" value="">
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Category</label><span class="text-danger  font-weight-bold"> *</span><br>
                    <select name="updatecboCategory" id="updatecboCategory" class="form-select shadow-sm" required="required">
                      <option value="" selected disabled>--Select Here--</option>
                      <?php
                      mysqli_data_seek($rs_result, 0); // Reset the result set
                      // Loop through the result set and create an option for each category.
                      while ($row = mysqli_fetch_assoc($rs_result)) {
                        $category = $row['category'];
                        $catId = $row['id'];
                        echo "<option value='" . htmlspecialchars($category, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($catId, ENT_QUOTES) . "'>" . htmlspecialchars($category, ENT_QUOTES) . "</option>";
                        $Arrcat[] = array('catId' => $catId, 'category' => $category);
                      }
                      ?>

                    </select><input type="hidden" name="updatecatId" id="updatecatId" class="form-control shadow-sm" value="">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Unit Type</label><span class="text-danger  font-weight-bold"> *</span><br>
                    <select name="updatecboUnit" id="updatecboUnit" class="form-select shadow-sm" required="required" placeholder="">
                      <option value="" selected disabled>--Select Here--</option>
                      <?php
                      mysqli_data_seek($rs_result2, 0); // Reset the result set 
                      // Loop through the result set and create an option for each category.
                      while ($row = mysqli_fetch_assoc($rs_result2)) {
                        $unit = $row['measurement'];
                        $unitId = $row['id'];
                        echo "<option value='" . htmlspecialchars($unit, ENT_QUOTES) . "' data-unit-id='" . htmlspecialchars($unitId, ENT_QUOTES) . "'>" . htmlspecialchars($unit, ENT_QUOTES) . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Status</label><span class="text-danger  font-weight-bold"> *</span><br>
                    <select name="updatecboStatus" id="updatecboStatus" class="form-select shadow-sm" required="required">
                      <option value="" selected disabled>--Select Here--</option>
                      <option value="Functional">Functional</option>
                      <option value="Defective">Defective</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Remarks</label>
                  <input type="text" name="updateRemarks" id="updateRemarks" class="form-control shadow-sm" value="">
                </div>
                <div class="col-md-6">
                  <label for="formFile" class="form-label">Original PAR/ICS Document

                  </label>
                  <input class="form-control shadow-sm" id="stockUpdateFile" type="file" name="stockUpdateFile" accept="application/pdf" onchange="validateStockUpdateFile()">
                  <label id="stockfilenameLabel" class="input-group-text" style="font-size: 13px;  color: black;"></label>
                </div>
              </div><br>
              <div class="row mt-3">
                <div class="col-md-6">
                </div>
                <div class="col-md-3">
                  <button id="btnUpdateStock" class="btn  pt-2 btn-block shadow-sm" name="btnUpdateStock" style="background-color:#388E3C; color: white">Update
                  </button>
                </div>
                <div class="col-md-3">
                  <button type="button" class="btn  pt-2 btn-block shadow-sm" data-dismiss="modal" id="closeButtonUpdate" name="btnAdd" style="background-color:#0277BD; color: white">Close
                  </button>
                </div>
              </div>
              <div class="row mt-4">
                <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="updatestockAlert">
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>


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

  <!-- add stock modal -->


</body>

</html>
<script>
  /*
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }*/
</script>