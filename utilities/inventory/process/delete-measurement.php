<?php
include '../../../database/mydb.php';
session_start();


try {

    $id = intval($_POST['id']);

    if (isset($id) && $id != '') {
        $stmt = mysqli_prepare($conn, "DELETE FROM tbl_unit_measurement where id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } else {
        http_response_code(404);
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
