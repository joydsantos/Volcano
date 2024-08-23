<?php

include '../../../database/mydb.php';
session_start();
$id = $_GET['id'];
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
        b.name AS barangay,
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
        c.station_type_id = t.id where c.id = ?;";

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
                <th width="25%">Observatory</th>
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
                <th>Latitude</th>
                <td><?= $viewItem['latitude'] ?></td>
            </tr>
            <tr>
                <th>Longitude</th>
                <td><?= $viewItem['longitude'] ?></td>
            </tr>
            <tr>
                <th>Elevation</th>
                <td><?= $viewItem['elevation'] ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?= implode(', ', [
                        $viewItem['region'],
                        $viewItem['province'],
                        $viewItem['municipality'],
                        $viewItem['barangay'],
                    ]) ?></td>
            </tr>
            <tr>
                <th>Operation Start Date</th>
                <td><?= $viewItem['operation_date'] ?></td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td><?= $viewItem['remarks'] ?></td>
            </tr>
            <tr>
                <th>Instruments</th>
                <td><?= str_replace(",", "<br>", $viewItem['instruments']) ?></td>
            </tr>
        </tbody>
    </table>
</div>