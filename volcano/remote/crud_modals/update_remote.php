<div class="modal fade" id="updateModal" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">UPDATE RECORD</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <form method="POST" id="update-remote-form">
                        <div class="row ">
                            <div class="col-md-3">
                                <label>Volcano Station</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updatecboStation" name="updatecboStation" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    mysqli_data_seek($rs_result2, 0);
                                    while ($stationrow = mysqli_fetch_assoc($rs_result2)) {
                                        $station = $stationrow['Station'];
                                        $stationId = $stationrow['id'];
                                        $selected = isset($_POST['updatecboStation']) && $_POST['updatecboStation'] === $station ? 'selected' : '';

                                        echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($stationId, ENT_QUOTES) . "'>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Station Name</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="updatestationName" id="updatestationName" class="form-control shadow-sm" value="" required="required">
                            </div>
                            <div class="col-md-3">
                                <label>Category</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updatecboStationType" name="updatecboStationType" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    mysqli_data_seek($rs_result3, 0); // Reset the result set
                                    # Loop through the result
                                    while ($row1 = mysqli_fetch_assoc($rs_result3)) {
                                        $station = $row1['station_type'];
                                        $staId = $row1['id'];
                                        echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($staId, ENT_QUOTES) . "'>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Station Type</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updatecboStationCategory" name="updatecboStationCategory" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                </select>
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Latitude</label>
                                <input type="text" name="updateLatitude" id="updateLatitude" class="form-control shadow-sm" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Longitude</label>
                                <input type="text" name="updateLongitude" id="updateLongitude" class="form-control shadow-sm" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Elevation</label>
                                <input type="Number" name="updateElevation" id="updateElevation" class="form-control shadow-sm" value="">
                            </div>

                        </div><br>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Instrument</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="updateInstrument" id="updateInstrument" class="form-control shadow-sm" value="" required="required">
                            </div>
                            <div class="col-md-4">
                                <label>Date Started </label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="updatedateStarted" id="updatedateStarted" class="form-control shadow-sm" value="" required="required">
                            </div>
                            <div class="col-md-4">
                                <label>Date Destroyed</label>
                                <input type="date" name="updatedateDestroyed" id="updatedateDestroyed" class="form-control shadow-sm" value="">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Street Address</label>
                                <input type="text" name="updateAdrress" id="updateAddress" class="form-control shadow-sm" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Region</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updateregionSelect" name="updateregionSelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Province</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updateprovinceSelect" name="updateprovinceSelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Municipality</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updatemunicipalitySelect" name="updatemunicipalitySelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Barangay</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="updatebarangaySelect" name="updatebarangaySelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Remarks</label>
                                <input type="text" name="updateRemarks" id="updateRemarks" class="form-control shadow-sm" value="">
                            </div>
                        </div><br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <button id="btnUpdateRecord" class="btn  pt-2 btn-block shadow-sm" name="btnUpdateRecord" style="background-color:#388E3C; color: white">Update
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn  pt-2 btn-block shadow-sm" id="btnUpdateClose" data-dismiss="modal" name="btnUpdateClose" style="background-color:#0277BD; color: white">Close
                                </button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="updateremoteAlert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>