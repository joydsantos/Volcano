<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../index.php");
}
if (isset($_POST['add_Code']) && isset($_POST['station_id']) && $_POST['station_id'] > 0) {
    $code = trim($_POST['add_Code']);
    $stationId = intval($_POST['station_id']);
    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s\-]+$/', $code)) {
        echo 'Invalid input';
        exit;
    }


    # Check if the station already exists using prepared statement
    $checkQuery = "SELECT * FROM tbl_remotestation_equip_category WHERE stationtype_id = ? AND category = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "is", $stationId, $code);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Record already exists
        echo 2;
        exit;
    } else {
        # Insert the new station using prepared statement
        $insertQuery = "INSERT INTO tbl_remotestation_equip_category (stationtype_id, category) VALUES (?,?)";
        $insertStatement = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStatement, "is", $stationId, $code);

        if (mysqli_stmt_execute($insertStatement)) {
            echo 1; // Successful insertion
            exit;
        } else {
            echo 4; // Insertion failed
            exit;
        }
    }
} else {
    echo 7; // Invalid request
    exit;
}
?>