<?php
session_start();
include '../../database/mydb.php';
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../index.php");
}


if (isset($_POST['del_code_id']) && $_POST['del_code_id'] > 0 && isset($_POST['del_station_id']) && $_POST['del_station_id'] > 0) {


    $stationID = intval($_POST['del_station_id']);
    $stationCatID = intval($_POST['del_code_id']);

    # Chek if the station has transactions using prepared statement
    $checkQuery = "SELECT * FROM tbl_remote_station WHERE station_category = ? AND station_type = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "ii", $stationCatID, $stationID);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Records with transactions exist, cannot delete
        echo 2;
        exit;
    } else {

        # Delete the station using prepared statement
        $deleteQuery = "DELETE FROM tbl_remotestation_equip_category WHERE id =? AND stationtype_id = ?";
        $deleteStatement = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStatement, "ii", $stationCatID, $stationID);

        if (mysqli_stmt_execute($deleteStatement)) {
            echo 1; // Successful deletion
            exit;
        } else {
            echo 4; // Deletion failed
            exit;
        }


    }
} else {
    exit; // Invalid request
}
?>