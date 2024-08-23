$(document).ready(function () {
  initTable();
});

function initTable() {
  $("#stationCoordinatesTable").DataTable({
    order: [[0, "desc"]],
    language: {
      emptyTable: "No records found",
    },
  });
}

function addItem(isEdit) {
  let template = $("#instrumentInput").contents()[1].cloneNode(true);
  let instruments = $(`#${isEdit ? "edit-" : "add-"}instruments`);
  console.log(template, instruments);
  instruments.append(template);
}

function deleteItem(event) {
  console.log(event);
  var item = $(event.target).parent("div");
  item.remove();
  var alertDiv = $("#edit-alert");
  alertDiv
    .text("Station Coordinate Successfully Deleted")
    .addClass("alert-success")
    .show();
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

function onRegionChanged(event) {
  var regionId = event.target.value;

  $.get("process/getProvinces.php?regionId=" + regionId, function (result) {
    $('select[name="provinceId"]').replaceWith(result);
  });
}

function onProvinceChanged(event) {
  var provinceId = event.target.value;

  $.get(
    "process/getMunicipalities.php?provinceId=" + provinceId,
    function (result) {
      $('select[name="municipalityId"]').replaceWith(result);
    }
  );
}

function onMunicipalityChanged(event) {
  var municipalityId = event.target.value;

  $.get(
    "process/getBarangays.php?municipalityId=" + municipalityId,
    function (result) {
      $('select[name="barangayId"]').replaceWith(result);
    }
  );
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
          $('#stationCoordinatesTable tr:has(".dataTables_empty")').remove();
          $("#stationCoordinatesTable tbody").append(response);
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
    url: "edit/index.php?id=" + id,
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
    url: "view/index.php?id=" + id, // Replace with your PHP script URL
    success: function (response) {
      $("#coordinate-view-modal .remote-content").replaceWith(response);
      $("#coordinate-view-modal").modal("show");
    },
  });
}

function confirmDeleteItem(id) {
  $("#coordinate-delete-modal").modal("show");
  $("#coordinate-delete-modal input").val(id);
  $("#coordinate-delete-modal .btn-delete").on("click", function (e) {
    $.ajax({
      type: "POST",
      data: { id },
      url: "process/delete.php",
      success: function (response) {
        $("#equipment-item-" + id).remove();
        $("#coordinate-delete-modal").modal("hide");
        if ($("#stationCoordinatesTable tbody tr").length === 0) {
          $("#inventory-delete-modal").modal("hide");
          swal({
            title: "Success!",
            text: "Record Successfully Deleted",
            icon: "success",
            button: "Continue",
          }).then((value) => {
            if (value) {
              location.reload();
            }
          });
        }
      },
    });
  });
}
