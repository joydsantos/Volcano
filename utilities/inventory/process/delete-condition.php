<?php
include '../../../database/mydb.php';
session_start();
try {

    $id = intval($_POST['id']);


    if (isset($id) && $id != '') {
        #Check if the record exists in tbl_inventory
        $check_stmt = mysqli_prepare($conn, "SELECT * FROM tbl_inventory WHERE condition_id = ?");
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows <= 0) {
            // Record exists, proceed to delete from tbl_inventory_condition
            $delete_stmt = mysqli_prepare($conn, "DELETE FROM tbl_inventory_condition WHERE id = ?");
            $delete_stmt->bind_param("i", $id);
            $delete_stmt->execute();

            if ($delete_stmt->affected_rows > 0) {
                // Record deleted successfully
                echo 1;
            } else {
                // Failed to delete record
                echo 2;
            }

            $delete_stmt->close();
        } else {
            //record exist
            echo 3;
        }

        $check_stmt->close();
        exit;
    } else {
        http_response_code(400); // Bad Request
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
