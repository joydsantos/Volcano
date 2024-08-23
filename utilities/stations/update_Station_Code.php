<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../../index.php");
}

include '../../database/mydb.php';

if (isset($_POST['upd_code_id']) && isset($_POST['upd_station_id']) && isset($_POST['upd_code']) && $_POST['upd_code_id'] > 0 && $_POST['upd_station_id'] > 0) {

    $stationId = intval($_POST['upd_station_id']);
    $codeId = intval($_POST['upd_code_id']);
    $code = trim($_POST['upd_code']);

    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s\-]+$/', $code)) {
        echo 'Invalid input';
        exit;
    }

    # Check if the station already exists using prepared statement
    $checkQuery = "SELECT * FROM tbl_station_code WHERE station_id = ? AND code = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "is", $stationId, $code);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Record already exists
        echo 2;
        exit;
    }
    # Update the station using prepared statement
    $updateQuery = "UPDATE tbl_station_code SET code = ? WHERE code_id = ? AND station_id = ?";
    $updateStatement = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStatement, "sii", $code, $codeId, $stationId);

    if (mysqli_stmt_execute($updateStatement)) {
        echo 1; // Successful update
    } else {
        echo 0; // Update failed
    }

    exit;
}

exit; // Invalid request
?>