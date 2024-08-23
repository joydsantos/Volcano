 <!-- add record -->
 <div class="modal fade" id="inventory-add-modal" aria-hidden="true">
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
                     <form method="POST" id="add-form" onsubmit="saveRecord(event)" class="d-flex flex-column gap-2">
                         <div class="row">
                             <div class="col-md-6">
                                 <label>Date</label><span class="text-danger  font-weight-bold"> *</span><br>
                                 <input type="date" name="date" class="form-control shadow-sm" required>
                             </div>
                             <div class="col-md-3">
                                 <label>Station</label><span class="text-danger  font-weight-bold"> *</span><br>
                                 <select name="station_id" id="station_id" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Station--</option>
                                     <?php
                                        $sql = "SELECT * from tbl_station";
                                        $stations_result = mysqli_query($conn, $sql);
                                        while ($station = mysqli_fetch_array($stations_result)) {
                                            echo '<option value="' . $station['id'] . '">' . htmlspecialchars($station['Station'], ENT_QUOTES, 'UTF-8') . '</option>';
                                        }
                                        ?>
                                 </select>
                             </div><input type="hidden" name="stationMainId" id="stationMainId" class="form-control shadow-sm" value="">
                             <div class="col-md-3">
                                 <label>Code</label><span class="text-danger  font-weight-bold"> *</span><br>
                                 <select name="cboMainStationCode" id="cboMainStationCode" class="form-select shadow-sm" required="required">

                                     <option value="" selected disabled>Select here</option>
                                 </select>
                             </div><input type="hidden" name="stationMainCodeId" id="stationMainCodeId" class="form-control shadow-sm" value="">

                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="textarea">Problem</label>
                                 <textarea class="form-control shadow-sm" name="problem" id="problem" rows="5"></textarea>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="textarea">Action Taken</label>
                                 <textarea class="form-control shadow-sm" name="action_taken" id="action_taken" rows="5"></textarea>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-md-6">
                                 <label>Status</label><span class="text-danger  font-weight-bold"> *</span><br>
                                 <select name="status_id" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Status--</option>
                                     <?php
                                        $sql = "SELECT * from tbl_maintenance_report_status";
                                        $status_result = mysqli_query($conn, $sql);
                                        while ($status = mysqli_fetch_array($status_result)) {
                                            echo ' <option ' . ($data['status_id'] == $status['id'] ? 'selected' : '') . ' value="' . $status['id'] . '">' . $status['status'] . '</option>';
                                        }
                                        ?>
                                     ?>
                                 </select>
                             </div>
                             <div class="col-md-6">
                                 <label for="input">Recommendation</label>
                                 <input class="form-control shadow-sm" name="recommendation" id="recommendation"></input>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="textarea">Remarks</label>
                                 <textarea class="form-control shadow-sm" name="remarks" id="remarks" rows="4"></textarea>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <label for="input">Field Party</label>
                                 <input class="form-control shadow-sm" name="field_party" id="field_party"></input>
                             </div>
                             <div class="col-md-6">
                                 <label for="input">Photos</label>
                                 <input class="form-control shadow-sm" name="photos" id="photos"></input>
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
                     <div class="alert  shadow-sm  p-2 bg-body-tertiary rounded-1" role="alert" style="text-align: center;display: none" id="add-alert">
                     </div>
                 </div>

                 </form>
             </div>
         </div>
     </div>
 </div>
 </div>