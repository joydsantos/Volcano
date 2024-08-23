function unitFunction() {
  var x = document.getElementById("cboUnit").value;
  document.getElementById("txtUpdateUnit").value = x;
}
$(document).ready(function () {
  function unitcheckAndAdd() {
    var unit_name = $("#txtNewUnit");
    // Remove any existing red border class
    unit_name.removeClass("border-red");
    // Check if the textbox is empty
    if (unit_name.val().trim() === "") {
      // Add the red border class if it's empty
      unit_name.addClass("border-red");
      return false; // Prevent form submission
    }
    return true; // Allow form submission if the textbox is not empty
  }
  function unitcheckAndUpdate() {
    var update_name = $("#txtUpdateUnit");
    // Remove any existing red border class
    update_name.removeClass("border-red");
    // Check if the textbox is empty
    if (update_name.val().trim() === "") {
      // Add the red border class if it's empty
      update_name.addClass("border-red");
      return false; // Prevent form submission
    }

    return true; // Allow form submission if the textbox is not empty
  }
  function unitcheckAndDelete() {
    var unit_name = $("#cboUnit");
    // Check if the textbox is empty
    if (!unit_name.val()) {
      // Add the red border class if it's empty
      unit_name.addClass("border-red");
      return false; // Prevent form submission
    }
    // Remove any existing red border class
    unit_name.removeClass("border-red");

    return true; // Allow form submission if the textbox is not empty
  }

  // add button click event
  $(".addUnit").click(function (event) {
    event.preventDefault();
    var unit = document.getElementById("txtNewUnit").value;
    if (unitcheckAndAdd()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to add new unit?", function (result) {
        if (result) {
          $.ajax({
            url: "addUnit.php",
            type: "POST",
            data: { unit: unit },
            success: function (response) {
              if (response == 1) {
                swal({
                  title: "Confirm",
                  text: "Successfully Added",
                  icon: "success",
                }).then((okay) => {
                  if (okay) {
                    window.location.href = "equipment.php";
                    // You don't need the 'exit' statement here
                  }
                });
              } else if (response == 2) {
                swal("Can not be Added", "Unit Already Exist");
              } else if (response == 4) {
                swal("Can not be Added", "Error in adding");
              } else if (response == "Invalid input") {
                swal("Can not be Added", "Symbols are not allowed");
              } else {
                // Handle other responses if needed
                swal("Can not be Added", "Something went wrong");
              }
            },
          });
        } else {
          // User clicked 'Cancel' or closed the dialog.
          // Handle this case if needed.
        }
      });
    }
  });
  // Form submission event
  $("new-unit-form").submit(function () {
    return unitcheckAndAdd();
  });

  //update button
  $(".updateUnit").click(function (event) {
    event.preventDefault();

    var updateid =
      document.getElementById(
        "cboUnit"
      ).value; /* value ng combobox na uupdate */
    var updateunit =
      document.getElementById("txtUpdateUnit").value; /* value ng textbox */
    if (unitcheckAndUpdate()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm(
        "Do you really want to update the unit?",
        function (result) {
          if (result) {
            $.ajax({
              url: "updateUnit.php",
              type: "POST",
              data: { unit: updateid, updatedUnit: updateunit },
              success: function (response) {
                if (response == 1) {
                  swal({
                    title: "Confirm",
                    text: "Sucessfully Updated",
                    icon: "success",
                  }).then((okay) => {
                    if (okay) {
                      window.location.href = "equipment.php";

                      exit;
                    }
                  });
                } else if (response == 2) {
                  //swal("Can not be updated", "Invalid");
                } else if (response == "Invalid input") {
                  swal("Can not be updated", "Invalid");
                } else {
                  swal("Can not be updated", "Something went wrong");
                }
              },
            });
          } else {
            // User clicked 'Cancel' or closed the dialog.
            // Handle this case if needed.
          }
        }
      );
    }
  });
  // Form submission event
  $("update-unit-form").submit(function () {
    return unitcheckAndUpdate();
  });

  // delete button click event
  $(".deleteUnit").click(function (event) {
    event.preventDefault();
    var delid =
      document.getElementById(
        "cboUnit"
      ).value; /* value ng combobox na dedelete */
    console.log(delid);
    if (unitcheckAndDelete()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to Delete?", function (result) {
        if (result) {
          $.ajax({
            url: "deleteUnit.php",
            type: "POST",
            data: { id: delid },
            success: function (response) {
              if (response == 1) {
                swal({
                  title: "Confirm",
                  text: "Successfully Deleted",
                  icon: "success",
                }).then((okay) => {
                  if (okay) {
                    window.location.href = "equipment.php";
                    // You don't need the 'exit' statement here
                  }
                });
              } else if (response == 2) {
                swal(
                  "Cannot be deleted",
                  "Selected unit are currently used in stocks"
                );
              } else if (response == 3) {
                swal(
                  "Cannot be deleted",
                  "Selected unit are currently used in hardware inventory"
                );
              } else if (response == 4) {
                swal("Cannot be deleted", "Error in deleting unit");
              } else {
                // Handle other responses if needed
                swal("Cannot be deleted", "Something went wrong");
              }
            },
          });
        } else {
          // User clicked 'Cancel' or closed the dialog.
          // Handle this case if needed.
        }
      });
    }
  });
});
