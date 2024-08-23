<?php

include '../../../database/mydb.php';
session_start();

$id = intval($_GET['regionId']);

$selectSql = "SELECT * FROM `tbl_provinces` WHERE `region_id` = ?";
$stmt = $conn->prepare($selectSql);
$stmt->bind_param("i", $id);
$stmt->execute();


$result = $stmt->get_result();
$provinces = $result->fetch_all(MYSQLI_ASSOC);

include_once('../partials/province_select.php');
