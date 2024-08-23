$(document).ready(function () {
  $("#inventoryTableID").DataTable({
    language: {
      emptyTable: "No records found",
    },
  });
});

function saveInventoryItem(event) {
  event.preventDefault();

  var form = event.target;

  let formData = new FormData(form);

  let id = formData.get("id");

  $.ajax({
    type: "POST",
    url: id ? "process/update.php" : "process/create.php",
    data: formData,
    contentType: false,
    processData: false,

    success: function (response) {
      var alertDiv = $(id ? "#update-alert" : "#add-alert");
      if (response) {
        alertDiv
          .text("Inventory Item Successfully Saved")
          .addClass("alert-success")
          .show();
        form.reset();

        // $(".modal").modal("hide");
        if (id) {
          // dito ijquery mo yung row na may match ng id tapos repace mo
          $("#inventory-item-" + id).replaceWith(response);
        } else {
          $("#inventoryTableID tbody").append(response);
        }

        // window.location.reload();
      }
    },
    error: function (jxhr, status, error) {
      // Handle any errors that occur during the AJAX request
      // alertDiv.text("Something went wrong").removeClass().addClass("alert alert-danger").show();
      console.error("AJAX Error: " + error.message);
    },
  });
}

function editInventoryItem(id) {
  $.ajax({
    type: "GET",
    url: "edit/edit.php?id=" + id,
    success: function (response) {
      $("#inventory-update-modal .remote-content").html(response);
      $("#inventory-update-modal").modal("show");
    },
  });
}

function viewInventoryItem(id) {
  // #updateModal
  // ajax get request to the update url with id

  $.ajax({
    type: "GET",
    url: "view/view.php?id=" + id, // Replace with your PHP script URL
    success: function (response) {
      console.log(response);
      $("#inventory-view-modal .remote-content").replaceWith(response);
      $("#inventory-view-modal").modal("show");
    },
  });
}

function confitmDeleteItem(id) {
  $("#inventory-delete-modal").modal("show");
  $("#inventory-delete-modal input").val(id);
  $("#inventory-delete-modal .btn-delete").on("click", function (e) {
    $.ajax({
      type: "POST",
      data: { id },
      url: "process/delete.php",
      success: function (response) {
        $("#inventory-delete-modal").modal("hide");
        swal({
          title: "Success!",
          text: "Record Successfully Deleted",
          icon: "success",
          button: "Continue",
        }).then((value) => {
          if (value) {
            location.reload();
          }
        });
      },
    });
  });
}
