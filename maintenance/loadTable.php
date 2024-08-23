<?php
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}

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
    tbl_maintenance_report_status stat ON r.status = stat.id;
";

// create filter

$filter = [];
$bindingType = '';
$bindingValue = [];

if (isset($_POST['station']) && $_POST['station'] != '') {
    array_push($filter, 'r.station = ?');
    array_push($bindingValue, intval($_POST['station']));
    $bindingType .= 'i';
}

if (sizeof($filter) !== 0) {
    $select .= " WHERE " . implode(' AND ', $filter);
}

$stmt = $conn->prepare($select);

if (sizeof($filter) !== 0) {
    $stmt->bind_param($bindingType, ...$bindingValue);
}

$stmt->execute();

$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

/*
if (isset($_POST['inventory_type']) && $_POST['inventory_type'] != '') {
    array_push($filter, 'i.type_id=?');
    array_push($bindingValue, intval($_POST['inventory_type']));
    $bindingType .= 'i';
}
if (isset($_POST['acquisition_year']) && $_POST['acquisition_year'] != '') {
    array_push($filter, 'year(i.acquisition_year)=?');
    array_push($bindingValue, $_POST['acquisition_year']);
    $bindingType .= 's';
} */
?>


<div class="table-responsive  mt-2">
    <table class="table table-hover align-middle inventoryTableID1" id="inventoryTableID1" style=" color: black; font-size: 16px;">
        <thead class="table-dark" style=" font-size: 14px;">
            <tr class="text-nowrap">
                <!-- <th class='align-middle text-left'>Type</th> -->
                <th class='align-middle text-left'>Date</th>
                <th class='align-middle text-left'>Station</th>
                <th class='align-middle text-left'>Code</th>
                <th class='align-middle text-left'>Problem</th>
                <th class='align-middle text-left'>Actions Taken</th>
                <th class='align-middle text-left'>Status</th>
                <th class='align-middle text-left'>Recommendation</th>
                <th class='align-middle text-left'>Remarks</th>
                <th class='align-middle text-left'>Field Party</th>
                <th class='align-middle text-left'>Photos</th>
                <th class='align-middle text-left sticky-col'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (sizeof($items) == 0) {
            } else {
                foreach ($items as $row) {
                    include 'partials/item_row.php';
                };
            }
            ?>
        </tbody>
    </table>
</div>