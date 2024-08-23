<?php
include '../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../index.php");
}
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); #id of division na idedelete


    # Check if it has records using prepared statement
    $checkQuery = "SELECT * FROM tbl_oldtransaction WHERE Division_id = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "i", $id);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        #cannot delete
        echo 2;
        exit;
    } else {

        # Check if it has records using prepared statement
        $checkQuery = "SELECT * FROM tbl_transaction WHERE Division_id = ?";
        $checkStatement = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStatement, "i", $id);
        mysqli_stmt_execute($checkStatement);
        $result = mysqli_stmt_get_result($checkStatement);

        if (mysqli_num_rows($result) > 0) {
            #cannot delete
            echo 3;
            exit;
        } else {
            # Delete 
            $deleteQuery = "DELETE FROM tbl_division WHERE id=?";
            $deleteStatement = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($deleteStatement, "i", $id);

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
