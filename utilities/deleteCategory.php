<?php
session_start();
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth")
{

}
else
{
  session_destroy();
  header("Location: ../index.php");
}

include '../database/mydb.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $id)) {
        echo 'Invalid input';
        exit;
    }

    # Check if the category has transactions using prepared statement
    $checkQuery = "SELECT * FROM viewstocks WHERE Category = ?";
    $checkStatement = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStatement, "s", $id);
    mysqli_stmt_execute($checkStatement);
    $result = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($result) > 0) {
        # Records with transactions exist, cannot delete
        echo 2;
        exit;
    } else 
    {
        # Delete the category using prepared statement
        $deleteQuery = "DELETE FROM tbl_equipmentcategory WHERE category = ?";
        $deleteStatement = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStatement, "s", $id);

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
