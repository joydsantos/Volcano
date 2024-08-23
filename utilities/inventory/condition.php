<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}

include '../../database/mydb.php';

$query = "SELECT * FROM tbl_inventory_condition";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Inventory Item Condition</title>
    <!-- Bootstrap core JavaScript-->
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
</head>
<style>
    .btnUpdate {
        background-color: #db8131;
        border: none;
        color: white;
        padding: 6px 13px;
        font-size: 16px;
        border-radius: 5px;
        margin-left: 7px;
        cursor: pointer;
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

    .btnUpdate:hover,
    .btnTrash:hover {
        color: #ffffff;
        background-color: #3d4a50;
    }

    tbody {
        background-color: white;
    }

    .btnAddCondition {
        background-color: transparent;
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
        color: #3d4a50;
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once '../../partial/sidebar.php' ?>

        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #f0f0f0">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->

                <!-- End of Topbar -->
                <?php include_once '../../partial/topbar.php' ?>
                <!-- Begin Page Content -->
                <!--Container Main start-->

                <div id="equipmentCategorySection" class="container mt-4 d-flex justify-content-center">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; width: 100%; padding-bottom: 3%; " id="CatSection">
                        <div class="card-header " style="background-color: white;">
                            <div class="row mt-3 mx-auto text-center">
                                <h4 class="paragraph" style="color: black"> Inventory Item Condition</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="d-flex  justify-content-end mb-2">
                                    <button class="btnAddCondition" data-toggle="modal" data-target="#form-modal"><i class="fas fa-plus fa-2x addIcon"></i></button>
                                </div>
                                <table id="item-condition-table" class="table w-100 table-sm table-hover dataTable no-footer" style=" color: black; font-size: 15px;">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th width="50">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr id="<?= $row['id'] ?>">
                                                <td><?= $row['condition'] ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="button" class="btnUpdate" onclick="editItem(<?= $row['id']; ?>,'<?= $row['condition']; ?>')">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="button" class="btnTrash" onclick="deleteItem(<?= $row['id'] ?>)">
                                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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


    <div class="modal" id="form-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form onsubmit="save(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Condition</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" autocomplete='off'>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input name="name" type="text" class="form-control shadow-sm" autocomplete='off'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <button type="submit" class="btn  pt-2 btn-block shadow-sm" name="btnUpdateStock" style="background-color:#388E3C; color: white">Save</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn pt-2 btn-block shadow-sm" data-dismiss="modal" data-bs-dismiss="modal" style="background-color:#0277BD; color: white">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="js/condition.js"></script>

</body>

</html>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>