$(document).ready(function () {
  $("#newTran-form").submit(function (event) {
    event.preventDefault();
    bootbox.confirm("Confirm Transaction?", function (result) {
      if (result) {
        var formData = new FormData();
        formData.append("NewTran_StockNum", $("#TranStockNum").val());
        formData.append("NewTran_Quantity", $("#TranQuantity").val());
        formData.append("NewTran_transFrom", $("#Tran_transFrom").val());
        formData.append("NewTran_transTo", $("#Tran_transTo").val());
        formData.append("NewTran_DivisionId", $("#divisionTranId").val());
        formData.append("New_stationId", $("#stationTranId").val());
        formData.append("New_stationCodeId", $("#stationTranCodeId").val());
        formData.append("NewTran_landOwner", $("#TranlandOwner").val());
        formData.append("NewTran_careTaker", $("#TrancareTaker").val());
        formData.append("NewTran_installDate", $("#TraninstallDate").val());
        formData.append("NewTran_dateAcquired", $("#TrandateAcquired").val());
        formData.append("NewTran_dateWarranty", $("#TranWarranty").val());
        formData.append("NewTran_Remarks", $("#TranRemarks").val());
        formData.append("NewTran_Description", $("#TranDescription").val());
        formData.append("NewTran_uploadFile", $("#TranfileInput")[0].files[0]);
        $.ajax({
          type: "POST",
          url: "process/add_new_transaction.php",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            var alertDiv = $("#newActiveTranAlert");

            if (response.status === "Success") {
              alertDiv
                .text("New Transaction Successfully Added")
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
            console.error(error);
            console.error(xhr.responseText);
          },
        });
      }
    });
  });
});
