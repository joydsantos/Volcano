<?php
include '../../database/mydb.php';
session_start();

try {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * from `tbl_inventory` where id=?");
    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();
    if (!$result) {
        http_response_code(404);
        die();
    }
    $data = mysqli_fetch_assoc($result);

    $unit_result = mysqli_query($conn, "SELECT * FROM `tbl_unit_measurement`");
    $condition_result = mysqli_query($conn, "SELECT * FROM `tbl_inventory_condition`");
    $stations_result = mysqli_query($conn, "SELECT * FROM `tbl_station`");
    $user_result = mysqli_query($conn, "SELECT * FROM `tbl_par`");

    $users = $user_result->fetch_all(MYSQLI_ASSOC);

    $types_query = mysqli_query($conn, "SELECT * from tbl_inventory_types");
?>
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <div class="row">
        <div class="col-md-4">
            <label>Type</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <select name="type_id" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select Equipment Type--</option>
                <?php
                $selectedType = isset($_POST['inventory_type']) ? $_POST['inventory_type'] :  null;
                while ($type_id = mysqli_fetch_array($types_query)) {
                    echo '<option value="' . $type_id['id'] . '" ' . ($type_id['id'] == $data['type_id'] ? 'selected' : '') . ' >' . $type_id['name'] . '</option>';
                } ?>
                ?>

            </select>
        </div>
        <div class="col-md-4">
            <label>Name</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <input type="text" name="item_name" value="<?= $data['item_name'] ?>" class="form-control shadow-sm" required>
        </div>
        <div class="col-md-4">
            <label>Brand/Model</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <input type="text" name="brand_model" value="<?= $data['brand_model'] ?>" class="form-control shadow-sm" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label>Serial/Property No.</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <input type="text" name="serial_no" value="<?= $data['serial_no'] ?>" class="form-control shadow-sm" required>
        </div>
        <div class="col-md-4">
            <label>Quantity</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <input type="number" name="quantity" value="<?= $data['quantity'] ?>" class="form-control shadow-sm" required>
        </div>
        <div class="col-md-4">
            <label>Unit</label>
            <span class="text-danger  font-weight-bold"> *</span><br>
            <select name="unit" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select unit--</option>
                <?php
                while ($unit = mysqli_fetch_array($unit_result)) {

                    echo ' <option ' . ($data['unit_id'] == $unit['id'] ? 'selected' : '') . ' value="' . $unit['id'] . '">' . $unit['measurement'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label>Acquisition Year</label>
            <span class="text-danger  font-weight-bold"> *</span><br>
            <input type="date" name="acquisition_year" value="<?= $data['acquisition_year'] ?>" class="form-control shadow-sm" required>
        </div>
        <div class="col-md-4">
            <label>Deployment</label>
            <input type="text" name="deployment" value="<?= $data['deployment'] ?>" class="form-control shadow-sm">
        </div>
        <div class="col-md-4">
            <label>Condition</label>
            <span class="text-danger  font-weight-bold"> *</span><br>
            <select name="condition_id" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select condition--</option>
                <?php
                while ($condition = mysqli_fetch_array($condition_result)) {
                    echo ' <option ' . ($data['condition_id'] == $condition['id'] ? 'selected' : '') . '  value="' . $condition['id'] . '">' . $condition['condition'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label>Endorsed By</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <select name="endorsed_by" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select Endorser--</option>
                <?php
                foreach ($users as $user) {
                    echo ' <option ' . ($data['endorsed_by'] == $user['id'] ? 'selected' : '') . ' value="' . $user['id'] . '">' . $user['First_Name'] . ' ' . $user['Last_Name'] .  '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label>PAR</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <select name="par" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select PAR--</option>
                <?php
                foreach ($users as $user) {
                    echo ' <option ' . ($data['par'] == $user['id'] ? 'selected' : '') . ' value="' . $user['id'] . '">' . $user['First_Name'] . ' ' . $user['Last_Name'] .  '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label>Station</label>
            <span class="text-danger  font-weight-bold"> *</span>
            <select name="station_id" class="form-select shadow-sm" required>
                <option value="" selected disabled>--Select Station</option>
                <?php
                while ($satation = mysqli_fetch_array($stations_result)) {
                    echo ' <option ' . ($data['station_id'] == $satation['id'] ? 'selected' : '') . ' value="' . $satation['id'] . '">' . $satation['Station'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="textarea">Action Taken</label>
            <textarea name="action_taken" class="form-control shadow-sm" rows="5"><?= $data['action_taken'] ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="textarea">Remarks</label>
            <textarea name="remarks" class="form-control shadow-sm" rows="5"><?= $data['remarks'] ?></textarea>
        </div>
    </div>
<?php
} catch (Exception $e) {
    sendResponseWithError($e->getMessage());
}
