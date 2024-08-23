<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
include '../../database/mydb.php';

if (isset($_POST['id']) && isset($_POST['division'])) {
    $id = intval($_POST['id']);
    $new = trim($_POST['division']);

    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s\/]+$/', $new)) {
        echo 'Invalid input';
        exit;
    }


    # Check if the division already exists using prepared statement
    $checkQuery = "SELECT * FROM tbl_division WHERE division = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "s", $new);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Record already exists
        echo 2;
        exit;
    }

    # Update the station using prepared statement
    $updateQuery = "UPDATE tbl_division SET division = ? WHERE id = ?";
    $updateStatement = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStatement, "si", $new, $id);

    if (mysqli_stmt_execute($updateStatement)) {
        echo 1; // Successful update
    } else {
        echo 0; // Update failed
    }

    exit;
}

exit; // Invalid request
