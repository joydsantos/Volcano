$(document).ready(function () {
  $("#inventoryTableID1").DataTable({
    order: [[0, "desc"]],
    language: {
      emptyTable: "No Records found",
    },
  });

  var categoryDropdown = $("#station_id");
  var catIdInput = $("#stationMainId");
  var stationCode = $("#cboMainStationCode");
  // Add an event listener to the category dropdown
  categoryDropdown.change(function () {
    // Get the selected option
    var selectedOption = categoryDropdown.find(":selected");
    // Update the hidden input field with the selected category's ID
    catIdInput.val(selectedOption.val());

    $.ajax({
      type: "POST",
      url: "process/fetch_station_code.php",
      data: { catId: catIdInput.val() },
      dataType: "json",
      success: function (response) {
        stationCode.empty();
        if (response.status === "Success") {
          // Check if response has the expected array
          if (response.response && Array.isArray(response.response)) {
            // Clear existing options
            stationCode.empty();

            // Add the default option
            stationCode.append(
              $("<option>", {
                value: "", // Empty value
                text: "Select here",
                disabled: true, // Disabled
                selected: true, // Selected by default
              })
            );

            // Populate combo box with new options
            $.each(response.response, function (index, item) {
              stationCode.append(
                $("<option>", {
                  value: item.code, // Set 'code' as the option value
                  "data-cat-id": item.code_id, // Set 'code_id' as the data-id attribute
                  text: item.code,
                })
              );
            });
          } else {
            console.error("Invalid response structure:", response);
          }
        } else {
          console.error("Error:", response);
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  });
});

function saveRecord(event) {
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
      var alertDiv = $(id ? "#update-alert" : "#add-alert");
      if (response) {
        alertDiv
          .text("Maintenance Report Successfully Saved")
          .addClass("alert-success")
          .show();
        form.reset();

        // $(".modal").modal("hide");
        if (id) {
          // dito ijquery mo yung row na may match ng id tapos repace mo
          $("#inventory-item-" + id).replaceWith(response);
          $(`#inventory-item-${id} .btnUpdate`).click();
        } else {
          $("#inventoryTableID1 tbody").append(response);
          console.log(response);
        }

        // window.location.reload();
      }
    },
    error: function (jxhr, status, error) {
      // Handle any errors that occur during the AJAX request
      // alertDiv.text("Something went wrong").removeClass().addClass("alert alert-danger").show();
      console.error("AJAX Error: " + error.message);
    },
  });
}

function editInventoryItem(id) {
  $.ajax({
    type: "GET",
    url: "edit/update.php?id=" + id,
    success: function (response) {
      $("#inventory-update-modal .remote-content").html(response);
      $("#inventory-update-modal").modal("show");
      let count = 0;
      $("#update_station_id").change(function () {
        var selectedOption = $(this).find("option:selected");
        $("#UpdatestationMainId").val(selectedOption.val());
        fetch_code();
      });

      $("#update_station_id").trigger("change");
    },
  });
}

function viewInventoryItem(id) {
  // #updateModal
  // ajax get request to the update url with id
  $.ajax({
    type: "GET",
    url: "view/index.php?id=" + id, // Replace with your PHP script URL
    success: function (response) {
      $("#inventory-view-modal .remote-content").replaceWith(response);
      $("#inventory-view-modal").modal("show");
    },
  });
}

function confitmDeleteItem(id) {
  $("#inventory-delete-modal").modal("show");
  $("#inventory-delete-modal input").val(id);
  $("#inventory-delete-modal .btn-delete").on("click", function (e) {
    $.ajax({
      type: "POST",
      data: { id },
      url: "process/delete.php",
      success: function (response) {
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
      },
    });
  });
}

document.addEventListener("DOMContentLoaded", function () {
  var categoryDropdown = document.getElementById("cboMainStationCode");
  var catIdInput = document.getElementById("stationMainCodeId");
  // Add an event listener to the category dropdown
  categoryDropdown.addEventListener("change", function () {
    // Get the selected option
    var selectedOption =
      categoryDropdown.options[categoryDropdown.selectedIndex];
    // Update the hidden input field with the selected category's ID
    catIdInput.value = selectedOption.getAttribute("data-cat-id");
  });
});

function fetch_code() {
  //populate update  station code
  var stationCode = $("#cboUpdateMainStationCode");
  $.ajax({
    type: "POST",
    url: "process/fetch_station_code.php",
    data: { catId: $("#UpdatestationMainId").val() },
    dataType: "json",
    success: function (response) {
      stationCode.empty();
      if (response.status === "Success") {
        // Check if response has the expected array
        if (response.response && Array.isArray(response.response)) {
          // Clear existing options
          stationCode.empty();

          // Add the default option
          stationCode.append(
            $("<option>", {
              value: "", // Empty value
              text: "Select here",
              disabled: true, // Disabled
              selected: true, // Selected by default
            })
          );

          // Populate combo box with new options
          $.each(response.response, function (index, item) {
            stationCode.append(
              $("<option>", {
                value: item.code_id, // Set 'code' as the option value
                "data-cat-id": item.code_id, // Set 'code_id' as the data-id attribute
                text: item.code,
              })
            );
          });
          if ($("#stationUpdateMainCodeId").val() != "") {
            $("#cboUpdateMainStationCode").val(
              $("#stationUpdateMainCodeId").val()
            );
            $("#stationUpdateMainCodeId").val("");
          }
        } else {
          console.error("Invalid response structure:", response);
        }
      } else {
        console.error("Error:", response);
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}
