<?php
include '../../database/mydb.php';
$id = $_GET['id'];
$select = "SELECT 
    r.*, 
    s.station AS station_name, 
    sc.code AS station_code, 
    stat.status AS status_name 
FROM 
    `tbl_reports` r 
LEFT JOIN 
    tbl_station s ON r.station = s.id 
LEFT JOIN 
    tbl_station_code sc ON r.station_code = sc.code_id
LEFT JOIN 
    tbl_maintenance_report_status stat ON r.status = stat.id
where r.id = ?";

$stmt = $conn->prepare($select);

$stmt->bind_param('i', $id);


$stmt->execute();
$result = $stmt->get_result();
$data = mysqli_fetch_array($result);


?>

<table class="table table-bordered" style=" color: black">
    <thead>
        <tr>
            <th scope="col" colspan="2">Details</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Date</th>
            <td><?= $data['date'] ?></td>
        </tr>
        <tr>
            <th scope="row">Station</th>
            <td><?= $data['station_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Station Code</th>
            <td><?= $data['station_code'] ?></td>
        </tr>
        <tr>
            <th scope="row">Problem</th>
            <td><?= $data['problem'] ?></td>
        </tr>
        <tr>
            <th scope="row">Action Taken</th>
            <td><?= $data['action_taken'] ?></td>
        </tr>
        <tr>
            <th scope="row">Status</th>
            <td><?= $data['status_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Recommendation</th>
            <td><?= $data['recommendation'] ?></td>
        </tr>
        <tr>
            <th scope="row">Remarks</th>
            <td><?= $data['remarks'] ?></td>
        </tr>
        <tr>
            <th scope="row">Field Party</th>
            <td><?= $data['field_party'] ?></td>
        </tr>
        <tr>
            <th scope="row">Photos</th>
            <td><?= $data['photos'] ?></td>
        </tr>
    </tbody>
</table>