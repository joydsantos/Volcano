<?php
include '../../database/mydb.php';
session_start();

try {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * from `tbl_reports` where id=?");
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();
    if (!$result) {
        http_response_code(404);
        die();
    }
    $data = mysqli_fetch_assoc($result);

    // $unit_result = mysqli_query($conn, "SELECT * FROM `tbl_unit_measurement`");
    $stations_result = mysqli_query($conn, "SELECT * FROM `tbl_station`");
    $status_result = mysqli_query($conn, "SELECT * FROM `tbl_maintenance_report_status`");
    $station_code_result = mysqli_query($conn, "SELECT * FROM `tbl_station_code`");
    // $user_result = mysqli_query($conn, "SELECT * FROM `tbl_admin`");

    // $users = $user_result->fetch_all(MYSQLI_ASSOC);

    // $types_query = mysqli_query($conn, "SELECT * from tbl_inventory_types");



?>

    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <div class="row">
        <div class="col-md-6">
            <label>Date</label>
            <span class="text-danger  font-weight-bold"> *</span><br>
            <input type="date" name="date" value="<?= $data['date'] ?>" class="form-control shadow-sm" required>
        </div>
        <div class="col-md-3">
            <label>Station</label>
            <span class="text-danger  font-weight-bold"> *</span><br>
            <select name="station_id" id="update_station_id" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select Station--</option>
                <?php

                while ($station = mysqli_fetch_array($stations_result)) {
                    echo ' <option ' . ($data['station'] == $station['id'] ? 'selected' : '') . ' value="' . $station['id'] . '">' . $station['Station'] . '</option>';
                }
                ?>
            </select>
        </div><input type="hidden" name="UpdatestationMainId" id="UpdatestationMainId" class="form-control shadow-sm" value="">
        <div class="col-md-3">
            <label>Code</label><span class="text-danger  font-weight-bold"> *</span><br>
            <select name="cboUpdateMainStationCode" id="cboUpdateMainStationCode" class="form-select shadow-sm" required="required">

                <option value="" selected disabled>Select </option>
            </select>
        </div><input type="hidden" name="stationUpdateMainCodeId" id="stationUpdateMainCodeId" class="form-control shadow-sm" value="<?php echo $data['station_code']; ?>">

    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="textarea">Problem</label>
            <textarea class="form-control shadow-sm" name="problem" id="problem" rows="5"><?= $data['problem'] ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="textarea">Action Taken</label>
            <textarea class="form-control shadow-sm" name="action_taken" id="action_taken" rows="5"><?= $data['action_taken'] ?></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>Status</label>
            <span class="text-danger  font-weight-bold"> *</span><br>
            <select name="status_id" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select Status--</option>
                <?php

                while ($status = mysqli_fetch_array($status_result)) {
                    echo ' <option ' . ($data['status'] == $status['id'] ? 'selected' : '') . ' value="' . $status['id'] . '">' . $status['status'] . '</option>';
                }
                ?>
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="input">Recommendation</label>
            <input class="form-control shadow-sm" value="<?= $data['recommendation'] ?>" name="recommendation" id="recommendation"></input>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="textarea">Remarks</label>
            <textarea class="form-control shadow-sm" name="remarks" id="remarks" rows="4"><?= $data['remarks'] ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="input">Field Party</label>
            <input class="form-control shadow-sm" value="<?= $data['field_party'] ?>" name="field_party" id="field_party"></input>
        </div>
        <div class="col-md-6">
            <label for="input">Photos</label>
            <input class="form-control shadow-sm" name="photos" value="<?= $data['photos'] ?>" id="photos"></input>
        </div>
    </div>
    </div>
<?php

} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
