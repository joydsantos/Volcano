<?php
include '../../../database/mydb.php';
session_start();

$id = intval($_GET['id']);

$selectSql = "SELECT *,date(operation_start_date) as operation_date from tbl_station_coordinates WHERE id  = ?;";
$stmt = $conn->prepare($selectSql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>
<input type="hidden" name="id" value="<?= $data['id'] ?>">
<div class="row ">
    <div class="col-md-4">
        <label>Observatory</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select onchange="onStationChanged(event)" name="stationId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * from tbl_station";
            $stations_result = mysqli_query($conn, $sql);
            while ($station = mysqli_fetch_array($stations_result)) {
                echo ' <option ' . ($data['station_id'] == $station['id'] ? 'selected' : '') . ' value="' . $station['id'] . '">' . $station['Station'] . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="col-md-4">
        <label>Location</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select name="locationId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * from tbl_locations";
            $stations_result = mysqli_query($conn, $sql);
            while ($station = mysqli_fetch_array($stations_result)) {
                echo ' <option ' . ($data['location_id'] == $station['id'] ? 'selected' : '') . ' value="' . $station['id'] . '">' . $station['location'] . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="col-md-4">
        <label>Station Code</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select name="stationCode" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * from tbl_station_code";
            $result = mysqli_query($conn, $sql);
            while ($code = mysqli_fetch_array($result)) {
                echo ' <option ' . ($data['station_code_id'] == $code['code_id'] ? 'selected' : '') . ' value="' . $code['code_id'] . '">' . $code['code'] . '</option>';
            }
            ?>
        </select>
    </div>
</div><br>
<div class="row ">
    <div class="col-md-4">
        <label>Region</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select onchange="onRegionChanged(event)" name="regionId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * FROM `tbl_regions`";
            $result = mysqli_query($conn, $sql);
            while ($region = mysqli_fetch_array($result)) {
                echo '<option ' . ($data['region_id'] == $region['id'] ? 'selected' : '') . ' value="' . $region['id'] . '">' . $region['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Province</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select name="provinceId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * FROM `tbl_provinces` where region_id = " . $data['region_id'];
            $result = mysqli_query($conn, $sql);
            while ($province = mysqli_fetch_array($result)) {
                echo '<option ' . ($data['province_id'] == $province['id'] ? 'selected' : '') . ' value="' . $province['id'] . '">' . $province['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Municipality</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select name="municipalityId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * FROM `tbl_municipalities` where province_id = " . $data['province_id'];
            $result = mysqli_query($conn, $sql);
            while ($municipality = mysqli_fetch_array($result)) {
                echo '<option ' . ($data['municipality_id'] == $municipality['id'] ? 'selected' : '') . ' value="' . $municipality['id'] . '">' . $municipality['name'] . '</option>';
            }
            ?>
        </select>
    </div>
</div><br>
<div class="row ">
    <div class="col-md-4">
        <label>Barangay</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select name="barangayId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $sql = "SELECT * FROM `tbl_barangays` where municipality_id = " . $data['municipality_id'];
            $result = mysqli_query($conn, $sql);
            while ($barangay = mysqli_fetch_array($result)) {
                echo '<option ' . ($data['barangay_id'] == $barangay['id'] ? 'selected' : '') . ' value="' . $barangay['id'] . '">' . $barangay['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Station Type</label><span class="text-danger  font-weight-bold"> *</span><br>
        <select name="stationTypeId" class="form-select shadow-sm" required="required">
            <option value="" selected disabled>Select Here</option>
            <?php
            $result = mysqli_query($conn, "SELECT * from tbl_remote_stationtype");
            while ($type = mysqli_fetch_array($result)) {
                echo '<option ' . ($data['station_type_id'] == $type['id'] ? 'selected' : '') . ' value="' . $type['id'] . '">' . $type['station_type'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-4 form-group">
        <label>Date Commissioned</label>
        <input class="form-control" type="date" name="operationStartDate" value="<?= $data['operation_date'] ?>">
    </div>
</div>
<div class="row">
    <div class="col-md-4 form-group">
        <label>Latitude</label>
        <input class="form-control" type="text" name="latitude" value="<?= $data['latitude'] ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Longitude</label>
        <input class="form-control" type="text" name="longitude" value="<?= $data['longitude'] ?>">
    </div>
    <div class="col-md-4 form-group">
        <label>Elevation</label>
        <input class="form-control" type="text" name="elevation" value="<?= $data['elevation'] ?>">
    </div>
</div>
<div class="row">
    <div class="col-md-12 form-group">
        <label>Remarks</label>
        <textarea class="form-control" name="remarks" rows="3" cols="30"><?= $data['remarks'] ?></textarea>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <label>Instruments</label>
    </div>
    <div id="edit-instruments" class="d-flex gap-2 flex-column">
        <?php
        $sql = "SELECT * FROM `tbl_station_coordinates_instrument` WHERE  `station_coordinate_id` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $data['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $first = true;
        while ($instrument = mysqli_fetch_array($result)) {
        ?>
            <div class="d-flex align-items-center gap-2">
                <textarea rows="2" class="form-control input" name="instruments[]"><?= $instrument['description'] ?></textarea>
                <button type=" button" <?= $first ? 'disabled' : '' ?> onclick="deleteItem(event)" class="btn btn-sm btn-danger"><i class="fas fa-trash pointer-events-none"></i></button>
                <button type="button" onclick="addItem(true)" class="btn btn-sm btn-primary"><i class="fas fa-plus pointer-events-none"></i></button>
            </div>
        <?php
            $first  = false;
        } ?>
    </div>
</div><br>
<div class="row mt-4">
    <div class="alert  shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;display: none" id="edit-alert">
    </div>
</div>