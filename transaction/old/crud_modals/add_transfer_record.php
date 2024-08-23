<div class="modal fade" id="addOldTransRecord" name="" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">New Transfer Record</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>

                <div class="container-fluid mt-2">

                    <form method="POST" id="newoldrecordtransfer-form" enctype="multipart/form-data">
                        <div class="row ">
                            <div class="col-md-4">
                                <label>Serial Number</label>
                                <input type="text" name="serialnum" id="SerialNum" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Transferred From</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="transFrom" id="transFrom" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-4">
                                <label>Transferred To</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="transTo" id="transTo" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col-md-4">
                                <label>Division/Section Head</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboDivision" id="cboDivision" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    # Loop through the result 
                                    mysqli_data_seek($result3, 0);
                                    while ($row1 = mysqli_fetch_assoc($result3)) {
                                        $division = $row1['division'];
                                        $division_id = $row1['id'];
                                        echo "<option value='" . htmlspecialchars($division, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($division_id, ENT_QUOTES) . "'>" . htmlspecialchars($division, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div><input type="hidden" name="divisionId" id="divisionId" class="form-control shadow-sm" value="">
                            <div class="col-md-4">
                                <label>Station Name</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboStation" id="cboStation" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    # Loop through the result 
                                    mysqli_data_seek($result1, 0);
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        $station = $row1['Station'];
                                        $staId = $row1['id'];
                                        echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($staId, ENT_QUOTES) . "'>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div><input type="hidden" name="stationId" id="stationId" class="form-control shadow-sm" value="">

                            <div class="col-md-4">
                                <label>Code</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboStationCode" id="cboStationCode" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select </option>
                                </select>
                            </div><input type="hidden" name="stationCodeId" id="stationCodeId" class="form-control shadow-sm" value="">

                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Equipment Status</label><span class="text-danger  font-weight-bold"> *</span>
                                <select id="cboEquipStatus" name="cboEquipStatus" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>--Select Here--</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Missing">Missing</option>
                                    <option value="Ongoing Repair">Ongoing Repair</option>
                                    <option value="Serviceable">Serviceable</option>
                                    <option value="Pulled Out">Pulled Out</option>
                                    <option value="For Disposal">For Disposal</option>
                                    <option value="Unrepairable">Unrepairable</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Target Installation Date </label>
                                <input type="date" name="installDate" id="installDate" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Date Acquired</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="dateAcquired" id="dateAcquired" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="form_message">Remarks</label>
                                <textarea id="Remarks" name="Remarks" class="form-control shadow-sm" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <button id="btnAddOldTransHistory" class="btn pt-2  btn-block shadow-sm" name="btnAdd" style="background-color:#388E3C; color: white">Add Record
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn pt-2 btn-block shadow-sm" id="closeButton" data-dismiss="modal" name="btnAdd" style="background-color:#0277BD; color: white">Close
                                </button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="newTranAlert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>