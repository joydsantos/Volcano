//update
$(document).ready(function () {

    var remoteId, responseData;
    $('.btnUpdate').click(function () {
        $('#updateremoteAlert').hide();
        remoteId = $(this).data('id');
        $('#updateModal').modal("show");
        $.ajax({
            url: 'process/fetch_data.php',
            method: 'POST',
            data: { id: remoteId },
            dataType: 'json',
            success: function (data) {

                // Update the form fields with the fetched data
                responseData = data; //global 
                //set data
                $('#updatecboStation').val(data.station);
                $('#updatecboStationType').val(data.station_type).trigger('change');
                $('#updatestationName').val(data.station_name);
                $('#updateLatitude').val(data.latitude);
                $('#updateLongitude').val(data.longitude);
                $('#updateElevation').val(data.elevation);
                $('#updateInstrument').val(data.instrument);
                $('#updatedateStarted').val(data.date_started);
                $('#updatedateDestroyed').val(data.date_destroyed);
                $('#updateAddress').val(data.address1);

                $('#updateRemarks').val(data.remarks);
                //retrieve region only
                $.ajax({
                    url: 'json/table_region.json',
                    dataType: 'json',
                    success: function (regionData) {
                        // Get the region select element                      
                        const regionDropdown = $("#updateregionSelect");
                        // Populate the region dropdown with options
                        $.each(regionData, function (index, region) {
                            const option = $("<option></option>")
                                .val(region.region_name)
                                .attr('attr-id', region.region_id)
                                .text(region.region_name);
                            regionDropdown.append(option);
                        });
                        $('#updateregionSelect').val(data.region).trigger('change');
                    },

                    error: function (error) {
                        console.error('Error loading region JSON file:', error);
                    }
                });


            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    });
    $('#updatecboStationType').change(function () {
        $.ajax({
            url: 'process/fetch_equipment.php',
            type: 'POST',
            data: {
                catID: $(this).find(':selected').data('cat-id')
            },
            dataType: "json",
            success: function (response) {

                if (response.status === "Success") {
                    //console.log("suc" + data.category);
                    $('#updatecboStationCategory').empty();
                    if (response.response && Array.isArray(response.response)) {
                        // Clear existing options              
                        $('#updatecboStationCategory').append($('<option>', {
                            value: "", // Empty value
                            text: "Select Here",
                            disabled: true, // Disabled
                            selected: true // Selected by default
                        }));
                        // Populate combo box with new options
                        $.each(response.response, function (index, item) {
                            $('#updatecboStationCategory').append($('<option>', {
                                value: item.category, // Set 'id' as the option value
                                'data-cat-id': item.id, // Set 'stationtype_id' as the data-cat-id attribute
                                text: item.category // Set 'category' as the option text
                            }));

                        });
                        $('#updatecboStationCategory').val(responseData.category);
                    } else {
                        console.error('Invalid response structure:', response.status);
                    }

                } else {
                    console.error('Invalid response structure1:', response.status);
                }

            },
            error: function (xhr, _textStatus, errorThrown) {
                console.error("Response Text:", xhr.responseText);
                // Handle error cases if needed
            }

        });

    });
    //region or address combobox
    $('#updateregionSelect').change(function () {
        const selectedRegionId = $(this).find(':selected').attr('attr-id');
        // Fetch the province JSON file asynchronously
        $.ajax({
            url: 'json/table_province.json',
            dataType: 'json',
            success: function (provinceData) {
                // Get the province select element
                const provinceDropdown = $("#updateprovinceSelect");

                // Clear existing options
                provinceDropdown.html('<option value="" disabled> Select Province</option>');

                // Filter provinces based on the selected region
                const filteredProvinces = provinceData.filter(province => province.region_id === parseInt(selectedRegionId));

                // Populate the province dropdown with options
                $.each(filteredProvinces, function (index, province) {
                    const option = $("<option></option>")
                        .val(province.province_name)
                        .attr('attr-id', province.province_id)
                        .text(province.province_name);

                    provinceDropdown.append(option);
                });

                $('#updateprovinceSelect').val(responseData.province).trigger('change');

            },
            error: function (error) {
                console.error('Error loading province JSON file:', error);
            }
        });
    });

    $('#updateprovinceSelect').change(function () {

        const selectedProvinceId = $(this).find(':selected').attr('attr-id');
        $.ajax({
            url: 'json/table_municipality.json',
            dataType: 'json',
            success: function (municipalityData) {
                // Get the municipality select element
                const municipalityDropdown = $("#updatemunicipalitySelect");

                // Clear existing options
                municipalityDropdown.html('<option value="" disabled>Select Municipality</option>');

                // Filter municipalities based on the selected province
                const filteredMunicipalities = municipalityData.filter(municipality => municipality.province_id === parseInt(selectedProvinceId));

                // Populate the municipality dropdown with options
                $.each(filteredMunicipalities, function (index, municipality) {
                    const option = $("<option>")
                        .val(municipality.municipality_name)
                        .attr('attr-id', municipality.municipality_id)
                        .text(municipality.municipality_name);

                    municipalityDropdown.append(option);
                });
                $('#updatemunicipalitySelect').val(responseData.municipality).trigger('change');

            },
            error: function (error) {
                console.error('Error loading municipality JSON file:', error.statusText);
            }
        });

    });

    $('#updatemunicipalitySelect').change(function () {
        const selectedBarangayId = $(this).find(':selected').attr('attr-id');
        $.ajax({
            url: 'json/table_barangay.json',
            dataType: 'json',
            success: function (barangayData) {

                const barangayDropdown = $("#updatebarangaySelect");

                // Clear existing options
                barangayDropdown.html('<option value="" disabled>Select Barangay</option>');
                const filteredBarangay = barangayData.filter(barangay => barangay.municipality_id === parseInt(selectedBarangayId));

                // Populate the municipality dropdown with options
                $.each(filteredBarangay, function (index, barangay) {
                    const option = $("<option>")
                        .val(barangay.barangay_name)
                        .attr('attr-id', barangay.barangay_id)
                        .text(barangay.barangay_name);

                    barangayDropdown.append(option);
                });
                $('#updatebarangaySelect').val(responseData.barangay);
            },
            error: function (error) {
                console.error('Error loading barangay JSON file:', error.statusText);
            }
        });

    });

    /*
    $('#btnUpdateRecord').click(function () {
        var selectedOption = $('#updatecboStation').find('option:selected');
        // Get the value of the data-cat-id attribute
        var catId = selectedOption.data('cat-id');
        // Update the value of the #updatestationId input elemen
        // You can do something with the catId here

    }); */


    $("#update-remote-form").submit(function (event) {
        event.preventDefault();
        bootbox.confirm("Do you really want to update the remote station?", function (result) {
            if (result) {
                var station = $('#updatecboStation').find(':selected').data('cat-id');
                var stationType = $('#updatecboStationType').find(':selected').data('cat-id')
                var stationCategory = $('#updatecboStationCategory').find(':selected').data('cat-id');
                var stationName = $('#updatestationName').val();
                var latitude = $('#updateLatitude').val();
                var longitude = $('#updateLongitude').val();
                var elevation = $('#updateElevation').val();
                var instrument = $('#updateInstrument').val();
                var dateStarted = $('#updatedateStarted').val();
                var dateDestroyed = $('#updatedateDestroyed').val();
                var address = $('#updateAddress').val();
                var region = $('#updateregionSelect').val();
                var province = $('#updateprovinceSelect').val();
                var municipality = $('#updatemunicipalitySelect').val();
                var barangay = $('#updatebarangaySelect').val();
                var remarks = $('#updateRemarks').val();

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
                    url: "process/update.php", // Replace with your PHP script URL
                    data: formData,
                    dataType: "json", // Expect JSON response
                    success: function (response) {
                        // Parse the JSON response from the server

                        var alertDiv = $("#updateremoteAlert"); // Reference to the alert div
                        if (response.status === "success") {
                            alertDiv.text("Remote Station Successfuly Updated").removeClass().addClass("alert alert-success").show();
                            //$("#update-form")[0].reset();

                        }
                        else if (response.status === "date") {
                            alertDiv.text("Invalid Date").removeClass().addClass("alert alert-danger").show();
                        }
                        else if (response.status === "Input") {
                            alertDiv.text("Invalid Input").removeClass().addClass("alert alert-danger").show();
                        }
                        else {
                            console.log(response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: " + error);
                        console.error(xhr.responseText);
                    },
                });
            }
        });

    });

    $('#btnUpdateClose').click(function () {
        $("#update-form")[0].reset();
        $('#updateModal').modal("hide");
    });
});