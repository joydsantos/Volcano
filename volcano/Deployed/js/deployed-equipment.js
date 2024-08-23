$(document).ready(function () {
  initTable();
});

function initTable() {
  $("#equipmentTable").DataTable({
    order: [[0, "desc"]],
    language: {
      emptyTable: "No records found",
    },
  });
}
function onStationChanged(event) {
  var stationId = event.target.value;
  $.get("process/getStationCode.php?stationId=" + stationId, function (result) {
    $('select[name="stationCode"]').replaceWith(result);
  });
  $.get("process/getLocations.php?stationId=" + stationId, function (result) {
    $('select[name="locationId"]').replaceWith(result);
  });
}

function addItem(isEdit) {
  let template = $("#instrumentInput").contents()[1].cloneNode(true);
  let instruments = $(`#${isEdit ? "edit-" : "add-"}instruments`);

  console.log(template, instruments);

  instruments.append(template);
}

function deleteItem(event) {
  var item = $(event.target).parent("div");
  item.remove();
}

function saveEquipmentItem(event) {
  event.preventDefault();
  var form = event.target;
  let formData = new FormData(form);
  let id = formData.get("id");

  $.ajax({
    type: "POST",
    url: id ? "process/update.php" : "process/create.php",
    data: formData,
    contentType: false,
    processData: false,

    success: function (response) {
      if (response) {
        if (id) {
          $("#equipment-item-" + id).replaceWith(response);
          editEquipmentItem(id, function () {
            var alertDiv = $("#edit-alert");
            alertDiv
              .text("Equipment Item Updated Successfully")
              .addClass("alert-success")
              .show();
          });
        } else {
          var alertDiv = $("#add-alert");
          alertDiv
            .text("Equipment Item Successfully Saved")
            .addClass("alert-success")
            .show();
          $('#equipmentTable tr:has(".dataTables_empty")').remove();
          $("#equipmentTable tbody").append(response);

          form.reset();

          let instruments = $("#instruments");
          instruments.children(":not(:first-child)").each(function () {
            this.remove();
          });
        }
      }
    },
    error: function (jxhr, status, error) {
      // Handle any errors that occur during the AJAX request
      // alertDiv.text("Something went wrong").removeClass().addClass("alert alert-danger").show();
      console.error("AJAX Error: " + error.message);
    },
  });
}

function editEquipmentItem(id, cb) {
  $.ajax({
    type: "GET",
    url: "edit/edit.php?id=" + id,
    success: function (response) {
      $("#equipment-update-modal .remote-content").html(response);
      $("#equipment-update-modal").modal("show");
      if (cb) cb();
    },
  });
}

function viewEquipmentItem(id) {
  // #updateModal
  // ajax get request to the update url with id
  $.ajax({
    type: "GET",
    url: "view/view.php?id=" + id, // Replace with your PHP script URL
    success: function (response) {
      $("#equipment-view-modal .remote-content").replaceWith(response);
      $("#equipment-view-modal").modal("show");
    },
  });
}

function confirmDeleteItem(id) {
  $("#equipment-delete-modal").modal("show");
  $("#equipment-delete-modal input").val(id);
  $("#equipment-delete-modal .btn-delete").on("click", function (e) {
    $.ajax({
      type: "POST",
      data: { id },
      url: "process/delete.php",
      success: function (response) {
        $("#equipment-item-" + id).remove();
        $("#equipment-delete-modal").modal("hide");
        swal({
          title: "Success!",
          text: "Record Successfully Deleted",
          icon: "success",
          button: "Continue",
        });
      },
    });
  });
}
