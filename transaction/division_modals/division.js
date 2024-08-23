$(document).ready(function () {
  const baseURL = "/Volcano/vnd-admin-user/transaction/";
  let divisionId;
  var alertDiv = $("#DivisionAlert");
  $("#btnDivision").on("click", function (event) {
    $("#divisionModal").modal("show");
    $("#DivisionAlert").hide();
  });

  $("#cboManageDivision").on("change", function () {
    $("#manageDivision").val($(this).val());
    divisionId = $(this).find(":selected").data("cat-id");
  });

  //button click
  $("#divisionModal").on("click", "#btnUpdateDivision", function (event) {
    event.preventDefault();
    var $this = $(this);
    $this.attr("disabled", true); //avoid double click button

    var division = $("#manageDivision").val();
    //get the id of selected division
    if (checkAndUpdate()) {
      bootbox.confirm("Do you really want to update?", function (result) {
        if (result) {
          $.ajax({
            type: "POST",
            url: baseURL + "division_modals/updateDivision.php",
            data: { id: divisionId, division: division },
            success: function (response) {
              if (response == 1) {
                fetchDivision();
                $("#manageDivision").val("");
                //show message
                alertDiv
                  .text("Successfully Updated")
                  .removeClass()
                  .addClass("alert alert-success")
                  .show();
              } else if (response == 2) {
              } else if (response == "Invalid input") {
                alertDiv
                  .text("Invalid Input")
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              } else {
                alertDiv
                  .text("Something Went Wrong")
                  .removeClass()
                  .addClass("alert alert-danger")
                  .show();
              }
            },
            error: function (xhr, status, errorThrown) {},
          });
        } else {
          // User clicked 'Cancel' or closed the dialog.
          // Handle this case if needed.
        }
      });
    } else {
    }
    $this.attr("disabled", false);
  });

  $("#divisionModal").on("click", "#btnDeleteDivision", function (event) {
    event.preventDefault();
    var $this = $(this);
    $this.attr("disabled", true); //avoid double click button
    if (checkAndDel()) {
      bootbox.confirm(
        "Do you really want to delete division?",
        function (result) {
          if (result) {
            $.ajax({
              url: baseURL + "division_modals/deleteDivision.php",
              type: "POST",
              data: {
                id: divisionId,
              },
              success: function (response) {
                if (response == 1) {
                  fetchDivision();
                  $("#manageDivision").val("");
                  //show message
                  alertDiv
                    .text("Successfully Deleted")
                    .removeClass()
                    .addClass("alert alert-success")
                    .show();
                } else if (response == 2) {
                  alertDiv
                    .text("Division is currently in used")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                } else if (response == 3) {
                  alertDiv
                    .text("Division is currently in used")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                } else if (response == 4) {
                  alertDiv
                    .text("Error in deleting division")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                } else if (response == "Invalid input") {
                  alertDiv
                    .text("Invalid Input")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                } else {
                  // Handle other responses if needed
                  alertDiv
                    .text("Something went wrong")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                  console.log(response);
                }
              },
            });
          } else {
          }
        }
      );
    }
    $this.attr("disabled", false);
  });

  $("#divisionModal").on("click", "#btnAddDivision1", function (event) {
    event.preventDefault();
    var $this = $(this);
    $this.attr("disabled", true); //avoid double click button

    var division = $("#addDivision").val();
    console.log("D");

    if (checkAndAddDiv()) {
      console.log("fddd");
      bootbox.confirm(
        "Do you really want to add new division?",
        function (result) {
          if (result) {
            $.ajax({
              type: "POST",
              url: baseURL + "division_modals/addDivision.php",
              data: { division: division }, //new division name
              success: function (response) {
                if (response == 1) {
                  fetchDivision();
                  $("#addDivision").val("");
                  alertDiv
                    .text("Division successfully added")
                    .removeClass()
                    .addClass("alert alert-success")
                    .show();
                } else if (response == 2) {
                  alertDiv
                    .text("Division name already exist")
                    .removeClass()
                    .addClass("alert alert-warning")
                    .show();
                } else if (response == "Invalid input") {
                  alertDiv
                    .text("Invalid Input")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                } else {
                  alertDiv
                    .text("Something Went Wrong")
                    .removeClass()
                    .addClass("alert alert-danger")
                    .show();
                }
              },
              error: function (xhr, status, errorThrown) {},
              complete: function () {},
            });
          } else {
            // User clicked 'Cancel' or closed the dialog.
            // Handle this case if needed.
          }
        }
      );
    }
    $this.attr("disabled", false);
  });

  function checkAndUpdate() {
    var divName = $("#manageDivision");
    divName.removeClass("border-red");
    if (divName.val().trim() === "") {
      divName.addClass("border-red");
      return false;
    }
    return true;
  }

  function checkAndDel() {
    var divName = $("#cboManageDivision");
    divName.removeClass("border-red");
    var selectedValue = divName.val(); // Retrieve the selected value
    if (!selectedValue) {
      divName.addClass("border-red");
      return false;
    }
    return true;
  }

  function checkAndAddDiv() {
    var divName = $("#addDivision");
    divName.removeClass("border-red");
    if (divName.val().trim() === "") {
      divName.addClass("border-red");
      return false;
    }
    return true;
  }

  function fetchDivision() {
    $.ajax({
      type: "POST",
      url: baseURL + "division_modals/fetch_division.php",
      dataType: "json",
      success: function (response) {
        var comboBox = $("#cboManageDivision");
        comboBox.empty();

        if (response.status === "Success") {
          // Loop through each item in the response array
          $('<option value="" selected disabled>Select here</option>').appendTo(
            comboBox
          );
          response.response.forEach(function (item) {
            var option = $("<option>")
              .attr("value", item.division)
              .attr("data-cat-id", item.id)
              .text(item.division);
            comboBox.append(option);
          });
          //show message
        } else {
        }
      },
      error: function (xhr, status, error) {
        console.log(error);
        console.log(xhr, responseText);
      },
    });
  }
});
