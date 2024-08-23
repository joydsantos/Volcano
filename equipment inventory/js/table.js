$(document).ready(function () {
  $(".view").click(function () {
    stockid = $(this).attr("id");

    $.ajax({
      url: "view.php",
      method: "POST",
      data: { stockid: stockid },
      success: function (result) {
        // Append the result to the modal body
        $(".viewCont").html(result);
        // Show the modal
        $("#viewModal").modal("show");
      },
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
$(document).ready(function () {
  $("#datatableid").DataTable({
    language: {
      emptyTable: "No records found",
    },
    drawCallback: function () {
      $(".delete").unbind("click"); // Unbind previous click
    },
  });

  //update modal
  $(".btnAddStock").click(function () {
    // Trigger the modal to open
    $("#addStockModal").modal("show");
  });

  $("#datatableid").on("click", ".update", function () {
    var id = $(this).data("id");

    $.ajax({
      url: "process/fetch_data.php",
      method: "POST",
      data: { id: id },
      dataType: "json",
      success: function (data) {
        // Update the form fields with the fetched data
        $("#updateSerialNum").val(data.SerialNum);
        $("#updatePropertyNum").val(data.PropertyNum);
        $("#updateMAC").val(data.MAC);
        $("#updateItemName").val(data.ItemName);
        $("#updateDescription").val(data.Description);
        $("#updateqty").val(data.qty);
        $("#updateavqty").val(data.avqty);
        $("#updatecboQtyType").val(data.typeQty);
        $("#updatedateRecieved").val(data.dateRecieved);
        $("#updatepar").val(data.par);
        $("#updatecboUnit").val(data.unit);
        $("#updatecboStatus").val(data.status);
        $("#updateRemarks").val(data.remarks);
        $("#updatecboCategory").val(data.category);
        $("#updateStockNum").val(data.stockId);
        $("#stockfilenameLabel").text("Current File: " + data.Filename);
        $("#updatecboCategory").change(function () {
          // Get the selected option
          var selectedOption = $(this).find("option:selected");
          // Get the value of the data-cat-id attribute
          var catId = selectedOption.data("cat-id");
          // Update the value of the #updatecatId input element
          $("#updatecatId").val(catId);
        });
        // Trigger the change event to initialize the #updatecatId input with the initial selected option's data-cat-id value
        $("#updatecboCategory").trigger("change");
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
    $("#updateStockModal").modal("show");
  });
});

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // Get a reference to the close button
  var closeButton = document.getElementById("closeButton");

  // Add a click event listener to the close button
  closeButton.addEventListener("click", function () {
    // Trigger a page reload when the modal is closed

    location.reload();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Get a reference to the close button
  var closeButton1 = document.getElementById("closeButtonUpdate");

  // Add a click event listener to the close button
  closeButton1.addEventListener("click", function () {
    // Trigger a page reload when the modal is closed

    location.reload();
  });
});
