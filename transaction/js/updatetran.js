$(document).ready(function () {
  $("#UpdatenewActiveTranAlert").hide();
  var FetchUpdateTran_stationCode, FetchUpdateTran_Station;
  $("#datatableid").on("click", ".btnUpdate", function () {
    $("#UpdateNewTranModal").modal("show");

    var id = $(this).data("id");
    $.ajax({
      url: "process/fetch_new_transaction.php",
      method: "POST",
      data: { id: id },
      dataType: "json",
      success: function (data) {
        FetchUpdateTran_stationCode = data.FetchStationCode;
        FetchUpdateTran_Station = data.FetchStationName;
        FetchUpdateTran_FileName = data.FetchFileName;

        // Update the form fields with the fetched data
        newTranUpdateFormFields(data);
        updateTranDivisionID();
        $("#UpdatecboTranStation").change(function () {
          var selectedOption = $(this).find("option:selected");
          var catId = selectedOption.data("cat-id");
          $("#UpdatestationTranId").val(catId);
        });

        $("#UpdatecboTranStation").trigger("change");
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });

    $("#UpdateNewTranModal").modal("show");
    $("#UpdatenewActiveTranAlert").hide();
  });

  function newTranUpdateFormFields(data) {
    $("#UpdateTranNum").val(data.FetchTranNum);
    $("#UpdateTranStockNum").val(data.FetchStockNumber);
    $("#UpdateOldSerialNum").val(data.FetchSerialNum);
    $("#UpdateTranName").val(data.FetchItemName);
    $("#UpdateTranQuantity").val(data.Fetchqty);
    $("#UpdateTran_transFrom").val(data.FetchTransFrom);
    $("#UpdateTran_transTo").val(data.FetchTransTo);
    $("#UpdatecboTranDivision").val(data.FetchDivision);
    $("#UpdatecboTranStation").val(data.FetchStationName);
    $("#cboTranEquipStatus").val(data.FetchEqstatus);
    $("#UpdateTranlandOwner").val(data.FetchLandOwer);
    $("#UpdateTrancareTaker").val(data.FetchcareTaker);
    $("#UpdateTrandateAcquired").val(data.FetchDateAcquired);
    $("#UpdateTraninstallDate").val(data.FetchInstallationDate);
    $("#UpdateTranWarranty").val(data.FetchWarrantyDate);
    $("#UpdateTranfilenameLabel").text("Current File: " + data.FetchFileName);
    $("#UpdateTranRemarks").val(data.Fetchremarks);
    $("#UpdateTranDescription").val(data.FetchDescription);
  }

  function newTranUpdateStationCodeOptions() {
    var categoryDropdown1 = $("#UpdatecboTranStation");
    var catIdInput1 = $("#UpdatestationTranId");
    var stationCode1 = $("#UpdatecboTranStationCode");
    var stationCodeID1 = $("#UpdatestationTranCodeId");
    var selectedOption1 = categoryDropdown1.find(":selected");
    catIdInput1.val(selectedOption1.data("cat-id"));

    $.ajax({
      type: "POST",
      url: "process/fetch_station_code.php",
      data: { catId: catIdInput1.val() },
      dataType: "json",
      success: function (response) {
        stationCode1.empty();

        if (
          response.status === "Success" &&
          response.response &&
          Array.isArray(response.response)
        ) {
          stationCode1.append(
            $("<option>", {
              value: "",
              text: "Select here",
              disabled: true,
              selected: true,
            })
          );

          $.each(response.response, function (index, item) {
            stationCode1.append(
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

        if ($("#UpdatecboTranStation").val() === FetchUpdateTran_Station) {
          $("#UpdatecboTranStationCode").val(FetchUpdateTran_stationCode);
          var updatestationCode = $("#UpdatecboTranStationCode");
          var updatestationCodeID = $("#UpdatestationTranCodeId");
          var selectedOption1 = updatestationCode.find(":selected");
          updatestationCodeID.val(selectedOption1.data("cat-id"));
        } else {
          $("#UpdatecboTranStationCode").change(function () {
            var selectedOption2 = $(this).find("option:selected");
            var catId2 = selectedOption2.data("cat-id");
            $("#UpdatestationTranCodeId").val(catId2);
          });

          $("#UpdatecboTranStationCode").trigger("change");
        }
      },
      error: function (error) {
        console.error("Error:", error.message);
      },
    });
  }

  //division update
  function updateTranDivisionID() {
    var division = $("#UpdatecboTranDivision");
    var divIdInput = $("#UpdatedivisionTranId");
    var selectedOption = division.find(":selected");
    divIdInput.val(selectedOption.data("cat-id"));
  }

  newTranUpdateStationCodeOptions();
  $("#UpdatecboTranStation").change(function () {
    newTranUpdateStationCodeOptions();
  });

  //update button
  $("#updatenewTran-form").submit(function (event) {
    event.preventDefault();
    bootbox.confirm(
      "Do you really want to update the transaction?",
      function (result) {
        if (result) {
          var formData = new FormData();

          formData.append("UpdateTran_qty", $("#UpdateTranQuantity").val());
          formData.append(
            "UpdateTran_cboEquipStatus",
            $("#cboTranEquipStatus").val()
          );

          formData.append(
            "UpdateTran_transFrom",
            $("#UpdateTran_transFrom").val()
          );
          formData.append("UpdateTran_transTo", $("#UpdateTran_transTo").val());
          formData.append(
            "UpdateTran_Division",
            $("#UpdatedivisionTranId").val()
          );

          formData.append(
            "UpdateTran_stationId",
            $("#UpdatestationTranId").val()
          );
          formData.append(
            "UpdateTran_stationCodeId",
            $("#UpdatestationTranCodeId").val()
          );

          formData.append(
            "UpdateTran_landOwner",
            $("#UpdateTranlandOwner").val()
          );
          formData.append(
            "UpdateTran_careTaker",
            $("#UpdateTrancareTaker").val()
          );
          formData.append(
            "UpdateTran_installDate",
            $("#UpdateTraninstallDate").val()
          );
          formData.append(
            "UpdateTran_dateAcquired",
            $("#UpdateTrandateAcquired").val()
          );
          formData.append(
            "UpdateTran_warrantDate",
            $("#UpdateTranWarranty").val()
          );

          formData.append("UpdateTran_Remarks", $("#UpdateTranRemarks").val());
          formData.append(
            "UpdateTran_Description",
            $("#UpdateTranDescription").val()
          );
          formData.append(
            "UpdateTran_uploadFile",
            $("#UpdateTranfileInput")[0].files[0]
          );

          $.ajax({
            type: "POST",
            url: "process/update_tran_record.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
              var alertDiv = $("#UpdatenewActiveTranAlert");
              if (response.status === "Success") {
                alertDiv
                  .text("Transaction Successfully Updated")
                  .removeClass()
                  .addClass("alert alert-success")
                  .show();
                $("#newTran-form")[0].reset();
              } else {
                alertDiv
                  .text(response.message)
                  .removeClass()
                  .addClass("alert alert-danger")
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

function validateTranUpdateFile() {
  var fileInput = document.getElementById("UpdateTranfileInput");

  // Check if any file is selected
  if (fileInput.files.length === 0) {
    alert("Please choose a file.");
    return;
  }

  var fileType = fileInput.files[0].type;

  // Check if the file is a valid PDF
  if (fileType.toLowerCase() !== "application/pdf") {
    alert("Please choose a valid PDF file.");
    fileInput.value = "";
  }
}
