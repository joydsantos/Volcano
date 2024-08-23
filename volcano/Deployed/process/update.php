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
    $stationId = intval($_POST['stationId']);
    $stationCode = intval($_POST['stationCode']);
    $locationId = intval($_POST['locationId']);
    $instruments = $_POST['instruments'];

    $updateSql = "UPDATE `tbl_deployed_equipment` SET `station_id`=?,`station_code_id`=?,`location_id`=? WHERE id=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiii", $stationId, $stationCode, $locationId, $id);
    $result = $stmt->execute();

    // insert instruments
    $deleteSql = "DELETE FROM tbl_instruments where equipment_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $insertInstrumentSql = "INSERT INTO `tbl_instruments`(`description`,`equipment_id`) values (?,?)";
    $instrumentStmt = $conn->prepare($insertInstrumentSql);
    foreach ($instruments as $instrument) {
        $instrumentStmt->bind_param('si', $instrument, $id);
        $instrumentStmt->execute();
    }

    $query = "SELECT
    e.id,
    l.location,
    (
    SELECT
        GROUP_CONCAT(
            ins.description
        ORDER BY
            ins.id SEPARATOR ','
        )
    FROM
        tbl_instruments ins
    WHERE
        ins.equipment_id = e.id
    ) AS instruments,
    s.Station AS station_name,
    sc.code AS station_code
    FROM
    `tbl_deployed_equipment` e
    LEFT JOIN tbl_station s ON
    s.id = e.station_id
    LEFT JOIN tbl_station_code sc ON
    sc.code_id = e.station_code_id
    LEFT JOIN tbl_locations l ON
    l.id = e.location_id where e.id = $id;";

    $createdItem = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($createdItem);
    $table_row = require_once('../partials/item_row.php');



    exit(json_encode($table_row));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
