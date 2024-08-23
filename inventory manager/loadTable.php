<?php
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../index.php");
}
$select = "SELECT i.*,
concat(u.First_Name,' ',u.Last_Name) as endorser, 
concat(p.First_Name,' ',p.Last_Name) as par_name,
t.name as type_name,
c.condition as condition_name,
un.measurement AS unitM
FROM `tbl_inventory` i 
LEFT join tbl_par u on u.id = i.endorsed_by 
LEFT join tbl_inventory_types t on t.id = i.type_id 
LEFT join tbl_inventory_condition c on c.id = i.condition_id 
LEFT JOIN tbl_unit_measurement un ON un.id = i.unit_id
LEFT join tbl_par p on p.id = i.par ORDER BY acquisition_year DESC";

// create filter

$filter = [];
$bindingType = '';
$bindingValue = [];
if (isset($_POST['inventory_type']) && $_POST['inventory_type'] != '') {
    array_push($filter, 'i.type_id=?');
    array_push($bindingValue, intval($_POST['inventory_type']));
    $bindingType .= 'i';
}
if (isset($_POST['acquisition_year']) && $_POST['acquisition_year'] != '') {
    array_push($filter, 'year(i.acquisition_year)=?');
    array_push($bindingValue, $_POST['acquisition_year']);
    $bindingType .= 's';
}
if (isset($_POST['station']) && $_POST['station'] != '') {
    array_push($filter, 'i.station_id=?');
    array_push($bindingValue, intval($_POST['station']));
    $bindingType .= 'i';
}

$stmt = $conn->prepare($select);

if (sizeof($filter) !== 0) {
    $select .= " WHERE " . implode(' and ', $filter);
    $stmt = $conn->prepare($select);
    $stmt->bind_param($bindingType, ...$bindingValue);
}

$stmt->execute();

$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC)
?>
<div class="table-responsive  mt-2">
    <table class="table table-hover align-middle" id="inventoryTableID" style=" color: black; font-size: 16px;">
        <thead class="table-dark" style=" font-size: 14px;">
            <tr class="text-nowrap">
                <!-- <th class='align-middle text-left'>Type</th> -->
                <th class='align-middle text-left'>Name</th>
                <th class='align-middle text-left'>Brand/Model</th>
                <th class='align-middle text-left'>Serial / Property No.</th>
                <th class='align-middle text-left'>Quantity</th>
                <th class='align-middle text-left'>Unit</th>
                <th class='align-middle text-left'>Acquisition Year</th>
                <th class='align-middle text-left'>Deployment</th>
                <th class='align-middle text-left'>Condition</th>
                <th class='align-middle text-left'>Action Taken</th>
                <!-- <th class='align-middle text-left'>Endorsed By</th> -->
                <!-- <th class='align-middle text-left'>PAR</th> -->
                <th class='align-middle text-left sticky-col'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (sizeof($items) == 0) {
                echo '<tr><td colspan="12" class="text-center">No Data Found</td></tr>';
            } else {

                foreach ($items as $row) {
                    include 'partials/item_row.php';
                };
            }
            ?>

        </tbody>
    </table>
</div>