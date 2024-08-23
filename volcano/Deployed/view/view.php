<?php
include '../../../database/mydb.php';
session_start();
$id = $_GET['id'];
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
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
l.id = e.location_id where e.id = ?;";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$viewItem = mysqli_fetch_array($result);

?>


<div class="table-responsive">
    <table class="table table-bordered" style=" color: black">
        <tbody>
            <tr>
                <th width="20%">Observatory</th>
                <td><?= $viewItem['station_name'] ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <td><?= $viewItem['location'] ?></td>
            </tr>
            <tr>
                <th>Station Code</th>
                <td><?= $viewItem['station_code'] ?></td>
            </tr>
            <tr>
                <th>Instruments</th>
                <td><?= str_replace(",", "<br>", $viewItem['instruments']) ?></td>
            </tr>
        </tbody>
    </table>
</div>