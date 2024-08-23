<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}
include '../database/mydb.php';
$query = "SELECT category FROM tbl_equipmentcategory";
$rs_result = mysqli_query($conn, $query);

$query1 = "SELECT * FROM tbl_unit_measurement";
$rs_result1 = mysqli_query($conn, $query1);



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Equipment Categories</title>


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="breadcrumb.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
    <script src="js/unit.js"></script>
    <script src="js/equipmentCat.js"></script>
</head>
<style type="text/css">
    label {
        color: black;
    }

    .border-red {
        border: 1px solid red;
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include_once '../partial/sidebar.php' ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #f0f0f0">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once '../partial/topbar.php' ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <!--Container Main start-->
                <div class="container d-flex justify-content-center">
                    <ul class="pagination shadow-lg">
                        <li class="page-item active"> <a class="page-link" href="javascript:void(0);" onclick="hideshow('CatSection');">

                                <small class="s">Equipment Category</small>
                            </a>
                        </li>
                        <li class="page-item" id="unitMeasurementPage">
                            <a class="page-link" href="javascript:void(0);" onclick="hideshow('UnitSection');">
                                <small class="s">Unit Measurement</small>
                            </a>
                        </li>
                    </ul>
                </div>

                <div id="equipmentCategorySection" class="container mt-4 d-flex justify-content-center">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; width: 100%; padding-bottom: 3%; " id="CatSection">
                        <div class="card-header " style="background-color: white;">
                            <div class="row mt-3 mx-auto text-center">
                                <h4 class="paragraph" style="color: black"> Equipment Category</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" id="cat-form">
                                <div class="row justify-content-center">
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label>Select Category</label><br>
                                            <select name="cboCategory" id="selectCategory" class="form-select shadow-sm" required="required" style="color: black;" onchange="myFunction()">
                                                <option value="" selected disabled>--Select Here--</option>
                                                <?php
                                                // Loop through the result set and create an option for each category.
                                                while ($row = mysqli_fetch_assoc($rs_result)) {
                                                    $category = $row['category'];
                                                    $selected = isset($_POST['Category']) && $_POST['Category'] === $category ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($category, ENT_QUOTES) . "' $selected>$category</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <label>Category</label>
                                        <input type="text" name="category" id="category" required="required" class="form-control shadow-sm" style="color: black;" value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category'], ENT_QUOTES) : ''; ?>">
                                    </div>

                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a class="update" href="#" style="text-decoration: none;">
                                                <button class="btn  pt-2 btn-block shadow-sm" name="btnUpdate" style="background-color: #1F5F54; color: white;">Update
                                                    Category</button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a class="delete" href="#" style="text-decoration: none;">
                                                <button class="btn  pt-2 btn-block shadow-sm" name="btnDelete" style="background-color:#360909; color: white;">Delete
                                                    Category</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form method="post">
                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-7">
                                        <label> New Equipment Category</label>
                                        <input type="text" name="txtCat" id="txtCat" class="form-control shadow-sm" style="color: black;" required="required">
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <a class="add" href="#" style="text-decoration: none;">
                                                <button class="btn  pt-2 btn-block shadow-sm" name="btnAdd" style="background-color:#0B5694; color: white;">Add
                                                    Category</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <!-- unit measurement  -->
                <div class="container mt-0 d-flex justify-content-center" id="unitMeasurementSection">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; width: 100%; padding-bottom: 3%; display: none; " id="UnitSection">

                        <div class="card-header " style="background-color: white;">
                            <div class=" row mt-3 mx-auto text-center">
                                <h4 class="paragraph" style="color: black"> Unit Measurement</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" id="update-unit-form">
                                <div class="row justify-content-center">
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label>Select Unit</label><br>
                                            <select name="cboUnit" id="cboUnit" class="form-select shadow-sm" required="required" style="color: black;" onchange="unitFunction()">
                                                <option value="" selected disabled>--Select Here--</option>
                                                <?php
                                                // Loop through the result set and create an option for each unit.
                                                while ($row = mysqli_fetch_assoc($rs_result1)) {
                                                    $unit = $row['measurement'];
                                                    $selected = isset($_POST['cboUnit']) && $_POST['cboUnit'] === $unit ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "' $selected>$unit</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-7">
                                        <label>Category</label>
                                        <input type="text" name="txtUpdateUnit" id="txtUpdateUnit" required="required" class="form-control shadow-sm" style="color: black;" value="<?php echo isset($_POST['txtUpdateUnit']) ? htmlspecialchars($_POST['txtUpdateUnit'], ENT_QUOTES) : ''; ?>">
                                    </div>

                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a class="updateUnit" href="#" style="text-decoration: none;">
                                                <button class="btn  pt-2 btn-block shadow-sm" name="btnUpdate" style="background-color: #1F5F54; color: white;">Update
                                                    Unit</button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <a class="deleteUnit" href="#" style="text-decoration: none;">
                                                <button class="btn  pt-2 btn-block shadow-sm" name="btnDelete" style="background-color:#360909; color: white;">Delete
                                                    Category</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form method="post" id="new-unit-form">
                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-7">
                                        <label> New Unit</label>
                                        <input type="text" name="txtNewUnit" id="txtNewUnit" class="form-control shadow-sm" style="color: black;" required="required">
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <a class="addUnit" href="#" style="text-decoration: none;">
                                                <button class="btn  pt-2 btn-block shadow-sm" name="btnAddUnit" style="background-color:#0B5694; color: white;">Add
                                                    Unit </button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
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