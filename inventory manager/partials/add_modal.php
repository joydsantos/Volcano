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
                     <form method="POST" id="add-form" onsubmit="saveInventoryItem(event)" class="d-flex flex-column gap-2">
                         <div class="row">
                             <div class="col-md-4">
                                 <label>Type</label><span class="text-danger  font-weight-bold"> *</span>
                                 <select name="type_id" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Equipment Type--</option>
                                     <?php
                                        foreach ($all_types as $type_id) {
                                            echo '<option value="' . $type_id['id'] . '">' . $type_id['name'] . '</option>';
                                        } ?>
                                 </select>
                             </div>
                             <div class="col-md-4">
                                 <label>Name</label><span class="text-danger  font-weight-bold"> *</span>
                                 <input type="text" name="item_name" class="form-control shadow-sm" required>
                             </div>
                             <div class="col-md-4">
                                 <label>Brand/Model</label><span class="text-danger  font-weight-bold"> *</span>
                                 <input type="text" name="brand_model" class="form-control shadow-sm" required>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-4">
                                 <label>Serial/Property No.</label><span class="text-danger  font-weight-bold"> *</span>
                                 <input type="text" name="serial_no" class="form-control shadow-sm" required>
                             </div>
                             <div class="col-md-4">
                                 <label>Quantity</label><span class="text-danger  font-weight-bold"> *</span>
                                 <input type="number" name="quantity" class="form-control shadow-sm" required>
                             </div>
                             <div class="col-md-4">
                                 <label>Unit</label> <span class="text-danger  font-weight-bold"> *</span><br>
                                 <select name="unit" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Unit--</option>
                                     <?php
                                        while ($row = mysqli_fetch_array($unit_result)) {

                                            echo ' <option ' . ($data['unit'] == $row['measurement'] ? 'selected' : '') . ' value="' . $row['id'] . '">' . $row['measurement'] . '</option>';
                                        }
                                        ?>
                                 </select>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-4"><span class="text-danger  font-weight-bold"> *</span>
                                 <label>Acquisition Year</label><br>
                                 <input type="date" name="acquisition_year" class="form-control shadow-sm" required>
                             </div>
                             <div class="col-md-4">
                                 <label>Deployment</label>
                                 <input type="text" name="deployment" class="form-control shadow-sm">
                             </div>
                             <div class="col-md-4">
                                 <label>Condition</label><br>
                                 <select name="condition_id" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Condition--</option>
                                     <?php
                                        while ($row = mysqli_fetch_array($condition_result)) {

                                            echo ' <option  value="' . $row['id'] . '">' . $row['condition'] . '</option>';
                                        }
                                        ?>
                                 </select>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-4">
                                 <label>Endorsed By</label><span class="text-danger  font-weight-bold"> *</span>
                                 <select name="endorsed_by" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Endorser--</option>
                                     <?php
                                        foreach ($users as $user) {
                                            echo ' <option value="' . $user['id'] . '">' . $user['First_Name'] . ' ' . $user['Last_Name'] .  '</option>';
                                        }
                                        ?>
                                 </select>
                             </div>
                             <div class="col-md-4">
                                 <label>PAR</label><span class="text-danger  font-weight-bold"> *</span>
                                 <select name="par" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select PAR--</option>
                                     <?php
                                        foreach ($users as $user) {
                                            echo ' <option value="' . $user['id'] . '">' . $user['First_Name'] . ' ' . $user['Last_Name'] .  '</option>';
                                        }
                                        ?>
                                 </select>
                             </div>
                             <div class="col-md-4">
                                 <label>Observatory</label><span class="text-danger  font-weight-bold"> *</span>
                                 <select name="station_id" class="form-select shadow-sm" required>
                                     <option value="" selected disabled>--Select Observatory--</option>
                                     <?php
                                        while ($satation = mysqli_fetch_array($stations_result)) {
                                            echo ' <option value="' . $satation['id'] . '">' . $satation['Station'] . '</option>';
                                        }
                                        ?>
                                 </select>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="textarea">Action Taken</label>
                                 <textarea class="form-control shadow-sm" name="action_taken" id="ictEquipmentTextArea" rows="5"></textarea>
                             </div>

                         </div>
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="textarea">Remarks</label>
                                 <textarea class="form-control shadow-sm" name="remarks" id="ictEquipmentRemarks" rows="5"></textarea>
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