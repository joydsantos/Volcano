function myFunction() {
  var x = document.getElementById("selectStation").value;
  document.getElementById("station").value = x;
}

$(document).ready(function () {
  var selectedId, codeSelectedID;

  function checkAndUpdate() {
    var category_name = $("#station");
    category_name.removeClass("border-red");
    if (category_name.val().trim() === "") {
      category_name.addClass("border-red");
      return false;
    }
    return true;
  }
  function checkAndDelete() {
    var category_name = $("#selectStation");
    if (!category_name.val()) {
      category_name.addClass("border-red");
      return false;
    }
    category_name.removeClass("border-red");
    return true;
  }
  function checkAndAdd() {
    var category_name = $("#txtStation");
    category_name.removeClass("border-red");
    if (category_name.val().trim() === "") {
      category_name.addClass("border-red");
      return false;
    }
    return true;
  }

  $("#btnUpdate").click(function (event) {
    event.preventDefault();

    var updateid =
      document.getElementById(
        "selectStation"
      ).value; /* value ng combobox na uupdate */
    var updatecate =
      document.getElementById("station").value; /* value ng textbox */
    if (checkAndUpdate()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to update?", function (result) {
        if (result) {
          $.ajax({
            url: "updateStation.php?Upid=" + updatecate,
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
                    window.location.href = "category.php";

                    exit;
                  }
                });
              } else if (response == 2) {
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
      });
    }
  });
  $("#btnDelete").click(function (event) {
    event.preventDefault();
    var delid =
      document.getElementById(
        "selectStation"
      ).value; /* value ng combobox na dedelete */
    var indexId = document
      .getElementById("selectStation")
      .options[selectStation.selectedIndex].getAttribute("data-id");

    if (checkAndDelete()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to Delete?", function (result) {
        if (result) {
          $.ajax({
            url: "deleteStation.php",
            type: "POST",
            data: {
              id: delid,
              indexId: indexId,
            },
            success: function (response) {
              if (response == 1) {
                swal({
                  title: "Confirm",
                  text: "Successfully Deleted",
                  icon: "success",
                }).then((okay) => {
                  if (okay) {
                    window.location.href = "category.php";
                    // You don't need the 'exit' statement here
                  }
                });
              } else if (response == 2) {
                swal("Can not be deleted", "Station type is currently in used");
              } else if (response == 3) {
                swal("Can not be deleted", "Station type is currently in used");
              } else if (response == 4) {
                swal("Can not be deleted", "Error in deleting station");
              } else if (response == "Invalid input") {
                swal("Can not be deleted", "Invalid");
              } else {
                // Handle other responses if needed
                swal("Can not be deleted", "Something went wrong");
                console.log(response);
              }
            },
          });
        } else {
        }
      });
    }
  });
  $("#selectStation").on("change", function () {
    checkAndDelete();
    $("#station").val($(this).val());
    selectedId = $(this).find(":selected").data("id");

    $.ajax({
      type: "POST",
      url: "fetch_category.php",
      data: { selectedId: selectedId },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          $("#stationCode").val("");
          var options =
            '<option value="" selected disabled>--Select here--</option>';
          $.each(response.result, function (index, item) {
            options +=
              '<option value="' + item.id + '">' + item.category + "</option>";
          });
          $("#selectStationCode").html(options);
        } else {
          console.log("else" + response.message);
        }
      },
      error: function (xhr, status, errorThrown) {
        //console.log(xhr.responseText);
      },
    });
  });

  $("#btnAddStation").click(function (event) {
    event.preventDefault();
    var addid = document.getElementById("txtStation").value;
    if (checkAndAdd()) {
      bootbox.confirm("Do you really want to add?", function (result) {
        if (result) {
          $.ajax({
            url: "addStation.php",
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
                    window.location.href = "category.php";
                  }
                });
              } else if (response == 2) {
                swal("Can not be Added", "Station Already Exist");
              } else if (response == "Invalid input") {
                swal("Can not be added", "Invalid");
              } else if (response == 4) {
                swal("Can not be Added", "Error in adding");
              } else {
                swal("Can not be Added", "Something went wrong");
              }
            },
          });
        } else {
        }
      });
    }
  });

  //station code
  function checkAndAddCode() {
    var category_code = $("#txtStationCode");
    var station_name = $("#selectStation");
    category_code.removeClass("border-red");
    station_name.removeClass("border-red");
    if (!station_name.val()) {
      station_name.addClass("border-red");
      if (category_code.val().trim() === "") {
        category_code.addClass("border-red");
      }
      return false;
    }
    return true;
  }

  function checkAndDeleteCode() {
    var category_code_del = $("#selectStationCode");
    var station_name_del = $("#selectStation");
    category_code_del.removeClass("border-red");
    station_name_del.removeClass("border-red");

    if (!station_name_del.val()) {
      station_name_del.addClass("border-red");
      return false;
    } else if (!category_code_del.val()) {
      category_code_del.addClass("border-red");
      return false;
    }
    return true;
  }

  function checkAndUpdateCode() {
    var category_code_upd = $("#selectStationCode");
    var station_name_upd = $("#selectStation");
    var station_code_upd = $("#stationCode");

    category_code_upd.removeClass("border-red");
    station_name_upd.removeClass("border-red");

    if (!station_name_upd.val()) {
      station_name_upd.addClass("border-red");
      return false;
    } else if (!category_code_upd.val()) {
      category_code_upd.addClass("border-red");
      return false;
    } else if (station_code_upd.val().trim() === "") {
      station_code_upd.addClass("border-red");
      return false;
    }
    return true;
  }

  $("#btnAddCode").click(function (event) {
    event.preventDefault();
    var station_Code = $("#txtStationCode").val();
    console.log(selectedId);

    if (checkAndAddCode()) {
      bootbox.confirm("Do you really want to add?", function (result) {
        if (result) {
          $.ajax({
            url: "add_Station_Code.php",
            type: "POST",
            data: {
              station_id: selectedId,
              add_Code: station_Code,
            },
            success: function (response) {
              if (response == 1) {
                swal({
                  title: "Confirm",
                  text: "Successfully Added",
                  icon: "success",
                }).then((okay) => {
                  if (okay) {
                    window.location.href = "category.php";
                  }
                });
              } else if (response == 2) {
                swal("Can not be Added", "Station Code Already Exist");
              } else if (response == "Invalid input") {
                swal("Can not be added", "Invalid");
              } else if (response == 4) {
                swal("Can not be Added", "Error in adding");
              } else {
                swal("Can not be Added", "Something went wrong");
              }
            },
          });
        } else {
        }
      });
    } else {
      console.log("else");
    }
  });

  $("#btnDeleteCode").click(function (event) {
    event.preventDefault();
    if (checkAndDeleteCode()) {
      var del_code = $("#selectStationCode").val();
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to Delete?", function (result) {
        console.log(selectedId);
        console.log(codeSelectedID);
        if (result) {
          $.ajax({
            url: "delete_Station_Category.php",
            type: "POST",
            data: {
              del_code_id: codeSelectedID,
              del_station_id: selectedId,
            },
            success: function (response) {
              if (response == 1) {
                swal({
                  title: "Confirm",
                  text: "Successfully Deleted",
                  icon: "success",
                }).then((okay) => {
                  if (okay) {
                    window.location.href = "category.php";
                    // You don't need the 'exit' statement here
                  }
                });
              } else if (response == 2) {
                swal("Can not be deleted", "Category is currently in used");
              } else if (response == 3) {
                swal("Can not be deleted", "Category is  currently in used");
              } else if (response == 4) {
                swal("Can not be deleted", "Error in deleting station");
              } else if (response == "Invalid input") {
                swal("Can not be deleted", "Invalid");
              } else {
                // Handle other responses if needed
                swal("Can not be deleted", "Something went wrong");
                console.log(response);
              }
            },
          });
        } else {
        }
      });
    }
  });

  $("#btnUpdateCode").click(function (event) {
    event.preventDefault();
    if (checkAndUpdateCode()) {
      // If the textbox is not empty, continue with the Bootbox confirmation dialog
      bootbox.confirm("Do you really want to update?", function (result) {
        if (result) {
          $.ajax({
            url: "update_Station_Category.php",
            type: "POST",
            data: {
              upd_cat_id: codeSelectedID,
              upd_station_id: selectedId,
              upd_code: $("#stationCode").val(),
            },

            success: function (response) {
              if (response == 1) {
                swal({
                  title: "Confirm",
                  text: "Sucessfully Updated",
                  icon: "success",
                }).then((okay) => {
                  if (okay) {
                    window.location.href = "category.php";

                    exit;
                  }
                });
              } else if (response == 2) {
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
      });
    }
  });
  $("#selectStationCode").on("change", function () {
    codeSelectedID = $(this).val();

    $("#stationCode").val($(this).find("option:selected").text());
  });
});

$(document).ready(function () {
  $("ul li a").click(function () {
    $("ul li.active").removeClass("active");
    $(this).closest("li").addClass("active");
  });
});

function hideshow(elementId) {
  var div = document.getElementById("remoteStationType");
  var div1 = document.getElementById("remoteCatSection");
  var element = document.getElementById(elementId);

  if (elementId === "remoteStationType") {
    div.style.display = "block";
    div1.style.display = "none";
  } else if (elementId === "remoteCatSection") {
    div.style.display = "none";
    div1.style.display = "block";
  } else {
  }
}
