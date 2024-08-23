<?php
include '../../database/mydb.php';
session_start();

try {
    $id = intval($_POST['id']);
    $type_id = intval($_POST['type_id']);
    $name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $brand_model = mysqli_real_escape_string($conn, $_POST['brand_model']);
    $serial_no = mysqli_real_escape_string($conn, $_POST['serial_no']);
    $quantity = intval($_POST['quantity']);
    //$unit = mysqli_real_escape_string($conn, $_POST['unit']);\
    $unit =  intval($_POST['unit']);
    $acquisition_year = mysqli_real_escape_string($conn, $_POST['acquisition_year']);
    $deployment = mysqli_real_escape_string($conn, $_POST['deployment']);
    $condition_id = intval($_POST['condition_id']);
    $action_taken = mysqli_real_escape_string($conn, $_POST['action_taken']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $endorsed_by = mysqli_real_escape_string($conn, $_POST['endorsed_by']);
    $par = mysqli_real_escape_string($conn, $_POST['par']);
    $station_id = intval($_POST['station_id']);


    $insertICTEquipment = "UPDATE `tbl_inventory` SET `type_id`=?, `item_name`=?,`brand_model`=?,`serial_no`=?,`quantity`=?,`unit_id`=?,`acquisition_year`=?,`deployment`=?,`condition_id`=?,`action_taken`=?,`remarks`=?,`endorsed_by`=?,`par`=?,`station_id`=? WHERE  `id`=?";


    $stmt = $conn->prepare($insertICTEquipment);
    $stmt->bind_param("isssiississisii", $type_id, $name, $brand_model, $serial_no, $quantity, $unit,  $acquisition_year, $deployment, $condition_id, $action_taken, $remarks, $endorsed_by, $par, $station_id, $id);
    $result = $stmt->execute();

    $query = "SELECT i.*,
    concat(u.First_Name,' ',u.Last_Name) as endorser, 
    concat(p.First_Name,' ',p.Last_Name) as par_name,
    t.name as type_name,
    s.Station as station_name,
    c.condition as condition_name,
    un.measurement AS unitM
    FROM `tbl_inventory` i 
    LEFT join tbl_par u on u.id = i.endorsed_by 
    LEFT join tbl_inventory_types t on t.id = i.type_id 
    LEFT join tbl_inventory_condition c on c.id = i.condition_id 
    LEFT join tbl_station s on s.id = i.station_id 
    LEFT JOIN tbl_unit_measurement un ON un.id = i.unit_id
    LEFT join tbl_par p on p.id = i.par WHERE i.`id` = $id";

    $selectLastId = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($selectLastId);
    $table_row = require_once('../partials/item_row.php');
    exit(json_encode($result));
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
