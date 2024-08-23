<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}

include '../../database/mydb.php';


$sql = "SELECT * FROM tbl_admin";
$stmt = mysqli_prepare($conn, $sql);

#Check if the statement was prepared successfully
if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
}
// Close the database connection when done
mysqli_close($conn);




?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User</title>


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
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet">
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css
" rel="stylesheet">

    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
    <script src="js/ajax.js"></script>

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
        <?php include_once '../../partial/sidebar.php' ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #f0f0f0">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once '../../partial/topbar.php' ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <!--Container Main start-->
                <div class="container-fluid">
                    <div class="card shadow-lg  p-2  rounded-2" style="background-color: #FFFFFF; border: none;">
                        <div class="card-header rounded-2" style="background-color: #FFFFFF">
                            <div class="row">
                                <div class="col-md-12">
                                    <a class='btnNew'><i class='fas  fa-user-plus'></i> Add User</a>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive  mt-2">
                                <table class="table table-hover align-middle " id="datatableid" style=" color: black; font-size: 16px; ">
                                    <thead class="table-dark" style="font-size: 14px;  ">
                                        <tr>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Action</th>

                                            <th style="width: 5%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                            if ($row['username'] != "developer_admin_me") {
                                                echo "
                                                <tr>
                                                    <td class='align-middle text-left'>" . htmlspecialchars($row['First_Name'] . " " . $row['Last_Name'], ENT_QUOTES, 'UTF-8') . "</td>
                                                    <td class='align-middle text-left'>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</td>
                                                    <td class='align-middle text-left'>" . htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') . "</td>
                                                    <td class='d-flex '>
                                                        <button class='btn btn-update' data-toggle='modal' data-target='#updateModal' data-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>
                                                            <i class='fas fa-cog' aria-hidden='true'></i>
                                                        </button>

                                                        <button style='margin-left: 5px;' class='btn btn-primary btn-password' data-toggle='modal' data-target='#updatePassModal' data-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>
                                                            <i class='fas fa-key' aria-hidden='true'></i>
                                                        </button>
                                                    </td>        
                                                </tr>
                                            ";
                                            }
                                        }
                                        /*
                                             <a class='btnUpdate' href='update.php?id=" . htmlspecialchars($row['tutor_id']) . "'><i class='fa-solid fa-pen-to-square' aria-hidden='true'></i></a>           
                                        */
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
    <div class="modal fade" id="addModal" style=" color: black">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header  for adding tutor-->
                <div class="modal-header">
                    <div class="row">
                        <h4 class="modal-title ">
                            <div class="col-md-12">
                                Add User
                            </div>
                        </h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body mt-2 ">
                    <div class="container-fluid ">
                        <form method="POST" id="add-admin-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="txtFName" id="lblfname">First Name</label>
                                    <input type="text" name="txtFName" id="txtFName" class="form-control mt-1  " required="required" placeholder="required">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="txtLName" id="lbllname">Last Name</label>
                                    <input type="text" name="txtLName" id="txtLName" class="form-control mt-1 " required="required" placeholder="required">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="txtUName" id="lblUName">Username</label>
                                    <input type="text" name="txtUName" id="txtUName" class="form-control mt-1  " required="required" placeholder="minimum of 6 characters">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="txtPass" id="lblPass">Password</label>
                                    <input type="text" name="txtPass" id="txtPass" class="form-control mt-1 " required="required" placeholder="minimum of 8 characters">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <!--<button type="button" class="btn btnclosetutormodal btn-secondary float-left " data-dismiss="modal">Close</button>-->
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btnAdmin float-right" id="adminButton" name="btnAddTutor">Add User</button>
                                </div>
                            </div>
                            <div class="row mt-0">
                                <div class="col-md-12">
                                    <div class="alert alert-danger p-3  bg-body-tertiary rounded-2 mt-3" role="alert" style="text-align: center;" id="showAlert">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="setPasswordModal" style=" color: black ">
        <div class="modal-dialog modal-dialog-centered modal-md ">
            <div class="modal-content ">
                <!-- Modal Header  for adding amin-->
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left: 23px;">Update Password</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container-fluid ">
                        <form method="POST" id="update-admin-form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="text" id="txtuserPassId" hidden>
                                        <div class="col-md-12">
                                            <label> New Password</label>
                                            <input type="text" placeholder="minimum of 8 characters" id="updatePassword" name="password" class="form-control shadow-sm">
                                        </div>
                                    </div>


                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <button class="btnUpdateAccountPassword float-right" id="btnUpdateAccountPassword" name="btnUpdateAccountPassword">Update
                                                Password</button>
                                        </div>
                                    </div>
                                    <div class="row mt-0">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger p-3  bg-body-tertiary rounded-2 mt-3" role="alert" style="text-align: center;" id="showUpdateAlert">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="setActionModal" style=" color: black ">
        <div class="modal-dialog modal-dialog-centered modal-md ">
            <div class="modal-content ">
                <!-- Modal Header  for adding tutor-->
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left: 23px;">Update User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container-fluid ">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><span id="statusPlaceholder"></span></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="text" id="txtuserId" hidden>
                                        <div class="col-md-4">
                                            <label for="selectAction" id="lblAction">Select Action:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" name="action" id="normalAction" value="Active">
                                            <label for="normalAction">Active</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="radio" name="action" id="suspendAction" value="Inactive">
                                            <label>Inactive</label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btnUpdateAccount float-right" id="btnUpdateAccount" name="btnUpdateAccount">Update Account</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>