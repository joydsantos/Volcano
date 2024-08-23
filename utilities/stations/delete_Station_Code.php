<?php
session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../index.php");
}

include '../../database/mydb.php';

if(isset($_POST['del_code_id']) && $_POST['del_code_id'] > 0 && isset($_POST['del_station_id']) && $_POST['del_station_id'] > 0) {


    $stationID = intval($_POST['del_station_id']);
    $stationCodeID = intval($_POST['del_code_id']);



    # Check if the station has transactions using prepared statement
    $checkQuery = "SELECT * FROM tbl_transaction WHERE Station_Name = ? AND Station_Code = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "ii", $stationID, $stationCodeID);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if(mysqli_num_rows($result) > 0) {
        # Records with transactions exist, cannot delete
        echo 2;
        exit;
    } else {
        # Check if the station has old transactions using prepared statement
        $checkQuery1 = "SELECT * FROM tbl_oldtransaction WHERE Station_Name = ? AND station_code_id = ?";
        $checkStatement1 = mysqli_prepare($conn, $checkQuery1);
        mysqli_stmt_bind_param($checkStatement1, "ii", $stationID, $stationCodeID);
        mysqli_stmt_execute($checkStatement1);
        $result1 = mysqli_stmt_get_result($checkStatement1);

        if(mysqli_num_rows($result1) > 0) {
            # Records with transactions exist, cannot delete
            echo 3;
            exit;
        } else {
            # Delete the station using prepared statement
            $deleteQuery = "DELETE FROM tbl_station_code WHERE code_id = ? AND station_id = ?";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStatement, "ii", $stationCodeID, $stationID);

            if(mysqli_stmt_execute($deleteStatement)) {
                echo 1; // Successful deletion
                exit;
            } else {
                echo 4; // Deletion failed
                exit;
            }
        }
    }
} else {
    exit; // Invalid request
}
?>