<div class="modal fade" id="addOldTranModal" name="" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">New Record</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <form method="POST" id="newrecord-form" enctype="multipart/form-data">
                        <div class="row ">
                            <div class="col-md-4">
                                <label>Item Name</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="itemname" id="ItemName" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-3">
                                <label>Serial Number</label>
                                <input type="text" name="serialnum" id="SerialNum" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-3">
                                <label>Property Number</label>
                                <input type="text" name="propnum" id="PropertyNum" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="Number" name="qty" id="qty" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col-md-4">
                                <label>Transferred From</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="transFrom" id="transFrom" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-4">
                                <label>Transferred To</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="transTo" id="transTo" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>

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
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <label>Code</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboStationCode" id="cboStationCode" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select </option>
                                </select>
                            </div><input type="hidden" name="stationCodeId" id="stationCodeId" class="form-control shadow-sm" value="">

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
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Land Owner</label>
                                <input type="text" name="landOwner" id="landOwner" class="form-control shadow-sm">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label>Care Taker</label>
                                <input type="text" name="careTaker" id="careTaker" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Target Installation Date</label>
                                <input type="date" name="installDate" id="installDate" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Date Acquired</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="dateAcquired" id="dateAcquired" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="form_message">Remarks</label>
                                <textarea id="Remarks" name="Remarks" class="form-control shadow-sm" placeholder="Optional" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label for="formFile" class="form-label">Document Received by FAD-PPS (PDF
                                    ONLY)</label><span class="text-danger  font-weight-bold"> *</span>
                                <input class="form-control shadow-sm" id="fileInput" type="file" name="uploadFile" accept="application/pdf" required="required" onchange="validateFile()">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <button id="btnSubmitStock" class="btn pt-2  btn-block shadow-sm" name="btnAdd" style="background-color:#388E3C; color: white">Add Record
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