// Fetch the region JSON file asynchronously
// Assuming your modal has an ID 'myModal'

$(document).ready(function () {
    $('#updateModal').on('show.bs.modal', function () {
        // Do something when the modal is opened
        fetch('json/table_region.json')
            .then(response => response.json())
            .then(regionData => {
                // Get the region select element
                const regionDropdown = document.getElementById("updateregionSelect");
                // Populate the region dropdown with options
                regionData.forEach(region => {
                    const option = document.createElement("option");
                    option.value = region.region_name;
                    option.setAttribute('attr-id', region.region_id);
                    option.text = region.region_name;
                    regionDropdown.appendChild(option);
                });
                // Add event listener for region selection change

                // Add event listener for province selection change
                const provinceDropdown = document.getElementById("updateprovinceSelect");
                provinceDropdown.addEventListener("change", () => {
                    // Get the selected province ID
                    const selectedProvinceId = parseInt(provinceDropdown.value);

                    // Fetch the municipality JSON file asynchronously
                    fetch('json/table_municipality.json')
                        .then(response => response.json())
                        .then(municipalityData => {
                            // Get the municipality select element
                            const municipalityDropdown = document.getElementById("updatemunicipalitySelect");
                            // Clear existing options
                            municipalityDropdown.innerHTML = '<option value="">Select Municipality</option>';
                            // Filter municipalities based on the selected province
                            const filteredMunicipalities = municipalityData.filter(municipality => municipality.province_id === selectedProvinceId);
                            // Populate the municipality dropdown with options
                            filteredMunicipalities.forEach(municipality => {
                                const option = document.createElement("option");
                                option.value = municipality.municipality_id;
                                option.setAttribute('attr-id', municipality.municipality_name);
                                option.text = municipality.municipality_name;
                                municipalityDropdown.appendChild(option);
                            });
                            // Trigger the change event for municipality dropdown to update barangays
                            const municipalityChangeEvent = new Event('change');
                            municipalityDropdown.dispatchEvent(municipalityChangeEvent);
                        })
                        .catch(error => console.error('Error loading municipality JSON file:', error));
                });

                // Add event listener for municipality selection change
                const municipalityDropdown = document.getElementById("updatemunicipalitySelect");
                municipalityDropdown.addEventListener("change", () => {
                    // Get the selected municipality ID
                    const selectedMunicipalityId = parseInt(municipalityDropdown.value);

                    // Fetch the barangay JSON file asynchronously
                    fetch('json/table_barangay.json')
                        .then(response => response.json())
                        .then(barangayData => {
                            // Get the barangay select element
                            const barangayDropdown = document.getElementById("updatebarangaySelect");

                            // Clear existing options
                            barangayDropdown.innerHTML = '<option value="">Select Barangay</option>';

                            // Filter barangays based on the selected municipality
                            const filteredBarangays = barangayData.filter(barangay => barangay.municipality_id === selectedMunicipalityId);

                            // Populate the barangay dropdown with options
                            filteredBarangays.forEach(barangay => {
                                const option = document.createElement("option");
                                option.value = barangay.barangay_id;
                                option.text = barangay.barangay_name;
                                option.setAttribute('attr-id', barangay.barangay_name); // Use 'data-id' attribute
                                barangayDropdown.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error loading barangay JSON file:', error));
                });

                // Trigger the change event initially to populate provinces based on the default region
                const changeEvent = new Event('change');
                regionDropdown.dispatchEvent(changeEvent);
            })
            .catch(error => console.error('Error loading region JSON file:', error));

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
            $('#updatemunicipalitySelect').val(data.municipality).trigger('change');

        },
        error: function (error) {
            console.error('Error loading municipality JSON file:', error.statusText);
        }
    });

});