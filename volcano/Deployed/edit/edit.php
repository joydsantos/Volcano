<?php
include '../../../database/mydb.php';
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}

$id = intval($_GET['id']);

$selectSql = "SELECT * from tbl_deployed_equipment where id = ?";
$stmt = $conn->prepare($selectSql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$user_result = mysqli_query($conn, "SELECT * FROM `tbl_admin`");
$users = $user_result->fetch_all(MYSQLI_ASSOC);
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
            $station_code = mysqli_query($conn, $sql);
            while ($station = mysqli_fetch_array($station_code)) {
                echo ' <option ' . ($data['station_code_id'] == $station['code_id'] ? 'selected' : '') . ' value="' . $station['code_id'] . '">' . $station['code'] . '</option>';
            }
            ?>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <label>Instruments</label>

    </div>
    <div id="edit-instruments" class="d-flex gap-2 flex-column">
        <?php
        $sql = "SELECT * FROM `tbl_instruments` WHERE `equipment_id` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $data['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $first = true;
        $has_records = false;
        while ($instrument = mysqli_fetch_array($result)) {
            $has_records = true;
        ?>
            <div class="d-flex align-items-center gap-2">
                <textarea rows="2" class="form-control input" name="instruments[]"><?= htmlspecialchars($instrument['description'], ENT_QUOTES, 'UTF-8') ?></textarea>
                <button type="button" <?= $first ? 'disabled' : '' ?> onclick="deleteItem(event)" class="btn btn-sm btn-danger"><i class="fas fa-trash pointer-events-none"></i></button>
                <button type="button" onclick="addItem(true)" class="btn btn-sm btn-primary"><i class="fas fa-plus pointer-events-none"></i></button>
            </div>
        <?php
            $first = false;
        }
        if (!$has_records) {
        ?>
            <div class="d-flex align-items-center gap-2">
                <textarea rows="2" class="form-control input" name="instruments[]"></textarea>
                <button type="button" disabled onclick="deleteItem(event)" class="btn btn-sm btn-danger"><i class="fas fa-trash pointer-events-none"></i></button>
                <button type="button" onclick="addItem(true)" class="btn btn-sm btn-primary"><i class="fas fa-plus pointer-events-none"></i></button>
            </div>
        <?php
        }
        ?>
    </div>


</div>