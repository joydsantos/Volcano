 <!-- add record -->
 <div class="modal fade" id="inventory-update-modal" aria-hidden="true">
     <div class="modal-dialog  modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <div class="container">
                     <h5 class="modal-title">UPDATE RECORD</h5>
                 </div>
             </div>
             <div class="modal-body stockBody">
                 <div class="container">
                     <div class="row ">
                         <label class="font-weight-bold ">Fields marked <span class="text-danger  font-weight-bold"> *</span> are required.</label>
                     </div>
                 </div>
                 <div class="container-fluid mt-2">
                     <form method="POST" id="update-form" onsubmit="saveInventoryItem(event)" class="d-flex flex-column gap-2">
                         <div class="remote-content d-flex flex-column gap-2">
                             <!-- edit form content will be added here -->
                         </div>
                         <div class="row mt-4">
                             <div class="col-md-8"></div>
                             <div class="col-md-2">
                                 <button type="submit" class="btn  pt-2  btn-block shadow-sm" style="background-color:#388E3C; color: white">Update</button>
                             </div>
                             <div class="col-md-2">
                                 <button type="button" class="btn pt-2  btn-block shadow-sm" data-dismiss="modal" style="background-color:#0277BD; color: white">Close</button>
                             </div>
                         </div>
                         <div class="row mt-4">
                             <div class="col-md-12">
                                 <div class="alert  shadow-sm  p-2  bg-body-tertiary rounded-1" role="alert" style="text-align: center;display: none" id="update-alert">
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>