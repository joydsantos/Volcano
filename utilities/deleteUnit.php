<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}

include '../database/mydb.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    # Validate input

    # Check if the category has transactions using prepared statement
    $checkQuery = "SELECT * FROM tblstocks WHERE unit_id= ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "i", $id);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Records with transactions exist, cannot delete
        echo 2;
        exit;
    } else {
        # Check if the category has transactions using prepared statement
        $checkInventory = "SELECT * FROM tbl_inventory WHERE unit_id= ?";
        $checkStatement = mysqli_prepare($conn, $checkInventory); // corrected line
        mysqli_stmt_bind_param($checkStatement, "i", $id);
        mysqli_stmt_execute($checkStatement);
        $result = mysqli_stmt_get_result($checkStatement);

        if (mysqli_num_rows($result) > 0) {
            # Records with transactions exist, cannot delete
            echo 3;
            exit;
        } else {
            //delete unit
            $deleteQuery = "DELETE FROM tbl_unit_measurement WHERE id = ?";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStatement, "i", $id); // corrected line

            if (mysqli_stmt_execute($deleteStatement)) {
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
