$(document).ready(function () {
  $("#form-modal").on("hide.bs.modal", function () {
    console.log("close");
    const form = $("#form-modal form")[0];
    $("#form-modal .modal-title").text("Add Condition");
    $('#form-modal [name="id"]').val("");
    form.reset();
  });
});

function editItem(id, name) {
  $("#form-modal .modal-title").text("Edit Condition");
  $('#form-modal [name="name"]').val(name);
  $('#form-modal [name="id"]').val(id);
  $("#form-modal").modal("show");
}

//update
function save(event) {
  event.preventDefault();

  const form = $("#form-modal form")[0];
  const formData = new FormData(form);

  $.ajax({
    type: "POST",
    url: "process/save-condition.php",
    contentType: false,
    processData: false,
    data: formData,
    success: function (response) {
      const id = formData.get("id");
      if (id) {
        $(`#item-condition-table #${id} td:nth-child(1)`).text(
          formData.get("name")
        );
        swal({
          title: "Success!",
          text: "Condition Successfully Updated",
          icon: "success",
          button: "Continue",
        }).then((value) => {
          if (value) {
            location.reload();
          }
        });
      } else {
        swal({
          title: "Success!",
          text: "Condition Successfully Added",
          icon: "success",
          button: "Continue",
        }).then((value) => {
          if (value) {
            location.reload();
          }
        });
      }

      $("#form-modal").modal("hide");
    },
  });
}

function deleteItem(id) {
  bootbox.confirm("Do you really want to Delete?", function (result) {
    if (result) {
      $.ajax({
        type: "POST",
        url: "process/delete-condition.php",
        data: {
          id: id,
        },
        success: function (response) {
          if (response == 1) {
            $(`#item-condition-table #${id}`).remove();
            swal({
              title: "Success!",
              text: "Condition Successfully Deleted",
              icon: "success",
              button: "Continue",
            }).then((value) => {
              if (value) {
                location.reload();
              }
            });
          } else if (response == 3) {
            swal(
              "Cannot be deleted",
              "Selected condition is currently used in hardware inventory"
            );
          }
        },
      });
    }
  });
}
