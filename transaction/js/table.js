$(document).ready(function () {
  $("#newActiveTranAlert").hide();
  $("#datatableid").DataTable({
    language: {
      emptyTable: "No records found",
    },
  });
  $("#datatableid").on("click", ".btnView", function () {
    stockid = $(this).attr("id");
    //console.log( stockid);
    $.ajax({
      url: "process/view.php",
      method: "POST",
      data: { stockid: stockid },
      success: function (result) {
        $("#view-modal-body").html(result);
      },
    });
    $("#viewModal").modal("show");
  });

  $(".btnNewTran").click(function () {
    $("#newTran-form")[0].reset();
    $("#newActiveTranAlert").hide();
    $("#addNewTranModal").modal("show");
  });
});

$(document).ready(function () {
  var categoryDropdown = $("#cboTranStation");
  var catIdInput = $("#stationTranId");
  var stationCode = $("#cboTranStationCode");

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

  //searching
  //search station code
  var searchActivecategoryDropdown = $("#cbosearchActiveStation");
  var searchActivecatIdInput = $("#searchstationActiveId");
  var searchActivestationCode = $("#cbosearchActiveStationCode");

  // Add an event listener to the category dropdown
  searchActivecategoryDropdown.change(function () {
    // Get the selected option
    var selectedOption = searchActivecategoryDropdown.find(":selected");
    // Update the hidden input field with the selected category's ID
    searchActivecatIdInput.val(selectedOption.data("cat-id"));

    $.ajax({
      type: "POST",
      url: "process/fetch_station_code.php",
      data: { catId: searchActivecatIdInput.val() },
      dataType: "json",
      success: function (response) {
        searchActivestationCode.empty();
        if (response.status === "Success") {
          // Check if response has the expected array
          if (response.response && Array.isArray(response.response)) {
            // Clear existing options
            searchActivestationCode.empty();

            // Add the default option
            searchActivestationCode.append(
              $("<option>", {
                value: "", // Empty value
                text: "Code",
                disabled: true, // Disabled
                selected: true, // Selected by default
              })
            );
            searchActivestationCode.append(
              $("<option>", {
                value: "All Code", // Empty value
                text: "All Station Code",
                disabled: false,
                selected: false,
              })
            );

            // Populate combo box with new options
            $.each(response.response, function (index, item) {
              searchActivestationCode.append(
                $("<option>", {
                  value: item.code, // Set 'code' as the option value
                  "data-cat-id": item.code_id, // Set 'code_id' as the data-id attribute
                  text: item.code,
                })
              );
            });

            //check if  need lagyan selected statoin code
            if (
              $("#cbosearchActiveStation").val() === "" ||
              $("#cbosearchActiveStation").val() === null
            ) {
            } else {
              var storedValue = localStorage.getItem(
                "cbosearchStationCodeValue1"
              );
              if (
                $(
                  '#cbosearchActiveStationCode option[value="' +
                    storedValue +
                    '"]'
                ).length > 0
              ) {
                $("#cbosearchActiveStationCode").val(storedValue);
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

  $("#cbosearchActiveStation").change();
  //store station code
  $("#cbosearchActiveStationCode").change(function () {
    var selectedValue = $(this).val();

    // Save the value to local storage para kapag nag search the value will be same na mag shshow sa cbo
    //localStorage.removeItem('cbosearchStationCodeValue');
    localStorage.setItem("cbosearchStationCodeValue1", selectedValue);
  });

  $("#newTranallDate").change(function () {
    if ($(this).is(":checked")) {
      // Checkbox is checked
      $("#newTrandateFrom").prop("disabled", true);
      $("#newTrandateTo").prop("disabled", true);
    } else {
      // Checkbox is unchecked
      $("#newTrandateFrom").prop("disabled", false);
      $("#newTrandateTo").prop("disabled", false);
    }
  });

  // Trigger the change event on form load
  $("#newTranallDate").change();
});

document.addEventListener("DOMContentLoaded", function () {
  var categoryDropdown = document.getElementById("cboTranStationCode");
  var catIdInput = document.getElementById("stationTranCodeId");
  // Add an event listener to the category dropdown
  categoryDropdown.addEventListener("change", function () {
    // Get the selected option
    var selectedOption =
      categoryDropdown.options[categoryDropdown.selectedIndex];
    // Update the hidden input field with the selected category's ID
    catIdInput.value = selectedOption.getAttribute("data-cat-id");
  });

  //triggers in adding
  document
    .getElementById("cboTranDivision")
    .addEventListener("change", function () {
      var selectedOption = this.options[this.selectedIndex];
      var divisionId = selectedOption.getAttribute("data-cat-id");
      document.getElementById("divisionTranId").value = divisionId;
    });

  //triggers in update
  document
    .getElementById("UpdatecboTranDivision")
    .addEventListener("change", function () {
      var selectedOption = this.options[this.selectedIndex];
      var divisionId = selectedOption.getAttribute("data-cat-id");
      document.getElementById("UpdatedivisionTranId").value = divisionId;
    });
});

function toggleCheckbox(isChecked) {
  if (isChecked) {
    $('input[id="chck"]').each(function () {
      this.checked = true;
    });
  } else {
    $('input[id="chck"]').each(function () {
      this.checked = false;
    });
  }
}

function toggleCheckbox1(isChecked) {
  if (isChecked) {
  } else {
    $('input[id="chckAll"]').each(function () {
      this.checked = false;
    });
  }
}
function validateFile() {
  var fileInput = document.getElementById("TranfileInput");

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

/*
$(document).on("click", ".btnNewTransfer", function () {
  //  id
  var transNum = $(this).attr("id").replace("trans_", "");
  var dataid = $(this).data("id");

  console.log(transNum);
  console.log(dataid);
  sessionStorage.setItem("trans_id", dataid);
  sessionStorage.setItem("trans_number", transNum);
  window.open("transfer.php", "_blank");
});
*/
