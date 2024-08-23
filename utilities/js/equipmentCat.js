function myFunction() {
  var x = document.getElementById("selectCategory").value;
  document.getElementById("category").value = x;
}
$(document).ready(function () {
  // Function to check and add red border

  function checkAndUpdate() {
    var category_name = $("#category");
    // Remove any existing red border class
    category_name.removeClass("border-red");
    // Check if the textbox is empty
    if (category_name.val().trim() === "") {
      // Add the red border class if it's empty
      category_name.addClass("border-red");
      return false; // Prevent form submission
    }

    return true; // Allow form submission if the textbox is not empty
  }
  // Update button click event
  $(".update").click(function (event) {
    event.preventDefault();

    var updateid =
      document.getElementById(
        "selectCategory"
      ).value; /* value ng combobox na uupdate */
    var updatecate =
      document.getElementById("category").value; /* value ng textbox */
    if (checkAndUpdate()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to update?", function (result) {
        if (result) {
          $.ajax({
            url: "updateCategory.php?Upid=" + updatecate,
            type: "POST",
            data: { id: updateid, Upid: updatecate },
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
              } else if (response == "Invalid input") {
                swal("Can not be updated", "Invalid");
              } else {
                swal("Can not be updated", "Something went wrong");
                console.log(response);
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
  $("cat-form").submit(function () {
    return checkAndUpdate();
  });

  // Function to check and add red border
  function checkAndDelete() {
    var category_name = $("#selectCategory");
    // Check if the textbox is empty
    if (!category_name.val()) {
      // Add the red border class if it's empty
      category_name.addClass("border-red");
      return false; // Prevent form submission
    }
    // Remove any existing red border class
    category_name.removeClass("border-red");

    return true; // Allow form submission if the textbox is not empty
  }
  // delete button click event
  $(".delete").click(function (event) {
    event.preventDefault();
    var delid =
      document.getElementById(
        "selectCategory"
      ).value; /* value ng combobox na dedelete */
    if (checkAndDelete()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to Delete?", function (result) {
        if (result) {
          $.ajax({
            url: "deleteCategory.php",
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
                swal("Can not be deleted", "There is a record in stocks");
              } else if (response == 4) {
                swal("Can not be deleted", "Error in deleting category");
              } else {
                // Handle other responses if needed
                swal("Can not be deleted", "Something went wrong");
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
  $("#selectCategory").on("change", function () {
    checkAndDelete();
  });
  // Form submission event
  $("cat-form").on("submit", function () {
    return checkAndDelete();
  });
  // Function to check and add red border
  function checkAndAdd() {
    var category_name = $("#txtCat");

    // Remove any existing red border class
    category_name.removeClass("border-red");

    // Check if the textbox is empty
    if (category_name.val().trim() === "") {
      // Add the red border class if it's empty
      category_name.addClass("border-red");
      return false; // Prevent form submission
    }

    return true; // Allow form submission if the textbox is not empty
  }
  // Update button click event
  $(".add").click(function (event) {
    event.preventDefault();
    var addid =
      document.getElementById(
        "txtCat"
      ).value; /* value ng combobox na dedelete */
    if (checkAndAdd()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to add?", function (result) {
        if (result) {
          $.ajax({
            url: "addCategory.php",
            type: "POST",
            data: { id: addid },
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
                swal("Can not be Added", "Category Already Exist");
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
  $("cat-form").submit(function () {
    return checkAndAdd();
  });
});
$(document).ready(function () {
  $("ul li a").click(function () {
    $("ul li.active").removeClass("active");
    $(this).closest("li").addClass("active");
  });
});
function hideshow(elementId) {
  var div = document.getElementById("UnitSection");
  var div1 = document.getElementById("CatSection");
  var element = document.getElementById(elementId);
  if (elementId === "UnitSection") {
    div.style.display = "block";
    div1.style.display = "none";
  } else if (elementId === "CatSection") {
    div.style.display = "none";
    div1.style.display = "block";
  } else {
  }
}
