<?php
include '../../../database/mydb.php';
session_start();


try {

    $id = intval($_POST['id']);
    $measurement = mysqli_real_escape_string($conn, $_POST['measurement']);

    if (isset($id) && $id != '') {
        $stmt = mysqli_prepare($conn, "UPDATE tbl_unit_measurement set `measurement`=? where id=?");
        $stmt->bind_param("si", $measurement, $id);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT into tbl_unit_measurement(`measurement`) values( ? )");
        $stmt->bind_param("s", $measurement);
    }
    $stmt->execute();
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
