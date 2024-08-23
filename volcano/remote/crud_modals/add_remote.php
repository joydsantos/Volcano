<div class="modal fade" id="addModal" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">Remote Station Information</h5>
                </div>
            </div>
            <div class="modal-body stockBody">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <form method="POST" id="add-form">
                        <div class="row ">
                            <div class="col-md-3">
                                <label>Volcano Station</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="cboStation" name="cboStation" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    mysqli_data_seek($rs_result2, 0);
                                    while ($stationrow = mysqli_fetch_assoc($rs_result2)) {
                                        $station = $stationrow['Station'];
                                        $stationId = $stationrow['id'];
                                        $selected = isset($_POST['cboStation']) && $_POST['cboStation'] === $station ? 'selected' : '';
                                        ///echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' $selected>$station</option>";
                                        echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($stationId, ENT_QUOTES) . "'>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Station Name</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="stationName" id="stationName" class="form-control shadow-sm" value="" required="required">
                            </div>
                            <div class="col-md-3">
                                <label>Category</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="cboStationType" name="cboStationType" class="form-select shadow-sm" required="required">
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
                                <label>Station</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="cboStationCategory" name="cboStationCategory" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>Select Here</option>
                                </select>
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Latitude</label>
                                <input type="text" name="Latitude" id="Latitude" class="form-control shadow-sm" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Longitude</label>
                                <input type="text" name="Longitude" id="Longitude" class="form-control shadow-sm" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Elevation</label>
                                <input type="Number" name="Elevation" id="Elevation" class="form-control shadow-sm" value="">
                            </div>

                        </div><br>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Instrument</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="Instrument" id="Instrument" class="form-control shadow-sm" value="" required="required">
                            </div>
                            <div class="col-md-4">
                                <label>Date Started </label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="dateStarted" id="dateStarted" class="form-control shadow-sm" value="" required="required">
                            </div>
                            <div class="col-md-4">
                                <label>Date Destroyed</label>
                                <input type="date" name="dateDestroyed" id="dateDestroyed" class="form-control shadow-sm" value="">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Street Address</label>
                                <input type="text" name="Adrress" id="Address" class="form-control shadow-sm" value="">
                            </div>
                            <div class="col-md-4">
                                <label>Region</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="regionSelect" name="regionSelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Province</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="provinceSelect" name="provinceSelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Municipality</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="municipalitySelect" name="municipalitySelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Barangay</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select id="barangaySelect" name="barangaySelect" class="form-select shadow-sm" required="required">
                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Remarks</label>
                                <input type="text" name="Remarks" id="Remarks" class="form-control shadow-sm" value="" placeholder="optional">
                            </div>
                        </div><br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <button id="btnAddRecord" class="btn  pt-2 btn-block shadow-sm" name="btnAddRecord" style="background-color:#388E3C; color: white">Add
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn  pt-2 btn-block shadow-sm" id="btnClose" data-dismiss="modal" name="btnClose" style="background-color:#0277BD; color: white">Close
                                </button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="remoteAlert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>