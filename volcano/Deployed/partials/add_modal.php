<?php
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == "auth") {
} else {
    session_destroy();
    header("Location: ../../../index.php");
}
?>
<div class="modal fade" id="addModal" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">ADD RECORD</h5>
                </div>
            </div>
            <div class="modal-body stockBody">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <form method="POST" onsubmit="saveEquipmentItem(event)">
                        <div class="row">
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
                                <select name="locationId" disabled class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>

                                </select>

                            </div>
                            <div class="col-md-4">
                                <label>Station Code</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="stationCode" disabled class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Instruments</label>
                            </div>
                            <div id="add-instruments" class="d-flex gap-2 flex-column">
                                <div class="d-flex align-items-center gap-2">
                                    <textarea rows="2" class="form-control input shadow-sm" name="instruments[]"></textarea>
                                    <button type=" button" onclick="deleteItem(event)" disabled class="btn btn-sm btn-danger"><i class="fas fa-trash pointer-events-none"></i></button>
                                    <button type="button" onclick="addItem()" class="btn btn-sm btn-primary"><i class="fas fa-plus pointer-events-none"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-2">
                                <button type="submit" class="btn  pt-2  btn-block shadow-sm" style="background-color:#388E3C; color: white">Add</button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn pt-2  btn-block shadow-sm" data-dismiss="modal" style="background-color:#0277BD; color: white">Close</button>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="alert  shadow-sm  p-2  bg-body-tertiary rounded-1" role="alert" style="text-align: center;display: none" id="add-alert">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>