<?php
$select = "SELECT
c.id,
c.latitude,
c.longitude,
c.elevation,
date(c.operation_start_date) as operation_date,
l.location,
r.name AS region,
p.name AS province,
m.name AS municipality,
b.name AS barngay,
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
c.station_type_id = t.id";


// create filter
$filter = [];
$bindingType = '';
$bindingValue = [];
if (isset($_POST['station']) && $_POST['station'] != '') {
  array_push($filter, 'c.station_id=?');
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

<table class="table table-hover align-middle" id="stationCoordinatesTable" style=" color: black; font-size: 16px;">
  <thead class="table-dark" style="  font-size: 14px;">
    <tr>
      <th>Observatory</th>
      <th>Location</th>
      <th>Station Code</th>
      <th>Latitude (WGS84 N)</th>
      <th>Longitude (WGS84 E)</th>
      <th>Elevation (masl)</th>
      <th>Station Type</th>
      <th>Instrument Installed</th>
      <th>Operation Date</th>
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