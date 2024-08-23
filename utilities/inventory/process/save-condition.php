<?php
include '../../../database/mydb.php';
session_start();

try {

    if (isset($_POST['id']) && isset($_POST['name'])) {
        $id = intval($_POST['id']);
        $condition = mysqli_real_escape_string($conn, $_POST['name']);

        if ($id > 0) {
            $stmt = mysqli_prepare($conn, "UPDATE tbl_inventory_condition SET `condition`=? WHERE id=?");
            if ($stmt) {
                $stmt->bind_param("si", $condition, $id);
            } else {
                // Handle statement preparation error
                die("Error preparing the update statement: " . mysqli_error($conn));
            }
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO tbl_inventory_condition (`condition`) VALUES (?)");
            if ($stmt) {
                $stmt->bind_param("s", $condition);
            } else {
                // Handle statement preparation error
                die("Error preparing the insert statement: " . mysqli_error($conn));
            }
        }

        if ($stmt->execute()) {
            // Handle successful execution
        } else {
            // Handle execution error
            die("Error executing the statement: " . $stmt->error);
        }
    } else {
        // Handle missing POST data
        die("Required POST data is missing.");
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
