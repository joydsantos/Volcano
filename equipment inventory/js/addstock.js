$(document).ready(function () {
  $("#stockAlert").hide();
  $("#updatestockAlert").hide();
  $("#stock-form").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();
    var formData = new FormData();
    var SerialNum = $("#SerialNum").val();
    var PropertyNum = $("#PropertyNum").val();
    var mac = $("#MAC").val();
    var ItemName = $("#ItemName").val();
    var Description = $("#Description").val();
    var qty = $("#qty").val();
    var qtyType = $("#cboQtyType").val();
    var dateReceived = $("#dateRecieved").val();
    var par = $("#par").val();
    var cboUnit = $("#cboUnit").val();
    var cboStatus = $("#cboStatus").val();
    var Remarks = $("#Remarks").val();
    var id = $("#catId").val();

    formData.append("SerialNum", SerialNum);
    formData.append("PropertyNum", PropertyNum);
    formData.append("mac", mac);
    formData.append("ItemName", ItemName);
    formData.append("description", Description);
    formData.append("qty", qty);
    formData.append("qtyType", qtyType);
    formData.append("dateReceived", dateReceived);
    formData.append("par", par);
    formData.append("cboUnit", cboUnit);
    formData.append("cboStatus", cboStatus);
    formData.append("Remarks", Remarks);
    formData.append("cat", id);

    // Append the file to the FormData object
    formData.append("uploadFile", $("#stockUploadFile")[0].files[0]);

    $.ajax({
      type: "POST",
      url: "process/addstock.php", // Replace with your PHP script URL
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json", // Expect JSON response
      success: function (response) {
        // Parse the JSON response from the server

        var alertDiv = $("#stockAlert"); // Reference to the alert div
        if (response.status === "Correct") {
          alertDiv
            .text("Stock Successfuly Added")
            .removeClass()
            .addClass("alert alert-success")
            .show();
          $("#stock-form")[0].reset();
        } else if (response.status === "date") {
          alertDiv
            .text("Invalid Date")
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
          console.log(response);
        }
      },
      error: function (jxhr, status, error) {
        // Handle any errors that occur during the AJAX request
        // alertDiv.text("Something went wrong").removeClass().addClass("alert alert-danger").show();
        console.error("AJAX Error: " + error.message);
        console.error(jxhr.responseText);
      },
    });
  });

  //update
  $("#updatestock-form").submit(function (event) {
    event.preventDefault();

    bootbox.confirm(
      "Do you really want to update the stock?",
      function (result) {
        if (result) {
          var updateFormData = new FormData();
          var updateSerialNum = $("#updateSerialNum").val();
          var updatePropertyNum = $("#updatePropertyNum").val();
          var updatemac = $("#updateMAC").val();
          var updateItemName = $("#updateItemName").val();
          var updateDescription = $("#updateDescription").val();
          var updateqty = $("#updateqty").val();
          var updateavqty = $("#updateavqty").val();
          var updateQtyType = $("#updatecboQtyType").val();
          var updatedateReceived = $("#updatedateRecieved").val();
          var updatepar = $("#updatepar").val();
          var updatecboUnit = $("#updatecboUnit")
            .find(":selected")
            .data("unit-id");
          var updatecboStatus = $("#updatecboStatus").val();
          var updateRemarks = $("#updateRemarks").val();
          var updateid = $("#updatecatId").val();

          // Append the file to the FormData object
          updateFormData.append(
            "uploadFile",
            $("#stockUpdateFile")[0].files[0]
          );

          // Append other form data fields to the FormData object
          updateFormData.append("SerialNum", updateSerialNum);
          updateFormData.append("PropertyNum", updatePropertyNum);
          updateFormData.append("mac", updatemac);
          updateFormData.append("ItemName", updateItemName);
          updateFormData.append("description", updateDescription);
          updateFormData.append("qty", updateqty);
          updateFormData.append("avqty", updateavqty);
          updateFormData.append("qtyType", updateQtyType);
          updateFormData.append("dateReceived", updatedateReceived);
          updateFormData.append("par", updatepar);
          updateFormData.append("cboUnit", updatecboUnit);
          updateFormData.append("cboStatus", updatecboStatus);
          updateFormData.append("Remarks", updateRemarks);
          updateFormData.append("cat", updateid);

          $.ajax({
            type: "POST",
            url: "process/updatestock.php", // Replace with your PHP script URL
            data: updateFormData,
            contentType: false,
            processData: false,
            dataType: "json", // Expect JSON response
            success: function (response) {
              // Parse the JSON response from the server

              var alertDiv = $("#updatestockAlert"); // Reference to the alert div
              if (response.status === "Correct") {
                alertDiv
                  .text("Stock Successfuly Updated")
                  .removeClass()
                  .addClass("alert alert-success")
                  .show();
                $("#updatestock-form")[0].reset();
              } else if (response.status === "qty") {
                alertDiv
                  .text("Invalid Qty")
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              } else if (response.status === "totalqty") {
                alertDiv
                  .text(
                    "Total Recieved must not be less than the total equipment transacted"
                  )
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              } else if (response.status === "date") {
                alertDiv
                  .text("Invalid Date")
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
              }
            },
            error: function (jxhr, status, error) {
              console.error("AJAX Error: " + error.message);
            },
          });
        }
      }
    );
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var categoryDropdown = document.getElementById("cboCategory");
  var catIdInput = document.getElementById("catId");

  // Add an event listener to the category dropdown
  categoryDropdown.addEventListener("change", function () {
    // Get the selected option
    var selectedOption =
      categoryDropdown.options[categoryDropdown.selectedIndex];
    // Update the hidden input field with the selected category's ID
    catIdInput.value = selectedOption.getAttribute("data-cat-id");
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var categoryDropdown = document.getElementById("updatecboCategory");
  var catIdInput = document.getElementById("updatecatId");

  // Add an event listener to the category dropdown
  categoryDropdown.addEventListener("change", function () {
    // Get the selected option
    var selectedOption =
      categoryDropdown.options[categoryDropdown.selectedIndex];
    // Update the hidden input field with the selected category's ID
    catIdInput.value = selectedOption.getAttribute("data-cat-id");
  });
});

//validate file upload
function validateStockFile() {
  var fileInput = document.getElementById("stockUploadFile");

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
function validateStockUpdateFile() {
  var fileInput = document.getElementById("stockUpdateFile");

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
