<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../index.php");
}
if (isset($_POST['id']) && isset($_POST['indexId'])) {
    $id = trim($_POST['id']); #name mismo
    $indexId = intval($_POST['indexId']); # stationtype id foreign key sa tbl_remotestation_equip_category` 

    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $id)) {
        echo 'Invalid input';
        exit;
    }

    # Check if the station has records using prepared statement
    $checkQuery = "SELECT * FROM viewremotestation WHERE station_type = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "s", $id);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        #cannot delete
        echo 2;
        exit;
    } else {

        #delete category first
        $deleteQuery = "DELETE FROM tbl_remotestation_equip_category WHERE stationtype_id = ?";
        $deleteStatement = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStatement, "i", $indexId);

        if (mysqli_stmt_execute($deleteStatement)) {

            # Delete the station using prepared statement
            $deleteQuery = "DELETE FROM tbl_remote_stationtype WHERE station_type = ?";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStatement, "s", $id);

            if (mysqli_stmt_execute($deleteStatement)) {
                echo 1; // Successful deletion
                exit;
            } else {
                echo 4; // Deletion failed
                exit;
            }
        } else {
            echo 4; // Deletion failed
            exit;
        }




    }
} else {
    exit; // Invalid request
}
?>