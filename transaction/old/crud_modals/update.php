<div class="modal fade" id="updateOldTranModal" name="" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">Update Original Record</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>

                <div class="container-fluid mt-2">
                    <form method="POST" id="updaterecord-form" enctype="multipart/form-data">
                        <div class="row ">
                            <div class="col-md-4">
                                <label>Item Name</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateOlditemname" id="UpdateOldItemName" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-3">
                                <label>Serial Number</label>

                                <input type="text" name="UpdateOldserialnum" id="UpdateOldSerialNum" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-3">
                                <label>Property Number</label>
                                <input type="text" name="UpdateOldpropnum" id="UpdateOldPropertyNum" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="Number" name="UpdateOldqty" id="UpdateOldqty" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col-md-4">
                                <label>Transferred From</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateOldtransFrom" id="UpdateOldtransFrom" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-4">
                                <label>Transferred To</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateOldtransTo" id="UpdateOldtransTo" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-4">
                                <label>Division/Section Head</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="UpdateCboDivision" id="UpdateCboDivision" class="form-select shadow-sm" required="required">

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
                            </div><input type="hidden" name="divisionUpdateId" id="divisionUpdateId" class="form-control shadow-sm" value="">
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label>Station Name</label>
                                <span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="UpdateOldcboStation" id="UpdateOldcboStation" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    mysqli_data_seek($result1, 0); // Reset the result set 
                                    # Loop through the result 
                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                        $station = $row1['Station'];
                                        $staId = $row1['id'];
                                        echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($staId, ENT_QUOTES) . "'>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div><input type="hidden" name="UpdateOldstationId" id="UpdateOldstationId" class="form-control shadow-sm" value="">
                            <div class="col-md-2">
                                <label>Code</label><br>
                                <select name="UpdateOldcboStationCode" id="UpdateOldcboStationCode" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select </option>
                                </select>
                            </div><input type="hidden" name="UpdateOldstationCodeId" id="UpdateOldstationCodeId" class="form-control shadow-sm" value="">

                            <div class="col-md-4">
                                <label>Equipment Status</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <select id="UpdateOldcboEquipStatus" name="UpdateOldcboEquipStatus" class="form-select shadow-sm" required="required">
                                    <option value="" selected disabled>--Select Here--</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Missing">Missing</option>
                                    <option value="Ongoing Repair">Ongoing Repair</option>
                                    <option value="Serviceable">Serviceable</option>
                                    <option value="Pulled Out">Pulled Out</option>
                                    <option value="For Disposal">For Disposal</option>
                                    <option value="Unrepairable">Unrepairable</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Land Owner</label>
                                <input type="text" name="UpdateOldlandOwner" id="UpdateOldlandOwner" class="form-control shadow-sm">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Care Taker</label>
                                <input type="text" name="UpdateOldcareTaker" id="UpdateOldcareTaker" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Target Installation Date</label>
                                <input type="date" name="UpdateOldinstallDate" id="UpdateOldinstallDate" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Date Acquired</label>
                                <span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="UpdateOlddateAcquired" id="UpdateOlddateAcquired" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="form_message">Remarks</label>
                                <textarea id="UpdateRemarks" name="UpdateRemarks" class="form-control shadow-sm" placeholder="Optional" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="formFile" class="form-label">Document Received by FAD-PPS (PDF
                                    ONLY)</label>
                                <input class="form-control shadow-sm" id="updatefileInput" type="file" name="updatefileInput" accept="application/pdf" onchange="validateUpdateFile()">
                                <label id="filenameLabel" class="input-group-text" style="font-size: 13px;  color: black;"></label>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-7"></div>
                            <div class="col-md-3">
                                <button type="submit" id="btnUpdateOld" class="btn pt-2  btn-block shadow-sm" name="btnUpdateOld" style="background-color:#388E3C; color: white">Update Record
                                </button>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn pt-2 btn-block shadow-sm" id="closeButton" data-dismiss="modal" name="btnAdd" style="background-color:#0277BD; color: white">Close
                                </button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="UpdateOldnewTranAlert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>