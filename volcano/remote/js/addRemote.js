$(document).ready(function () {
  //adding new record using modal
  $('#btnAdd').click(function () {
    $('#remoteAlert').hide();
    $('#addModal').modal("show");
  });

  //fetch station
  $('#cboStationType').change(function () {
    var selectedCatId = $(this).find(':selected').data('cat-id');
    $.ajax({
      url: 'process/fetch_equipment.php',
      type: 'POST',
      data: {
        catID: selectedCatId
      },
      dataType: "json",
      success: function (response) {
        $('#cboStationCategory').empty();
        if (response.status === "Success") {
          if (response.response && Array.isArray(response.response)) {
            // Clear existing options              
            $('#cboStationCategory').append($('<option>', {
              value: "", // Empty value
              text: "Select Here",
              disabled: true, // Disabled
              selected: true // Selected by default
            }));
            // Populate combo box with new options
            $.each(response.response, function (index, item) {
              $('#cboStationCategory').append($('<option>', {
                value: item.id, // Set 'id' as the option value
                'data-cat-id': item.id, // Set 'stationtype_id' as the data-cat-id attribute
                text: item.category // Set 'category' as the option text
              }));

            });
          } else {
            console.error('Invalid response structure:', response.status);
          }
        } else {
          console.error('Invalid response structure1:', response.status);
        }

      },
      error: function (xhr, textStatus, errorThrown) {
        console.error("Response Text:", xhr.responseText);
        // Handle error cases if needed
      }

    });
  });


  $('#cboStationCategory').change(function () {
    var selectedStatId = $(this).find(':selected').data('cat-id');
  });

  $("#add-form").submit(function (event) {
    event.preventDefault();
    var station = $('#cboStation').find(':selected').data('cat-id');
    var stationType = $('#cboStationType').find(':selected').data('cat-id')
    var stationCategory = $('#cboStationCategory').find(':selected').data('cat-id');
    var stationName = $('#stationName').val();
    var latitude = $('#Latitude').val();
    var longitude = $('#Longitude').val();
    var elevation = $('#Elevation').val();
    var instrument = $('#Instrument').val();
    var dateStarted = $('#dateStarted').val();
    var dateDestroyed = $('#dateDestroyed').val();
    var address = $('#Address').val();
    var region = $('#regionSelect').find(':selected').attr('attr-id');
    var province = $('#provinceSelect').find(':selected').attr('attr-id');
    var municipality = $('#municipalitySelect').find(':selected').attr('attr-id');
    var barangay = $('#barangaySelect').find(':selected').attr('attr-id');
    var remarks = $('#Remarks').val();

    console.log(dateDestroyed);

    var formData = {
      stationName: stationName,
      station: station,
      stationType: stationType,
      stationCategory: stationCategory,
      latitude: latitude,
      longitude: longitude,
      elevation: elevation,
      instrument: instrument,
      dateStarted: dateStarted,
      dateDestroyed: dateDestroyed,
      address: address,
      region: region,
      province: province,
      municipality: municipality,
      barangay: barangay,
      remarks: remarks
    };

    $.ajax({
      type: "POST",
      url: "process/add.php", // Replace with your PHP script URL
      data: formData,
      dataType: "json", // Expect JSON response
      success: function (response) {
        // Parse the JSON response from the server

        var alertDiv = $("#remoteAlert"); // Reference to the alert div
        if (response.status === "success") {
          alertDiv.text("Remote Station Successfuly Added").removeClass().addClass("alert alert-success").show();
          $("#add-form")[0].reset();

        }
        else if (response.status === "date") {
          alertDiv.text("Invalid Date").removeClass().addClass("alert alert-danger").show();
        }
        else if (response.status === "Input") {
          alertDiv.text("Invalid Input").removeClass().addClass("alert alert-danger").show();
        }
      },
      error: function (xhr, status, errorThrown) {

        console.error(xhr.responseText);
      },
    });
  });

  $('#btnClose').click(function () {
    $("#add-form")[0].reset();
    $('#addModal').modal("hide");
  });

});

