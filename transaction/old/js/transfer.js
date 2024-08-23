$(document).ready(function () {
  //data table records
  let trans_id = sessionStorage.getItem("trans_id");
  let trans_num = sessionStorage.getItem("trans_number");
  let ser_num = sessionStorage.getItem("serial_number");
  let FetchstationCode, FetchStation, upId;

  $("#newTranAlert").hide();
  $("#UpdateOldnewTranAlert").hide();
  //data table buttons
  $("#oldtranTransferHistoryDataTable").DataTable({
    order: [[0, "desc"]],
    language: {
      emptyTable: "No Transfer Record",
    },

    columnDefs: [
      {
        targets: -1, // Targeting the last column (Action column)
        render: function (data, type, row, meta) {
          // Constructing action buttons
          var buttonsContainer =
            '<td class="d-flex text-left">' +
            '<a class="update btn btn-warning btn-sm btnUpdate mr-2" id="' +
            row[6] +
            '" data-id="' +
            row[6] +
            '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>' +
            '<a class="btnView mr-2" id="' +
            row[6] +
            '" data-id="' +
            row[6] +
            '"><i class="fa fa-eye"></i></a>' +
            '<a href="#" class="delete btn btn-danger btn-sm btnTrash" id="del_' +
            row[6] +
            '" data-id="' +
            row[6] +
            '"><i class="fa fa-trash"></i></a>' +
            "</td>";

          return buttonsContainer;
        },
      },
    ],
  });

  if (trans_id) {
    // Use AJAX to send the ID to the server and process it
    $.ajax({
      url: "process/fetch_transfer.php",
      type: "POST",
      data: { id: trans_id },
      dataType: "json",
      success: function (response) {
        // Handle the response from the server
        $("#transTitle").html("Transaction Number: " + trans_num);
        $("#serialTitle").html("Serial Number: " + ser_num);
        if (response.status === "No Data") {
        } else {
          // Get DataTable instance
          var dataTable = $("#oldtranTransferHistoryDataTable").DataTable();
          dataTable.clear().draw();

          // Add new data to DataTable
          $.each(response, function (index, record) {
            dataTable.row
              .add([
                record.Transferred_From,
                record.Transferred_To,
                record.Date_Transferred,
                record.Station,
                record.division,
                record.Status,
                record.transfer_history_id,

                // Adding action buttons dynamically
              ])
              .draw();
          });
        }
      },
      error: function (xhr, status, errorThrown) {
        console.error(xhr.responseText);
      },
    });
  } else {
  }

  // data table button click
  $("#oldtranTransferHistoryDataTable").on("click", ".btnView", function () {
    // Get the data-id attribute value (row ID)
    var id = $(this).attr("data-id");
    $.ajax({
      url: "process/view_transfer.php",
      method: "POST",
      data: { id: id },
      success: function (result) {
        $(".viewOldTransfer").html(result);
        $("#OldTransferModal").modal("show");
      },
    });
  });

  $("#oldtranTransferHistoryDataTable").on("click", ".btnTrash", function () {
    // Get the data-id attribute value (row ID)
    var deleteid = $(this).attr("data-id");
    var el = this;
    // Confirm box
    bootbox.confirm("Do you really want to delete record?", function (result) {
      if (result) {
        // AJAX Request
        $.ajax({
          url: "process/delete_transfer.php",
          type: "POST",
          data: {
            id: deleteid,
          },
          dataType: "json",
          success: function (response) {
            // Removing row from HTML Table
            if (response.status == "success") {
              $(el).closest("tr").css("background", "tomato");
              $(el)
                .closest("tr")
                .fadeOut(800, function () {
                  $(this).remove();
                });
              swal({
                title: "Success!",
                text: "Record Successfully Deleted",
                icon: "success",
                button: "Continue",
              });
            } else {
              swal("Can not be deleted", "Something went wrong");
            }
          },
          error: function (xhr, status, errorThrown) {
            console.error(xhr.responseText);
          },
        });
      }
    });
  });

  $(document).on("click", "#btnAddTransferHistory", function () {
    // Get the data-id attribute value (row ID)
    $("#addOldTransRecord").modal("show");
    $("#UpdateOldnewTranAlert").hide();
    $("#newTranAlert").hide();
  });

  $("#newoldrecordtransfer-form").submit(function (event) {
    var alertDiv = $("#newTranAlert");

    // Prevent the default form submission behavior
    event.preventDefault();
    var formData = new FormData(); // Create a FormData object
    formData.append("old_id", trans_id);
    formData.append("SerialNum", $("#SerialNum").val());
    formData.append("transFrom", $("#transFrom").val());
    formData.append("transTo", $("#transTo").val());
    formData.append("divisionId", $("#divisionId").val());
    formData.append("stationId", $("#stationId").val());
    formData.append("stationCodeId", $("#stationCodeId").val());
    formData.append("cboEquipStatus", $("#cboEquipStatus").val());
    formData.append("installDate", $("#installDate").val());
    formData.append("dateAcquired", $("#dateAcquired").val());
    formData.append("Remarks", $("#Remarks").val());

    $.ajax({
      type: "POST",
      url: "process/add_transfer.php",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response.status === "Success") {
          alertDiv
            .text("Record Successfully Added")
            .removeClass()
            .addClass("alert alert-success")
            .show();
          $("#newoldrecordtransfer-form")[0].reset();
        } else if (response.status === "date") {
          alertDiv
            .text("Invalid Date")
            .removeClass()
            .addClass("alert alert-danger")
            .show();
        } else if (response.status === "File") {
          alertDiv
            .text("File Upload Failed")
            .removeClass()
            .addClass("alert alert-danger")
            .show();
        } else if (response.status === "Input") {
          alertDiv
            .text("Invalid Input")
            .removeClass()
            .addClass("alert alert-danger")
            .show();
        } else if (response.status === "Cat") {
          alertDiv
            .text("There is no equipment category")
            .removeClass()
            .addClass("alert alert-warning")
            .show();
        } else {
          alertDiv
            .text("Something went wrong")
            .removeClass()
            .addClass("alert alert-warning")
            .show();
          console.log(response);
        }
      },
      error: function (jxhr, status, error) {
        console.log(error);
      },
    });
  });

  $("#oldtranTransferHistoryDataTable").on("click", ".btnUpdate", function () {
    var id = $(this).data("id");
    upId = id;
    $.ajax({
      url: "process/fetch_transfer_for_updating.php",
      method: "POST",
      data: { id: id },
      dataType: "json",
      success: function (data) {
        FetchstationCode = data[0].code;
        FetchStation = data[0].Station;

        // Update the form fields with the fetched data
        updateFormFields(data);
        updateDivisionID();
        $("#UpdateOldcboStation").change(function () {
          var selectedOption = $(this).find("option:selected");
          var catId = selectedOption.data("cat-id");
          $("#UpdateOldstationId").val(catId);
        });

        $("#UpdateOldcboStation").trigger("change");
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });

    $("#updateOldTransRecord").modal("show");

    function updateFormFields(data) {
      $("#UpdateOldcboStation").val(data[0].Station);
      $("#UpdateCboDivision").val(data[0].division);
      $("#UpdateOldSerialNum").val(data[0].Serial_Number);
      $("#UpdateOldtransFrom").val(data[0].Transferred_From);
      $("#UpdateOldtransTo").val(data[0].Transferred_To);

      $("#UpdateOldcboEquipStatus").val(data[0].Status);
      $("#UpdateOlddateAcquired").val(data[0].Date_Transferred);

      console.log(data[0].Installation_Date);
      $("#UpdateOldinstallDate").val(data[0].Installation_Date);

      $("#UpdateRemarks").val(data[0].remarks);
    }

    function updateStationCodeOptions() {
      var categoryDropdown = $("#UpdateOldcboStation");
      var catIdInput = $("#UpdateOldstationId");
      var stationCode = $("#UpdateOldcboStationCode");
      var stationCodeID = $("#UpdateOldstationCodeId");
      var selectedOption = categoryDropdown.find(":selected");
      catIdInput.val(selectedOption.data("cat-id"));
      //console.log("val" + catIdInput.val());

      $.ajax({
        type: "POST",
        url: "process/fetch_station_code.php",
        data: { catId: catIdInput.val() },
        dataType: "json",
        success: function (response) {
          stationCode.empty();

          if (
            response.status === "Success" &&
            response.response &&
            Array.isArray(response.response)
          ) {
            stationCode.append(
              $("<option>", {
                value: "",
                text: "Select here",
                disabled: true,
                selected: true,
              })
            );

            $.each(response.response, function (index, item) {
              stationCode.append(
                $("<option>", {
                  value: item.code,
                  "data-cat-id": item.code_id,
                  text: item.code,
                })
              );
            });
          } else {
            console.error("Invalid or empty response structure:", response);
          }

          if ($("#UpdateOldcboStation").val() === FetchStation) {
            $("#UpdateOldcboStationCode").val(FetchstationCode);
            var updatestationCode = $("#UpdateOldcboStationCode");
            var updatestationCodeID = $("#UpdateOldstationCodeId");
            var selectedOption1 = updatestationCode.find(":selected");
            updatestationCodeID.val(selectedOption1.data("cat-id"));
          } else {
            $("#UpdateOldcboStationCode").change(function () {
              var selectedOption2 = $(this).find("option:selected");
              var catId2 = selectedOption2.data("cat-id");
              $("#UpdateOldstationCodeId").val(catId2);
            });

            $("#UpdateOldcboStationCode").trigger("change");
          }
        },
        error: function (error) {
          console.error("Error:", error.message);
        },
      });
    }

    $("#UpdateOldcboStation").change(function () {
      updateStationCodeOptions();
    });
    $("#UpdateCboDivision").change(function () {
      updateDivisionID();
    });

    function updateDivisionID() {
      var division = $("#UpdateCboDivision");
      var divIdInput = $("#divisionUpdateId");
      var selectedOption = division.find(":selected");
      divIdInput.val(selectedOption.data("cat-id"));
    }
  });

  $("#updateoldrecordtransfer-form").submit(function (event) {
    event.preventDefault();

    console.log($("#UpdateOldinstallDate").val());

    bootbox.confirm(
      "Do you really want to update the record?",

      function (result) {
        if (result) {
          var formData = new FormData();
          formData.append("upId", upId);
          formData.append("SerialNum", $("#UpdateOldSerialNum").val());
          formData.append("transFrom", $("#UpdateOldtransFrom").val());
          formData.append("transTo", $("#UpdateOldtransTo").val());
          formData.append("divisionId", $("#divisionUpdateId").val());
          formData.append("stationId", $("#UpdateOldstationId").val());
          formData.append("stationCodeId", $("#UpdateOldstationCodeId").val());
          formData.append(
            "cboEquipStatus",
            $("#UpdateOldcboEquipStatus").val()
          );
          formData.append("installDate", $("#UpdateOldinstallDate").val());
          formData.append("dateAcquired", $("#UpdateOlddateAcquired").val());
          formData.append("Remarks", $("#UpdateRemarks").val());

          $.ajax({
            type: "POST",
            url: "process/update_transfer.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
              var alertDiv = $("#UpdateOldnewTranAlert");

              if (response.status === "Success") {
                alertDiv
                  .text("Record Successfully Updated")
                  .removeClass()
                  .addClass("alert alert-success")
                  .show();
              } else if (response.status === "date") {
                alertDiv
                  .text("Invalid Date")
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              } else if (response.status === "File") {
                alertDiv
                  .text("File Upload Failed")
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              } else if (response.status === "Input") {
                alertDiv
                  .text("Invalid Input")
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              } else if (response.status === "Cat") {
                alertDiv
                  .text("There is no equipment category")
                  .removeClass()
                  .addClass("alert alert-warning")
                  .show();
              } else {
                alertDiv
                  .text("Something went wrong")
                  .removeClass()
                  .addClass("alert alert-warning")
                  .show();
              }
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            },
          });
        }
      }
    );
  });

  //add record station code
  var categoryDropdown = $("#cboStation");
  var catIdInput = $("#stationId");
  var stationCode = $("#cboStationCode");
  // Add an event listener to the category dropdown
  categoryDropdown.change(function () {
    // Get the selected option
    var selectedOption = categoryDropdown.find(":selected");
    // Update the hidden input field with the selected category's ID
    catIdInput.val(selectedOption.data("cat-id"));

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

//set hidden input for id when adding new record
document.addEventListener("DOMContentLoaded", function () {
  var categoryDropdown = document.getElementById("cboStationCode");
  var catIdInput = document.getElementById("stationCodeId");
  // Add an event listener to the category dropdown
  categoryDropdown.addEventListener("change", function () {
    // Get the selected option
    var selectedOption =
      categoryDropdown.options[categoryDropdown.selectedIndex];
    // Update the hidden input field with the selected category's ID
    catIdInput.value = selectedOption.getAttribute("data-cat-id");
  });

  document
    .getElementById("cboDivision")
    .addEventListener("change", function () {
      var selectedOption = this.options[this.selectedIndex];
      var divisionId = selectedOption.getAttribute("data-cat-id");
      document.getElementById("divisionId").value = divisionId;
    });
});
