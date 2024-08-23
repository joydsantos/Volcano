<?php
include '../../database/mydb.php';
$id = $_GET['id'];
// Prepare the SQL statement with placeholders

/*
$select = "SELECT i.*,
    concat(u.First_Name, ' ', u.Last_Name) as endorser, 
    concat(p.First_Name, ' ', p.Last_Name) as par_name,
    t.name as type_name,
    s.Station as station_name,
    c.condition as condition_name
FROM tbl_inventory i 
LEFT JOIN tbl_par u ON u.id = i.endorsed_by 
LEFT JOIN tbl_inventory_types t ON t.id = i.type_id 
LEFT JOIN tbl_inventory_condition c ON c.id = i.condition_id 
LEFT JOIN tbl_station s ON s.id = i.station_id 
LEFT JOIN tbl_par p ON p.id = i.par */

$select = "SELECT 
    i.*,
    concat(u.First_Name, ' ', u.Last_Name) AS endorser, 
    concat(p.First_Name, ' ', p.Last_Name) AS par_name,
    t.name AS type_name,
    s.Station AS station_name,
    c.condition AS condition_name,
    un.measurement AS unitM
FROM tbl_inventory i 
LEFT JOIN tbl_par u ON u.id = i.endorsed_by 
LEFT JOIN tbl_inventory_types t ON t.id = i.type_id 
LEFT JOIN tbl_inventory_condition c ON c.id = i.condition_id 
LEFT JOIN tbl_station s ON s.id = i.station_id 
LEFT JOIN tbl_par p ON p.id = i.par 
LEFT JOIN tbl_unit_measurement un ON un.id = i.unit_id
WHERE i.id = ?";

// Create a prepared statement
$stmt = $conn->prepare($select);

// Bind the parameter
$stmt->bind_param('i', $id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the data
$data = $result->fetch_array(MYSQLI_ASSOC);

// Close the statement
$stmt->close();

// Handle the data as needed
if ($data) {
    // Do something with $data
} else {
    echo "No records found.";
}

?>

<table class="table table-bordered" style=" color: black">
    <thead>
        <tr>
            <th scope="col" colspan="2">Details</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Item Type</th>
            <td><?= $data['type_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Item Name</th>
            <td><?= $data['item_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Brand/Model</th>
            <td><?= $data['brand_model'] ?></td>
        </tr>
        <tr>
            <th scope="row">Serial / Property No.</th>
            <td><?= $data['serial_no'] ?></td>
        </tr>
        <tr>
            <th scope="row">Quantity</th>
            <td><?= $data['quantity'] ?></td>
        </tr>
        <tr>
            <th scope="row">Unit</th>
            <td><?= $data['unitM'] ?></td>
        </tr>
        <tr>
            <th scope="row">Acquisition Year</th>
            <td><?= $data['acquisition_year'] ?></td>
        </tr>
        <tr>
            <th scope="row">Deployment</th>
            <td><?= $data['deployment'] ?></td>
        </tr>
        <tr>
            <th scope="row">Condition</th>
            <td><?= $data['condition_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Endorsed By</th>
            <td><?= $data['endorser'] ?></td>
        </tr>
        <tr>
            <th scope="row">PAR</th>
            <td><?= $data['par_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Satation</th>
            <td><?= $data['station_name'] ?></td>
        </tr>
        <tr>
            <th scope="row">Action Taken</th>
            <td><?= $data['action_taken'] ?></td>
        </tr>
        <tr>
            <th scope="row">Remarks</th>
            <td><?= $data['remarks'] ?></td>
        </tr>

    </tbody>
</table>