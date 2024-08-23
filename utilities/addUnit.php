<?php
session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {

} else {
    session_destroy();
    header("Location: ../index.php");
}

include '../database/mydb.php';

if(isset($_POST['unit'])) {
    $unit = trim($_POST['unit']);

    # Validate input

    if(!preg_match('/^[a-zA-Z0-9\s]+$/', $unit)) {
        echo 'Invalid input';
        exit;
    }

    # Check if the unit already exists using prepared statement
    $checkQuery = "SELECT * FROM tbl_unit_measurement WHERE measurement = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "s", $unit);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if(mysqli_num_rows($result) > 0) {
        # Record already exists
        echo 2;
        exit;
    } else {
        # Insert the new category using prepared statement
        $insertQuery = "INSERT INTO tbl_unit_measurement (measurement) VALUES (?)";
        $insertStatement = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStatement, "s", $unit);

        if(mysqli_stmt_execute($insertStatement)) {
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
