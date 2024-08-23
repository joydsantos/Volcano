<?php

include '../../../database/mydb.php';
session_start();

$id = intval($_GET['municipalityId']);

$selectSql = "SELECT * FROM `tbl_barangays` WHERE `municipality_id` = ?";
$stmt = $conn->prepare($selectSql);
$stmt->bind_param("i", $id);
$stmt->execute();


$result = $stmt->get_result();
$barangays = $result->fetch_all(MYSQLI_ASSOC);

include_once('../partials/barangay_select.php');
