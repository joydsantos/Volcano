<?php
include '../../database/mydb.php';
session_start();

try {

    $id = intval($_POST['id']);

    $deleteSql = "DELETE from `tbl_reports` WHERE `id`=?";

    $stmt = $conn->prepare($deleteSql);

    $stmt->bind_param("i", $id);

    $result = $stmt->execute();

    exit(json_encode($result));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
