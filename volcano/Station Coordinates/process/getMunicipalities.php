<?php

include '../../../database/mydb.php';
session_start();

$id = intval($_GET['provinceId']);

$selectSql = "SELECT * FROM `tbl_municipalities` WHERE `province_id` = ?";
$stmt = $conn->prepare($selectSql);
$stmt->bind_param("i", $id);
$stmt->execute();


$result = $stmt->get_result();
$municipalities = $result->fetch_all(MYSQLI_ASSOC);

include_once('../partials/municipality_select.php');
