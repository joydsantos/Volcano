<?php
include '../../database/mydb.php';
session_start();

try {
    $id = intval($_POST['id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $station_id = intval($_POST['station_id']);
    $station_code_id = intval($_POST['cboUpdateMainStationCode']);
    $problem = mysqli_real_escape_string($conn, $_POST['problem']);
    $action_taken = mysqli_real_escape_string($conn, $_POST['action_taken']);
    $status_id = intval($_POST['status_id']);
    $recommendation = mysqli_real_escape_string($conn, $_POST['recommendation']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $field_party = mysqli_real_escape_string($conn, $_POST['field_party']);
    $photos = mysqli_real_escape_string($conn, $_POST['photos']);

    $insertReports = "UPDATE
    `tbl_reports`
SET
    `date` = ?,
    `station` = ?,
    `station_code` =? ,
    `problem` = ?,
    `action_taken` = ?,
    `status` = ?,
    `recommendation` = ?,
    `remarks` = ?,
    `field_party` = ?,
    `photos` = ?
WHERE
    `id` = ? ";


    $stmt = $conn->prepare($insertReports);
    $stmt->bind_param("siississssi", $date, $station_id, $station_code_id, $problem, $action_taken, $status_id, $recommendation, $remarks,  $field_party, $photos, $id);
    $result = $stmt->execute();


    $select = "SELECT r.*,s.station as station_name,stat.status as status_name FROM `tbl_reports` r 
left join tbl_station s on  r.station = s.id 
left join tbl_maintenance_report_status stat on  r.status = stat.id 
where r.id = ?";
    $stmt = $conn->prepare($select);
    $stmt->bind_param('i', $id);
    $stmt->execute();


    $result2 = $stmt->get_result();

    $row = mysqli_fetch_assoc($result2);

    $table_row = require_once('../partials/item_row.php');
    exit(json_encode($result2));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
