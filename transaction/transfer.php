<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}
unset($_SESSION['update_transaction_id']);
include '../database/mydb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transfer History</title>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>


    <script src="js/transfer.js"></script>

</head>
<style type="text/css">
    .pagination a {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        margin: 0 2px;

    }

    .btnUpdate {
        background-color: #508853;
        border: none;
        color: white;
        padding: 6px 11px;
        font-size: 17px;
        border-radius: 5px;
        margin-left: 7px;
        cursor: pointer;

    }

    .btnView {
        background-color: #1E88E5;
        border: none;
        color: white;
        padding: 6px 11px;
        font-size: 17px;
        border-radius: 5px;
        margin-left: 0px;
        cursor: pointer;
    }

    .btnTrash {
        background-color: #963011;
        border: none;
        color: white;
        padding: 6px 11px;
        font-size: 17px;
        border-radius: 5px;
        margin-left: 0px;
        cursor: pointer;
    }


    .btnNew {
        background-color: #006064;
        border: none;
        color: white;
        padding: 8px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-left: 7px;
        cursor: pointer;
    }

    .btnNew:hover {
        color: white;
        background-color: #3D4A50;
    }

    .btnUpdate:hover,
    .btnView:hover,
    .btnTrash:hover {
        color: white;
        background-color: #3D4A50;
    }



    body {
        background-color: #9ef0ff;
    }

    tbody {

        background-color: white;
    }
</style>
<?php
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
        <?php include_once '../partial/sidebar.php' ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once '../partial/topbar.php' ?>
                <!-- End of Topbar -->
                <!--Container Main start-->
                <div class="container-fluid">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; border: none;">
                        <div class="card-header" style="background-color:#F5F5F5">

                            <div class="row">
                                <div class="col-md-8">
                                    <h4 style="font-weight:bold">EQUIPMENT TRANSFER HISTORY</h4>
                                    <h4 class="transTitle" id="transTitle"></h4>


                                </div>

                                <div class="col-md-4 mt-4">
                                    <input type="button" name="btnAddTransferHistory" class="btnNew float-end" id="btnAddTransferHistory" value="Record a Transfer">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive  mt-2">
                                <table class="table table-sm  table-striped oldtranTransferHistory-table " id="oldtranTransferHistoryDataTable" style=" color: black; font-size: 17px; ">
                                    <thead class="table-dark" style="font-size: 18px;">
                                        <tr>
                                            <th>Transferred From</th>
                                            <th>Transferred To</th>
                                            <th>Date Transferred</th>
                                            <th>Station Name</th>
                                            <th>Division</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
            <?php include_once '../partial/footer.php' ?>
        </div>

        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- history --->
        <?php include_once 'crud_modals/view_transfer.php' ?>
        <?php include_once 'crud_modals/add_transfer_record.php' ?>
        <?php include_once 'crud_modals/update_transfer_record.php' ?>
        <!-- division -->



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