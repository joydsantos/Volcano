<?php
session_start();
include '../../database/mydb.php';
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}

$sql = "SELECT * FROM tbl_networkmap_image";
$images = $conn->query($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Network Map</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../css/sb-admin-2.css" rel="stylesheet">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet">

</head>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500');
</style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include_once '../../partial/sidebar.php' ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- End of Sidebar -->
            <!-- Content Wrapper -->
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once '../../partial/topbar.php' ?>
                <!-- End of Topbar -->
                <div class="container-fluid mt-3">
                    <div class="card rounded-2 shadow-lg" style="background-color: white; ">
                        <div class="card-header " style="background-color: white;">
                            <div class="row mt-3 mx-auto text-center">
                                <div class="col-md-12">
                                    <h4 class="paragraph " style="color: black"> Network Map</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-image-upload" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Image Caption</strong>
                                        <input type="text" name="caption" class="form-control mt-2" placeholder="Insert Caption" required id="txt_map" style=" box-shadow: none;">
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Image:</strong>
                                        <input type="file" name="image" id="mapInput" class="form-control mt-2" accept="image/*" required onchange="validateMap()" style=" box-shadow: none;">
                                    </div>
                                    <div class=" col-md-2">
                                        <br />
                                        <button type="submit" class="btn btn-upload mt-2">Upload</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row ">
                                <div class='list-group gallery' style="width:100%;">
                                    <?php
                                    while ($image = $images->fetch_assoc()) {
                                    ?>
                                        <div class='col-md-3' style="float: left;">
                                            <a class="thumbnail" rel="ligthbox" href="uploads/<?php echo htmlspecialchars($image['name']) ?>">

                                                <img alt="" src="uploads/<?php echo htmlspecialchars($image['name']) ?>" class="img-fluid map-img" />

                                                <div class='text-center'>
                                                    <p class='mt-2 desc'>
                                                        <?php echo htmlspecialchars($image['caption']) ?>
                                                    </p>
                                                </div>
                                            </a>
                                            <form method="POST" class="delete-map">
                                                <input id="map-id" type="hidden" data-id="<?php echo htmlspecialchars($image['name']) ?>" value="<?php echo htmlspecialchars($image['id']) ?>">
                                                <button type="submit" class="close-icon btn btn-danger" id="map-delete">
                                                    <i class="fa fa-times fa-xs" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php } ?>

                                </div> <!-- list-group / end -->
                            </div> <!-- row / end -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include_once '../../partial/footer.php' ?>
            <!-- End of Footer -->
            <!-- End of Content Wrapper -->
        </div>
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
                    <a class="btn btn-primary" href="../../logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>



</body>

</html>