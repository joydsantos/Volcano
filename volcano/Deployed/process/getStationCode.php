<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
$id = intval($_GET['stationId']);

$selectSql = "SELECT * FROM `tbl_station_code` WHERE `station_id` = ?";
$stmt = $conn->prepare($selectSql);
$stmt->bind_param("i", $id);
$stmt->execute();


$result = $stmt->get_result();
$station_codes = $result->fetch_all(MYSQLI_ASSOC);

include_once('../partials/station_code_select.php');
