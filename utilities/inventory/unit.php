<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}

include '../../database/mydb.php';

$query = "SELECT * FROM tbl_unit_measurement";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include_once '../../partials/header.php' ?>

    <title>Inventory Item Unit</title>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include_once '../../partials/sidebar.php' ?>

        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #f0f0f0">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->

                <!-- End of Topbar -->
                <?php include_once '../../partials/topbar.php' ?>
                <!-- Begin Page Content -->
                <!--Container Main start-->

                <div id="equipmentCategorySection" class="container mt-4 d-flex justify-content-center">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; width: 100%; padding-bottom: 3%; " id="CatSection">
                        <div class="card-header " style="background-color: white;">
                            <div class="row mt-3 mx-auto text-center">
                                <h4 class="paragraph" style="color: black"> Inventory Item Unit</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="d-flex  justify-content-end mb-2">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#form-modal">Add</button>
                                </div>
                                <table id="item-measurement-table" class="table w-100 table-sm table-hover dataTable no-footer">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Measurement</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr id="<?= $row['id'] ?>">
                                                <td><?= $row['measurement'] ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="button" class="btn btn-warning btn-sm" onclick="editItem(<?= $row['id']; ?>,'<?= $row['measurement']; ?>')">
                                                            <span class="fas fa-pencil-square-o" aria-hidden="true"></span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(<?= $row['id'] ?>)">
                                                            <span class="fas fa-trash" aria-hidden="true"></span>
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
            <?php include_once '../../partials/footer.php' ?>

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
                        <h5 class="modal-title">Add Measurement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" autocomplete='off'>
                        <div class="form-group">
                            <label for="name">Measurement</label>
                            <input name="measurement" type="text" class="form-control" autocomplete='off'>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include_once '../../partials/scripts.php' ?>

    <script src="./js/unit.js"></script>

</body>

</html>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>