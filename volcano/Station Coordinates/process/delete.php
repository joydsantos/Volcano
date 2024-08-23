<?php
include '../../../database/mydb.php';
session_start();
try {
    $id = intval($_POST['id']);

    // Prepare and execute the statement to delete from tbl_station_coordinates_instrument
    $deleteSqlInstrument = "DELETE from `tbl_station_coordinates_instrument` WHERE `station_coordinate_id`=?";
    $stmtInstrument = $conn->prepare($deleteSqlInstrument);
    $stmtInstrument->bind_param("i", $id);
    $resultInstrument = $stmtInstrument->execute();

    if ($resultInstrument) {
        // Prepare and execute the statement to delete from tbl_station_coordinates
        $deleteSql = "DELETE from `tbl_station_coordinates` WHERE `id`=?";
        $stmt = $conn->prepare($deleteSql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        exit(json_encode($result));
    } else {
        throw new Exception("Failed to delete from tbl_station_coordinates_instrument");
    }
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
