$(document).ready(function () {

  $('#datatableid').DataTable({
    "order": [[0, 'desc']],
    "language": {
      "emptyTable": "No records found"
    },
    "drawCallback": function () {
      $('.delete').unbind('click'); // Unbind previous click 

    }
  });

  //view
  $('.view').click(function () {
    remoteId = $(this).data('id');
    $.ajax({
      url: "process/view.php",
      method: 'POST',
      data: { remoteId: remoteId },
      success: function (result) {
        // Append the result to the modal body
        $(".viewCont").html(result);
        // Show the modal
        $('#viewStationModal').modal("show");

      }
    });
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