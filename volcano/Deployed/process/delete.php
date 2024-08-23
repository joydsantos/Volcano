<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
try {

    $id = intval($_POST['id']);

    // First delete from tbl_instruments
    $deleteFk = "DELETE from `tbl_instruments` WHERE `equipment_id`=?";

    if ($stmt = $conn->prepare($deleteFk)) {
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        if ($result) {
            echo "Record deleted";
        } else {
            echo "Error deleting record " . $stmt->error;
        }

        $stmt->close(); // Close the statement
    } else {
        echo "Error preparing statement" . $conn->error;
    }

    // Now delete from tbl_deployed_equipment
    $deleteSql = "DELETE from `tbl_deployed_equipment` WHERE `id`=?";

    if ($stmt = $conn->prepare($deleteSql)) {
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        if ($result) {
        } else {
            echo "Error deleting record " . $stmt->error;
        }

        $stmt->close(); // Close the statement
    } else {
        echo "Error preparing statement" . $conn->error;
    }

    exit(json_encode($result));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
