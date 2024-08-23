<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
unset($_SESSION['update_transaction_id']);
include '../../database/mydb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transaction</title>
    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet" />
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>

    <script src="js/newrecord.js"></script>
    <script src="../division_modals/division.js"></script>
    <script src="js/update.js"></script>
    <script src="js/table.js"></script>
    <script src="js/archive.js"></script>
</head>


<style type="text/css">
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
        padding: 10px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-left: 7px;
        cursor: pointer;
    }

    .btnBack {
        background-color: #262626;
        text-decoration: none;
        border: none;
        color: white;
        padding: 8px 15px;
        font-size: 16px;
        border-radius: 7px;
        text-decoration: none;
        cursor: pointer;
    }

    .btnNew {
        background-color: transparent;
        border: none;
        color: white;
        padding: 8px 13px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btnView {
        background-color: #017469;
        border: none;
        color: white;
        padding: 8px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-left: 17px;
        cursor: pointer;
    }

    .btnDivision {
        background-color: #017469;
        border: none;
        color: white;
        padding: 8px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-right: 2%;
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

    a.btnUpdate:hover,
    a.btnView:hover,
    a.btnTrash:hover,
    a.btnTransfer:hover,
    a.btnDownload:hover,
    .btnDivision:hover,
    .btnView:hover {
        color: white;
        background-color: #3D4A50;
    }

    .btnDivision:hover .btnView:hover {
        color: white;
        background-color: #3D4A50;
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

    .btnTransfer {
        background-color: #0D3C65;
        border: none;
        color: white;
        padding: 6px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-left: 7px;
        cursor: pointer;
    }

    .addIcon {

        color: #017469;
    }

    .addIcon:hover {
        color: #3D4A50;
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

    .oldtran-table th:nth-child(1),

    th:nth-child(13),
    th:nth-child(4),
    th:nth-child(10) {
        display: none;
    }

    .oldtran-table td:nth-child(1),

    td:nth-child(13),
    td:nth-child(4),
    td:nth-child(10) {
        display: none;
    }
</style>

<?php

$queryView = "";
$queryView = "SELECT *
FROM viewoldtransaction
WHERE record_status != 'Archived'
AND Date_Acquired != '0000-00-00'
ORDER BY Date_Acquired DESC;
";
$rs_result1 = mysqli_query($conn, $queryView);

$select1 = "SELECT * FROM tbl_station";
$result1 = mysqli_query($conn, $select1);
$select2 = "SELECT * FROM tbl_station_code";
$result2 = mysqli_query($conn, $select2);

$select3 = "SELECT * FROM tbl_Division";
$result3 = mysqli_query($conn, $select3);
?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- End of Sidebar -->
        <?php include_once '../../partial/sidebar.php' ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once '../../partial/topbar.php' ?>
                <!-- End of Topbar -->
                <!--Container Main start-->
                <div class="container-fluid">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; border: none;">
                        <div class="card-header" style="background-color:#F5F5F5">
                            <form method="POST">
                                <div class="row" style="margin-bottom:-7px;">
                                    <div class="col-md-2 mt-2">
                                        <div class="form-group">
                                            <select name="cbosearchStation" id="cbosearchStation" class=" form-select" required>
                                                <option value="" selected disabled>Station</option>
                                                <option value="All" <?php echo (isset($_POST['cbosearchStation']) && $_POST['cbosearchStation'] == 'All' ? 'selected' : ''); ?>>
                                                    All Station</option>
                                                <?php
                                                # Loop through the result 
                                                mysqli_data_seek($result1, 0);
                                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                                    $station = $row1['Station'];
                                                    $staId = $row1['id'];
                                                    $selected = (isset($_POST['cbosearchStation']) && $_POST['cbosearchStation'] == $station) ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($staId, ENT_QUOTES) . "' $selected>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="searchstationId" id="searchstationId" class="form-control shadow-sm" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-2">
                                        <div class="form-group">
                                            <select name="cbosearchStationCode" id="cbosearchStationCode" class="form-select" required>
                                                <option value="" selected disabled>Code</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <div class="form-group">
                                            <select name="cbosearchEquipStatus" id="cbosearchEquipStatus" class="form-select" required>
                                                <option value="" selected disabled>Status</option>
                                                <?php
                                                $equipStatusOptions = array("All", "Damage", "Missing", "Ongoing Repair", "Serviceable", "Pulled Out", "For Disposal", "Unrepairable", "Others");
                                                foreach ($equipStatusOptions as $status) {
                                                    $selectedStatus = (isset($_POST['cbosearchEquipStatus']) && $_POST['cbosearchEquipStatus'] == $status) ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($status, ENT_QUOTES) . "' $selectedStatus>" . htmlspecialchars($status, ENT_QUOTES) . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <input type="date" id="dateFrom" name="dateFrom" class="form-control" value="<?php echo isset($_POST['dateFrom']) ? $_POST['dateFrom'] : ''; ?>">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <input type="date" id="dateTo" name="dateTo" class="form-control" value="<?php echo isset($_POST['dateTo']) ? $_POST['dateTo'] : ''; ?>">
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <input type="checkbox" id="allDate" name="allDate" <?php echo isset($_POST['allDate']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="allDate"> All Date </label>
                                        <input type="submit" name="btnSearchRecord" class="btnView btn" id="btnSearchRecord" value="Search">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mt-4">
                                        <button name="btnNew" type="button" class="btnNew" id="btnNew"><i class="fas fa-plus fa-2x addIcon"></i></button>
                                    </div>
                                    <div class="col-md-10 mt-4">
                                        <input type="button" name="btnDivision" class="btnDivision float-end" id="btnDivision" value="Manage Division / Section Head">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive  mt-2">
                                <table class="table table-sm table-hover oldtran-table" id="oldtrandatatable" style=" color: black; font-size: 15px;">
                                    <thead class="table-dark" style="  font-size: 16px;">
                                        <tr>
                                            <th>Transaction Number</th>
                                            <th>Item Name</th>
                                            <th class="serial-number">Serial Number</th>
                                            <th>Property</th>
                                            <th>Quantity</th>
                                            <th>Transferred From</th>
                                            <th>Transferred to</th>
                                            <th>Date Acquired</th>
                                            <th> Installed At</th>
                                            <th>Status</th>
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
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Item_Name']) . '</td>
                                            <td class="align-middle text-left serial-number">' . htmlspecialchars($row['Serial_Number']) . '</td>
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Property_Number']) . '</td>
                                            <td class="align-middle text-left"> ' . htmlspecialchars($row['qty']) . '</td>
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Transferred_From']) . '</td>
                                            <td class="alig n-middle text-left">' . htmlspecialchars($row['Transferred_To']) . '</td>
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Date_Acquired']) . '</td>
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Station']) . '</td>
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Status']) . '</td>
                                            <td class="align-middle text-left"><a href="OR/' . htmlspecialchars($row['Filepath']) . '" class="btnDownload" style="text-decoration: none;" download>
                                            <i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                <td class="d-flex text-left">
                                                <a class="update btnUpdate" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a class="view btnView" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-eye"></i></a>
                                                <a class="delete btnTrash" id="del_' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-trash"></i></a>
                                                <a class="transfer btnTransfer" id="trans_' . htmlspecialchars($row['Transaction_Number']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-exchange"></i></a>
                                                </td>
                                            <td class="align-middle text-left">' . htmlspecialchars($row['Station_Code']) . '</td>
                                        </tr>';
                                        }
                                        if (isset($_POST['btnSearchRecord'])) {
                                            $dateFrom = isset($_POST['dateFrom']) ? $_POST['dateFrom'] : null;
                                            $dateTo = isset($_POST['dateTo']) ? $_POST['dateTo'] : null;
                                            $s_Station = $_POST['cbosearchStation'];
                                            $s_Code = $_POST['cbosearchStationCode'];
                                            $s_Status = $_POST['cbosearchEquipStatus'];
                                            $query = "";

                                            #check if what date ang iquery
                                            if (isset($_POST['allDate'])) {
                                                #Checkbox is checked
                                                if ($s_Station == "All" && $s_Code == "All Code" && $s_Status == "All") {

                                                    $query = "SELECT * FROM viewoldtransaction";
                                                } else if ($s_Station == "All" && $s_Code == "All Code" && $s_Status != "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Status = '$s_Status'";
                                                } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status == "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station'";
                                                } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status != "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Status='$s_Status'";
                                                } else if ($s_Station != "All" && $s_Code != "All Code" && $s_Status == "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code'";
                                                } else {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code' AND Status='$s_Status'";
                                                }
                                            } else {

                                                if ($s_Station == "All" && $s_Code == "All Code" && $s_Status == "All") {

                                                    $query = "SELECT * FROM viewoldtransaction WHERE Date_Acquired BETWEEN COALESCE('$_POST[dateFrom]', '0000-00-00') AND COALESCE('$_POST[dateTo]', '9999-12-31') ";
                                                } else if ($s_Station == "All" && $s_Code == "All Code" && $s_Status != "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Status = '$s_Status' AND Date_Acquired BETWEEN COALESCE('$_POST[dateFrom]', '0000-00-00') AND COALESCE('$_POST[dateTo]', '9999-12-31')";
                                                } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status == "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Date_Acquired BETWEEN COALESCE('$_POST[dateFrom]', '0000-00-00') AND COALESCE('$_POST[dateTo]', '9999-12-31')";
                                                } else if ($s_Station != "All" && $s_Code == "All Code" && $s_Status != "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Status='$s_Status' AND Date_Acquired BETWEEN COALESCE('$_POST[dateFrom]', '0000-00-00') AND COALESCE('$_POST[dateTo]', '9999-12-31')";
                                                } else if ($s_Station != "All" && $s_Code != "All Code" && $s_Status == "All") {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code' AND Date_Acquired BETWEEN COALESCE('$_POST[dateFrom]', '0000-00-00') AND COALESCE('$_POST[dateTo]', '9999-12-31')";
                                                } else {
                                                    $query = "SELECT * FROM viewoldtransaction WHERE Station= '$s_Station' AND Station_Code ='$s_Code' AND Status='$s_Status' AND Date_Acquired BETWEEN COALESCE('$_POST[dateFrom]', '0000-00-00') AND COALESCE('$_POST[dateTo]', '9999-12-31')";
                                                }
                                            }
                                            if ($query != " ") {
                                                $searchResult = mysqli_query($conn, $query);
                                                echo "<script> $('tbody').children().remove() </script>";
                                                while ($row = mysqli_fetch_array($searchResult)) {
                                                    #Print all values
                                                    echo '
                                                    <tr>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Transaction_Number']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Item_Name']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Serial_Number']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Property_Number']) . '</td>
                                                        <td class="align-middle text-left"> ' . htmlspecialchars($row['qty']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Transferred_From']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Transferred_To']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Date_Acquired']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Station']) . '</td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Status']) . '</td>
                                                        <td class="align-middle text-left"><a href="OR/' . htmlspecialchars($row['Filepath']) . '" class="btnDownload" style="text-decoration: none;" download>
                                                        <i class="fa fa-download" aria-hidden="true"></i></a></td>
                                                        <td class="d-flex text-left">
                                                            <a class="update btnUpdate" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                            <a class="view btnView" id="' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-eye"></i></a>
                                                            <a class="delete btnTrash" id="del_' . htmlspecialchars($row['id']) . '" data-id="' . htmlspecialchars($row['id']) . '"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td class="align-middle text-left">' . htmlspecialchars($row['Station_Code']) . '</td>
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
            <?php include_once '../../partial/footer.php' ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- division -->
    <?php include_once '../division_modals/division.php'
    ?>
    <!-- View modal -->
    <?php include_once 'crud_modals/view.php' ?>
    <!--add modal -->
    <?php include_once 'crud_modals/add.php' ?>
    <!-- update modal -->
    <?php include_once 'crud_modals/update.php' ?>
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
<script type="text/javascript"></script>