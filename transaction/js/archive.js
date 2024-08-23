$(document).ready(function () {
  // Delete
  $("#datatableid").on("click", ".btnTrash", function () {
    var el = this;
    // Delete id
    var deleteid = $(this).data("id");
    //console.log("id" + deleteid);
    // Confirm box
    bootbox.confirm("Do you really want to delete record?", function (result) {
      if (result) {
        // AJAX Request
        $.ajax({
          url: "process/delete.php",
          type: "POST",
          data: {
            id: deleteid,
          },
          dataType: "json",
          success: function (response) {
            // Removing row from HTML Table
            if (response.status == "success") {
              $(el).closest("tr").css("background", "tomato");
              $(el)
                .closest("tr")
                .fadeOut(800, function () {
                  $(this).remove();
                });
              swal({
                title: "Success!",
                text: "Record Successfully Deleted",
                icon: "success",
                button: "Continue",
              });
            } else {
              swal("Can not be deleted", "Something went wrong");
            }
          },
          error: function (xhr, status, errorThrown) {
            console.error(xhr.responseText);
          },
        });
      }
    });
  });
});
