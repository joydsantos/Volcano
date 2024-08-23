 <!-- add record -->
 <div class="modal fade" id="equipment-update-modal" aria-hidden="true">
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
                     <form method="POST" id="update-form" onsubmit="saveEquipmentItem(event)" class="d-flex flex-column gap-2">
                         <div class="remote-content d-flex flex-column gap-2">
                             <!-- edit form content will be added here -->
                         </div>
                         <div class=" d-flex justify-content-end gap-2">
                             <button type="button" class="btn btn-secondary data-bs-dismiss" data-bs-dismiss="modal">Close</button>
                             <button type="submit" class="btn  btn-primary">Update</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>