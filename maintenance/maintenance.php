<?php
include '../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}

#$unit_result = mysqli_query($conn, "SELECT * FROM `tbl_unit_measurement`");
#$condition_result = mysqli_query($conn, "SELECT * FROM `tbl_inventory_condition`");
//$stations_result = mysqli_query($conn, "SELECT * FROM `tbl_station`");
#$user_result = mysqli_query($conn, "SELECT * FROM `tbl_par`");

#$users = $user_result->fetch_all(MYSQLI_ASSOC);

$types_query = mysqli_query($conn, "SELECT * from tbl_inventory_types");
$all_types = $types_query->fetch_all(MYSQLI_ASSOC)
?>
<!DOCTYPE html>
<html lang="en">
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Custom styles for this template-->
<link href="../css/sb-admin-2.css" rel="stylesheet">
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

<head>
    <title>Inventory</title>
</head>
<style type="text/css">
    .pagination a {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        margin: 0 2px;

    }


    .btnNew {
        background-color: transparent;
        border: none;
        color: white;
        padding: 8px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-left: 7px;
        cursor: pointer;
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

    .btnView {
        background-color: #017469;
        border: none;
        color: white;
        padding: 8px 13px;
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

    .addIcon {

        color: #017469;
    }

    .addIcon:hover {
        color: #3D4A50;
    }


    .btnView:hover,
    .btnTrash:hover,
    .btnUpdate:hover {
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


    body {
        background-color: #9ef0ff;
    }

    tbody {

        background-color: white;
    }

    .inventoryTableID1 th:nth-child(5) {
        display: none;
    }

    .inventoryTableID1 td:nth-child(5) {
        display: none;
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include_once '../partial/sidebar.php' ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include_once '../partial/topbar.php' ?>
                <!--Container Main start-->
                <div class="container-fluid">
                    <div class="card rounded-2 shadow-lg" style="background-color: #FFFFFF; border: none;">
                        <div class="card-header" style="background-color: #FFFFFF">
                            <!-- Filter -->
                            <form id="filter" method="POST">
                                <div class=" row align-items-center gutter-2">


                                    <div class="col-md-3 align-self-center">
                                        <select name="station" class="form-select" onchange="filter.submit()">
                                            <option value="" selected disabled>--Select Station--</option>
                                            <option value="">All</option>
                                            <?php
                                            $selectedStation =   isset($_POST['station']) ? $_POST['station'] : null;
                                            $result = mysqli_query($conn, "SELECT *  FROM `tbl_station`");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['id'] . '" ' . ($row['id'] == $selectedStation ? 'selected' : '') . ' >' . $row['Station'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md d-flex gap-2 align-items-center justify-content-end">
                                        <button type="button" class="btnNew" data-toggle="modal" data-target="#inventory-add-modal">
                                            <i class="fas fa-plus fa-2x addIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body ">
                            <?php include 'loadTable.php'; ?>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php include_once '../partial/footer.php' ?>
            <!-- End of Footer -->
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <?php include_once 'partials/add_modal.php' ?>
        <?php include_once 'partials/update_modal.php' ?>
        <?php include_once 'partials/view_modal.php' ?>
        <?php include_once 'partials/delete_modal.php' ?>
        <script type="text/javascript" src="js/maintenance.js"></script>
</body>

</html>