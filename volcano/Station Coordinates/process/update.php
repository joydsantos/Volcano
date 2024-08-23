<?php
include '../../../database/mydb.php';
session_start();

try {
    $id = intval($_POST['id']);
    $stationId = intval($_POST['stationId']);
    $stationCode = intval($_POST['stationCode']);
    $locationId = intval($_POST['locationId']);
    $regionId = intval($_POST['regionId']);
    $provinceId = intval($_POST['provinceId']);
    $municipalityId = intval($_POST['municipalityId']);
    $barangayId = intval($_POST['barangayId']);
    $stationTypeId = intval($_POST['stationTypeId']);
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $elevation = $_POST['elevation'];
    $operationStartDate = $_POST['operationStartDate'];
    $instruments = $_POST['instruments'];
    $remarks = $_POST['remarks'];

    $updateSql = "UPDATE `tbl_station_coordinates` SET `station_id`=?,`location_id`=?,`station_code_id`=?,`region_id`=?,`province_id`=?,`municipality_id`=?,`barangay_id`=?,`station_type_id`=?,`operation_start_date`=?,`latitude`=?,`longitude`=?,`elevation`=?, `remarks`=? WHERE `id` = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("iiiiiiiisssssi", $stationId, $locationId, $stationCode, $regionId, $provinceId, $municipalityId, $barangayId, $stationTypeId, $operationStartDate, $latitude, $longitude, $elevation, $remarks, $id);
    $result = $stmt->execute();

    // insert instruments
    $deleteSql = "DELETE FROM tbl_station_coordinates_instrument where station_coordinate_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $insertInstrumentSql = "INSERT INTO `tbl_station_coordinates_instrument` (`description`,`station_coordinate_id`) values (?,?)";
    $instrumentStmt = $conn->prepare($insertInstrumentSql);
    foreach ($instruments as $instrument) {
        $instrumentStmt->bind_param('si', $instrument, $id);
        $instrumentStmt->execute();
    }

    $query = "SELECT
            c.id,
            c.latitude,
            c.longitude,
            c.elevation,
             c.remarks,
            date(c.operation_start_date) as operation_date,
            l.location,
            r.name AS region,
            p.name AS province,
            m.name AS municipality,
            b.name AS barngay,
            t.station_type AS type_name,
            (
            SELECT
                GROUP_CONCAT(
                    ins.description
                ORDER BY
                    ins.id SEPARATOR ','
                )
            FROM
                tbl_station_coordinates_instrument ins
            WHERE
                ins.station_coordinate_id = c.id
        ) AS instruments,
        s.Station AS station_name,
        sc.code AS station_code
        FROM
            tbl_station_coordinates c
        LEFT JOIN tbl_station s ON
            s.id = c.station_id
        LEFT JOIN tbl_station_code sc ON
            sc.code_id = c.station_code_id
        LEFT JOIN tbl_locations l ON
            l.id = c.location_id
        LEFT JOIN tbl_regions r ON
            c.region_id = r.id
        LEFT JOIN tbl_provinces p ON
            c.province_id = p.id
        LEFT JOIN tbl_municipalities m ON
            c.municipality_id = m.id
        LEFT JOIN tbl_barangays b ON
            c.barangay_id = b.id
        LEFT JOIN tbl_remote_stationtype t ON
            c.station_type_id = t.id where c.id = $id;";

    $createdItem = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($createdItem);
    $table_row = require_once('../partials/item_row.php');



    exit(json_encode($table_row));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
