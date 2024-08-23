$(document).ready(function () {
  $("#oldtrandatatable").DataTable({
    language: {
      emptyTable: "No records found",
    },
    drawCallback: function () {
      $(".delete").unbind("click"); // Unbind previous click
    },
  });

  $("#oldtrandatatable").on("click", ".view", function () {
    oldtranId = $(this).attr("id");
    $.ajax({
      url: "process/view.php",
      method: "POST",
      data: { oldtranId: oldtranId },
      success: function (result) {
        $(".viewOldTran").html(result);
        $("#viewOldTranModal").modal("show");
      },
    });
  });

  //date checkbox
  $("#allDate").change(function () {
    if ($(this).is(":checked")) {
      // Checkbox is checked
      $("#dateFrom").prop("disabled", true);
      $("#dateTo").prop("disabled", true);
    } else {
      // Checkbox is unchecked
      $("#dateFrom").prop("disabled", false);
      $("#dateTo").prop("disabled", false);
    }
  });

  // Trigger the change event on form load
  $("#allDate").change();

  $(document).on("click", ".btnTransfer", function () {
    // Extract transaction number from button ID
    var transNum = $(this).attr("id").replace("trans_", "");
    // Extract data-id from button data attribute
    var dataid = $(this).data("id");
    // Find the serial number in #oldtrandatatable
    var serial_num = $(this).closest("tr").find(".serial-number").text().trim();

    // Store data in sessionStorage
    sessionStorage.setItem("trans_id", dataid);
    sessionStorage.setItem("trans_number", transNum);
    sessionStorage.setItem("serial_number", serial_num);

    // Open transfer.php in a new tab
    window.open("transfer.php", "_blank");
  });
});
