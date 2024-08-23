$(document).ready(function () {
  $("#UpdateOldnewTranAlert").hide();
  let FetchstationCode, FetchStation, FetchFileName;

  $("#oldtrandatatable").on("click", ".update", function () {
    $("#updateOldTranModal").modal("show");
    var id = $(this).data("id");
    $.ajax({
      url: "process/fetch_transaction.php",
      method: "POST",
      data: { id: id },
      dataType: "json",
      success: function (data) {
        FetchstationCode = data.StationCode;
        FetchStation = data.StationName;
        FetchFileName = data.FileName;

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

    $("#updateOldTranModal").modal("show");
    $("#UpdateOldnewTranAlert").hide();
  });

  function updateFormFields(data) {
    $("#UpdateOldItemName").val(data.ItemName);
    $("#UpdateOldSerialNum").val(data.SerialNum);
    $("#UpdateOldPropertyNum").val(data.PropertyNum);
    $("#UpdateOldqty").val(data.qty);
    $("#UpdateOldtransFrom").val(data.TransFrom);
    $("#UpdateOldtransTo").val(data.TransTo);
    $("#UpdateOldcboStation").val(data.StationName);
    $("#UpdateCboDivision").val(data.Division);
    $("#UpdateOldcboEquipStatus").val(data.Eqstatus);
    $("#UpdateOldlandOwner").val(data.LandOwer);
    $("#UpdateOldcareTaker").val(data.careTaker);
    $("#UpdateOlddateAcquired").val(data.DateAcquired);
    $("#UpdateOldinstallDate").val(data.InstallationDate);
    $("#filenameLabel").text("Current File: " + data.FileName);
    $("#UpdateRemarks").val(data.remarks);
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
  $("#UpdateCboDivision").change(function () {
    updateDivisionID();
  });

  //division update
  function updateDivisionID() {
    var division = $("#UpdateCboDivision");
    var divIdInput = $("#divisionUpdateId");
    var selectedOption = division.find(":selected");
    divIdInput.val(selectedOption.data("cat-id"));
  }

  updateStationCodeOptions();

  $("#UpdateOldcboStation").change(function () {
    updateStationCodeOptions();
  });

  //update button
  $("#btnUpdateOld").on("click", function (event) {
    event.preventDefault();
    bootbox.confirm(
      "Do you really want to update the record?",
      function (result) {
        if (result) {
          var formData = new FormData();
          formData.append("SerialNum", $("#UpdateOldSerialNum").val());
          formData.append("PropertyNum", $("#UpdateOldPropertyNum").val());
          formData.append("ItemName", $("#UpdateOldItemName").val());
          formData.append("qty", $("#UpdateOldqty").val());
          formData.append("transFrom", $("#UpdateOldtransFrom").val());
          formData.append("transTo", $("#UpdateOldtransTo").val());
          formData.append("divisionId", $("#divisionUpdateId").val());
          formData.append("stationId", $("#UpdateOldstationId").val());
          formData.append("stationCodeId", $("#UpdateOldstationCodeId").val());
          formData.append(
            "cboEquipStatus",
            $("#UpdateOldcboEquipStatus").val()
          );
          formData.append("landOwner", $("#UpdateOldlandOwner").val());
          formData.append("careTaker", $("#UpdateOldcareTaker").val());
          formData.append("installDate", $("#UpdateOldinstallDate").val());
          formData.append("dateAcquired", $("#UpdateOlddateAcquired").val());
          formData.append("Remarks", $("#UpdateRemarks").val());
          formData.append("uploadFile", updatefileInput.files[0]);

          $.ajax({
            type: "POST",
            url: "process/update_record.php",
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
                $("#newrecord-form")[0].reset();
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
});
