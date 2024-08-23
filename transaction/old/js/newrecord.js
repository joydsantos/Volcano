$(document).ready(function () {
  $("#newTranAlert").hide();
  $(".btnNew").on("click", function () {
    $("#addOldTranModal").modal("show");
  });

  $("#newrecord-form").submit(function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    var formData = new FormData(); // Create a FormData object
    formData.append("SerialNum", $("#SerialNum").val());
    formData.append("PropertyNum", $("#PropertyNum").val());
    formData.append("ItemName", $("#ItemName").val());
    formData.append("qty", $("#qty").val());
    formData.append("transFrom", $("#transFrom").val());
    formData.append("transTo", $("#transTo").val());
    formData.append("divisionId", $("#divisionId").val());
    formData.append("stationId", $("#stationId").val());
    formData.append("stationCodeId", $("#stationCodeId").val());
    formData.append("cboEquipStatus", $("#cboEquipStatus").val());
    formData.append("landOwner", $("#landOwner").val());
    formData.append("careTaker", $("#careTaker").val());
    formData.append("installDate", $("#installDate").val());
    formData.append("dateAcquired", $("#dateAcquired").val());
    formData.append("Remarks", $("#Remarks").val());

    // Add the file to FormData
    formData.append("uploadFile", $("#fileInput")[0].files[0]);

    $.ajax({
      type: "POST",
      url: "process/add_record.php",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        var alertDiv = $("#newTranAlert");

        if (response.status === "Success") {
          alertDiv
            .text("Record Successfully Added")
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
      error: function (jxhr, status, error) {
        console.log(error);
      },
    });
  });

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

  //search station code
  var searchcategoryDropdown = $("#cbosearchStation");
  var searchcatIdInput = $("#searchstationId");
  var searchstationCode = $("#cbosearchStationCode");

  // Add an event listener to the category dropdown
  searchcategoryDropdown.change(function () {
    // Get the selected option
    var selectedOption = searchcategoryDropdown.find(":selected");
    // Update the hidden input field with the selected category's ID
    searchcatIdInput.val(selectedOption.data("cat-id"));

    $.ajax({
      type: "POST",
      url: "process/fetch_station_code.php",
      data: { catId: searchcatIdInput.val() },
      dataType: "json",
      success: function (response) {
        searchstationCode.empty();
        if (response.status === "Success") {
          // Check if response has the expected array
          if (response.response && Array.isArray(response.response)) {
            // Clear existing options
            searchstationCode.empty();

            // Add the default option
            searchstationCode.append(
              $("<option>", {
                value: "", // Empty value
                text: "--Select Code--",
                disabled: true, // Disabled
                selected: true, // Selected by default
              })
            );
            searchstationCode.append(
              $("<option>", {
                value: "All Code", // Empty value
                text: "All Station Code",
                disabled: false,
                selected: false,
              })
            );

            // Populate combo box with new options
            $.each(response.response, function (index, item) {
              searchstationCode.append(
                $("<option>", {
                  value: item.code, // Set 'code' as the option value
                  "data-cat-id": item.code_id, // Set 'code_id' as the data-id attribute
                  text: item.code,
                })
              );
            });

            //check if  need lagyan selected statoin code
            if (
              $("#cbosearchStation").val() === "" ||
              $("#cbosearchStation").val() === null
            ) {
            } else {
              var storedValue = localStorage.getItem(
                "cbosearchStationCodeValue"
              );
              if (
                $('#cbosearchStationCode option[value="' + storedValue + '"]')
                  .length > 0
              ) {
                $("#cbosearchStationCode").val(storedValue);
              } else {
                // Handle the case when the value is not in the combo box options
              }
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
  });
  //store station code
  $("#cbosearchStationCode").change(function () {
    var selectedValue = $(this).val();

    // Save the value to local storage para kapag nag search the value will be same na mag shshow sa cbo
    //localStorage.removeItem('cbosearchStationCodeValue');
    localStorage.setItem("cbosearchStationCodeValue", selectedValue);
  });
});

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

function validateFile() {
  var fileInput = document.getElementById("fileInput");

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
function validateUpdateFile() {
  var fileInput = document.getElementById("updatefileInput");

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
