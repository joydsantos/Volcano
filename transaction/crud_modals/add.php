<div class="modal fade" id="addNewTranModal" name="" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">New Transaction</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row ">
                        <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                    </div>
                </div>
                <div class="container-fluid mt-2">
                    <form method="POST" id="newTran-form" enctype="multipart/form-data">
                        <div class="row ">
                            <div class="col-md-3">
                                <label>Stock Number</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="TranStockNum" id="TranStockNum" class="form-control shadow-sm" required="required" data-error="Required" style="color: black">
                            </div>
                            <div class="col-md-3">
                                <label>Quantity</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="Number" name="TranQuantity" id="TranQuantity" class="form-control shadow-sm" required="required" style="color: black">
                            </div>

                            <div class="col-md-3">
                                <label>Transferred From</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="Tran_transFrom" id="Tran_transFrom" class="form-control shadow-sm" required="required" style="color: black">
                            </div>
                            <div class="col-md-3">
                                <label>Transferred To</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="text" name="Tran_transTo" id="Tran_transTo" class="form-control shadow-sm" required="required">
                            </div>

                        </div>

                        <div class="row mt-4">
                            <div class="col-md-3">
                                <label>Division/Section Head</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboTranDivision" id="cboTranDivision" class="form-select shadow-sm" required="required">

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
                            </div><input type="hidden" name="divisionTranId" id="divisionTranId" class="form-control shadow-sm" value="">
                            <div class="col-md-2">
                                <label>Station Name</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboTranStation" id="cboTranStation" class="form-select shadow-sm" required="required">
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
                            </div><input type="hidden" name="stationTranId" id="stationTranId" class="form-control shadow-sm" value="">
                            <div class="col-md-2">
                                <label>Code</label><span class="text-danger  font-weight-bold"> *</span><br>
                                <select name="cboTranStationCode" id="cboTranStationCode" class="form-select shadow-sm" required="required">

                                    <option value="" selected disabled>Select </option>
                                </select>
                            </div><input type="hidden" name="stationTranCodeId" id="stationTranCodeId" class="form-control shadow-sm" value="">


                            <div class="col-md-5">
                                <label>Land Owner</label>
                                <input type="text" name="TranlandOwner" id="TranlandOwner" class="form-control shadow-sm">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <label>Care Taker</label>
                                <input type="text" name="TrancareTaker" id="TrancareTaker" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-3">
                                <label>Target Installation Date (Optional)</label>
                                <input type="date" name="TraninstallDate" id="TraninstallDate" class="form-control shadow-sm">
                            </div>
                            <div class="col-md-3">
                                <label>Date Acquired</label><span class="text-danger  font-weight-bold"> *</span>
                                <input type="date" name="TrandateAcquired" id="TrandateAcquired" class="form-control shadow-sm" required="required" data-error="Required">
                            </div>
                            <div class="col-md-3">
                                <label>Warranty Date (Optional)</label>
                                <input type="date" name="TranWarranty" id="TranWarranty" class="form-control" style="color: black">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label>Description</label>
                                <textarea id="TranDescription" class="form-control shadow-sm" name="TranDescription" rows="3" style="color: black;"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="form_message">Remarks</label>
                                <textarea id="TranRemarks" name="TranRemarks" class="form-control shadow-sm" rows="3"></textarea>
                            </div>

                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label for="formFile" class="form-label">Document Received by FAD-PPS (PDF ONLY)</label>
                                <input class="form-control shadow-sm" id="TranfileInput" type="file" name="TranuploadFile" accept="application/pdf" onchange="validateFile()">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <button id="btnTranSubmit" class="btn pt-2  btn-block shadow-sm" name="btnTranSubmit" style="background-color:#388E3C; color: white">Submit
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn pt-2 btn-block shadow-sm" id="closeButton" data-bs-dismiss="modal" name="btnAdd" style="background-color:#0277BD; color: white">Close
                                </button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="newActiveTranAlert">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>