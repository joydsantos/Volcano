<?php
$user_result = mysqli_query($conn, "SELECT * FROM `tbl_admin`");
$users = $user_result->fetch_all(MYSQLI_ASSOC);
?>
<div class="modal fade" id="addModal" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">Station Coordinates Information</h5>
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
                        <div class="row ">
                            <div class="col-md-4">
                                <label>Observatory</label> <span class="text-danger  font-weight-bold"> *</span><br>
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
                                <select name="stationCode" disabled class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
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
                                        echo '<option value="' . $region['id'] . '">' . $region['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Province</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="provinceId" disabled class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Municipality</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="municipalityId" disabled class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                </select>
                            </div>
                        </div><br>
                        <div class="row ">
                            <div class="col-md-4">
                                <label>Barangay</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="barangayId" disabled class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Station Type</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="stationTypeId" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * from tbl_remote_stationtype");
                                    while ($type = mysqli_fetch_array($result)) {
                                        echo '<option value="' . $type['id'] . '">' . $type['station_type'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Date Commissioned</label>
                                <input class="form-control shadow-sm" type="date" name="operationStartDate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Latitude</label>
                                <input class="form-control shadow-sm" type="text" name="latitude">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Longitude</label>
                                <input class="form-control shadow-sm" type="text" name="longitude">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Elevation</label>
                                <input class="form-control shadow-sm" type="text" name="elevation">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks"></textarea>
                            </div>
                        </div>

                        <div class="row">
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
                        </div><br>


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
                            <div class="alert  shadow-sm  p-2 bg-body-tertiary rounded-1" role="alert" style="text-align: center;display: none" id="add-alert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>