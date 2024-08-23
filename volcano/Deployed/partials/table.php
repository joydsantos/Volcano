<?php
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
  session_destroy();
  header("Location: ../../../index.php");
}

$select = "SELECT
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
l.id = e.location_id ";


// create filter
$filter = [];
$bindingType = '';
$bindingValue = [];
if (isset($_POST['station']) && $_POST['station'] != '') {
  array_push($filter, 'e.station_id=?');
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

<table class="table table-hover align-middle" id="equipmentTable" style=" color: black; font-size: 16px;">
  <thead class="table-dark" style="  font-size: 14px;">
    <tr>
      <th>Observatory</th>
      <th>Location</th>
      <th>Station Code</th>
      <th>Instruments</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php
    foreach ($items as $row) {
      include 'item_row.php';
    };
    ?>

  </tbody>
</table>