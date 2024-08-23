<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
try {
    $stationId = intval($_POST['stationId']);
    $stationCode = intval($_POST['stationCode']);
    $locationId = intval($_POST['locationId']);
    $instruments = $_POST['instruments'];

    $insertSql = "INSERT INTO `tbl_deployed_equipment`(`station_id`, `station_code_id`,`location_id`) VALUES (?,?,?)";

    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iii", $stationId, $stationCode, $locationId);
    $result = $stmt->execute();

    $lastInsertID = mysqli_insert_id($conn);

    // insert instruments
    $insertInstrumentSql = "INSERT into `tbl_instruments`(`description`,`equipment_id`) values (?,?)";
    $instrumentStmt = $conn->prepare($insertInstrumentSql);
    foreach ($instruments as $instrument) {
        $instrumentStmt->bind_param('si', $instrument, $lastInsertID);
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
    l.id = e.location_id where e.id = $lastInsertID;";

    $createdItem = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($createdItem);
    $table_row = require_once('../partials/item_row.php');



    exit(json_encode($table_row));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
