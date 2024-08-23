<div class="modal fade" id="UpdateNewTranModal" name="" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">Update Transaction</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <form method="POST" id="updatenewTran-form" enctype="multipart/form-data">
                        <div class="row ">

                            <div class="col-md-3">
                                <label>Transaction Number</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateTranNum" id="UpdateTranNum" class="form-control shadow-sm" placeholder="required" data-error="Required" disabled="disabled" style="color: black">
                            </div>

                            <div class="col-md-3">
                                <label>Stock Number</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateTranStockNum" id="UpdateTranStockNum" class="form-control shadow-sm" placeholder="required" data-error="Required" disabled="disabled" style="color: black">
                            </div>
                            <div class="col-md-4">
                                <label>Item Name</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" id="UpdateTranName" class="form-control shadow-sm" placeholder="required" required="required" style="color: black" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>Quantity</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="Number" name="UpdateTranQuantity" id="UpdateTranQuantity" class="form-control shadow-sm" placeholder="required" disabled="disabled" required="required" style="color: black">
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col-md-3">
                                <label>Transferred To</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateTran_transTo" id="UpdateTran_transTo" class="form-control shadow-sm" required="required">
                            </div>
                            <div class="col-md-3">
                                <label>Transferred From</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="UpdateTran_transFrom" id="UpdateTran_transFrom" class="form-control shadow-sm" required="required" style="color: black">
                            </div>
                            <div class="col-md-3">
                                <label>Equipment Status</label><span class="text-danger  font-weight-bold"> *</span>
                                <select id="cboTranEquipStatus" name="cboTranEquipStatus" class="form-select shadow-sm" required="required">
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
                            <div class="col-md-3">
                                <label>Division/Section Head</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="UpdatecboTranDivision" id="UpdatecboTranDivision" class="form-select shadow-sm" required="required">

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
                            </div><input type="hidden" name="UpdatedivisionTranId" id="UpdatedivisionTranId" class="form-control shadow-sm" value="">


                        </div>


                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label>Station Name</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="UpdatecboTranStation" id="UpdatecboTranStation" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select Here</option>
                                    <?php
                                    mysqli_data_seek($rs_result2, 0); // Reset the result set 
                                    # Loop through the result 
                                    while ($row1 = mysqli_fetch_assoc($rs_result2)) {
                                        $station = $row1['Station'];
                                        $staId = $row1['id'];
                                        echo "<option value='" . htmlspecialchars($station, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($staId, ENT_QUOTES) . "'>" . htmlspecialchars($station, ENT_QUOTES) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div><input type="hidden" name="UpdatestationTranId" id="UpdatestationTranId" class="form-control shadow-sm" value="">
                            <div class="col-md-2">
                                <label>Code</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="UpdatecboTranStationCode" id="UpdatecboTranStationCode" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select </option>
                                </select>
                            </div><input type="hidden" name="UpdatestationTranCodeId" id="UpdatestationTranCodeId" class="form-control shadow-sm" value="">


                            <div class="col-md-4">
                                <label>Land Owner</label>
                                <input type="text" name="UpdateTranlandOwner" id="UpdateTranlandOwner" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Care Taker</label>
                                <input type="text" name="UpdateTrancareTaker" id="UpdateTrancareTaker" class="form-control shadow-sm">
                            </div>
                        </div>

                        <div class="row mt-4">

                            <div class="col-md-4">
                                <label>Target Installation Date (Optional)</label>
                                <input type="date" name="UpdateTraninstallDate" id="UpdateTraninstallDate" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Date Acquired</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="UpdateTrandateAcquired" id="UpdateTrandateAcquired" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-4">
                                <label>Warranty Date (Optional)</label>
                                <input type="date" name="UpdateTranWarranty" id="UpdateTranWarranty" class="form-control" style="color: black">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label>Description</label>
                                <textarea id="UpdateTranDescription" class="form-control shadow-sm" name="UpdateTranDescription" rows="3" style="color: black;"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="form_message">Remarks</label>
                                <textarea id="UpdateTranRemarks" name="UpdateTranRemarks" class="form-control shadow-sm" rows="3"></textarea>
                            </div>

                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="formFile" class="form-label">Document Received by FAD-PPS (PDF ONLY)</label>
                                <input class="form-control shadow-sm" id="UpdateTranfileInput" type="file" name="UpdateTranuploadFile" accept="application/pdf" onchange="validateTranUpdateFile()">
                                <label id="UpdateTranfilenameLabel" class="input-group-text" style="font-size: 13px;  color: black;"></label>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <button id="btnUpdateTranSubmit" class="btn pt-2  btn-block shadow-sm" name="btnTranSubmit" style="background-color:#388E3C; color: white">Update
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn pt-2 btn-block shadow-sm" id="closeButton" data-bs-dismiss="modal" name="btnAdd" style="background-color:#0277BD; color: white">Close
                                </button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="UpdatenewActiveTranAlert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>