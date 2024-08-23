<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Deployed Equipment</title>
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
    <script src="../../vendor/sweetalert/sweetalert.min.js"></script>
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
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include_once '../../partial/sidebar.php' ?>
        <!-- Divider -->
        </ul>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once '../../partial/topbar.php' ?>
                <!-- End of Topbar -->
                <!--Container Main start -->

                <div class="container-fluid">
                    <div class="card rounded-2 shadow-lg" style="background-color: #FFFFFF; border: none;">
                        <div class="card-header" style="background-color: #FFFFFF">
                            <form id="filter" method="POST">
                                <div class="row justify-content-between" style="margin-bottom:-7px;">
                                    <div class="col-md-3 mt-2">
                                        <div class="form-group">
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
                                    </div>
                                    <div class="col-md-8 mt-2 ">
                                        <button type="button" class="btnNew float-end" data-toggle="modal" data-target="#addModal">
                                            <i class="fas fa-plus fa-2x addIcon"></i>
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive  mt-2">
                                <?php include_once "partials/table.php" ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.container-fluid -->
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
        <?php include_once "partials/add_modal.php" ?>
        <!-- update -->
        <?php include_once "partials/update_modal.php" ?>
        <!-- delete -->
        <?php include_once "partials/delete_modal.php" ?>
        <!-- view modal -->
        <?php include_once "partials/view_modal.php" ?>


        <script type="text/javascript" src="js/deployed-equipment.js"></script>

        <template id="instrumentInput">
            <div class="d-flex align-items-center gap-2">
                <textarea rows="2" class="form-control input" name="instruments[]"></textarea>
                <button type="button" onclick="deleteItem(event)" class="btn btn-sm btn-danger"><i class="fas fa-trash pointer-events-none"></i></button>
                <button type="button" onclick="addItem()" class="btn btn-sm btn-primary"><i class="fas fa-plus pointer-events-none"></i></button>
            </div>
        </template>
</body>

</html>