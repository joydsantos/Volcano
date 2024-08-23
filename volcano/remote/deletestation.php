<?php
include '../../database/mydb.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    # Validate input
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $id)) {
        echo 'Invalid input';
        exit;
    } 
        # Delete the station using prepared statement
        $deleteQuery = "DELETE FROM tblremote WHERE id = ?";
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
    exit; // Invalid request
}
?>
