// Fetch the region JSON file asynchronously
fetch('json/table_region.json')
  .then(response => response.json())
  .then(regionData => {
    // Get the region select element
    const regionDropdown = document.getElementById("regionSelect");
    regionDropdown.innerHTML = '<option value="" selected disabled>Select Region</option>';
    // Populate the region dropdown with options
    regionData.forEach(region => {
      const option = document.createElement("option");
      option.value = region.region_id;
      option.setAttribute('attr-id', region.region_name);
      option.text = region.region_name;
      regionDropdown.appendChild(option);
    });
    // Add event listener for region selection change
    regionDropdown.addEventListener("change", () => {
      // Get the selected region ID
      const selectedRegionId = parseInt(regionDropdown.value);
      // Fetch the province JSON file asynchronously
      fetch('json/table_province.json')
        .then(response => response.json())
        .then(provinceData => {
          // Get the province select element
          const provinceDropdown = document.getElementById("provinceSelect");
          // Clear existing options
          provinceDropdown.innerHTML = '<option value="" selected disabled>Select Province</option>';
          // Filter provinces based on the selected region
          const filteredProvinces = provinceData.filter(province => province.region_id === selectedRegionId);
          // Populate the province dropdown with options
          filteredProvinces.forEach(province => {
            const option = document.createElement("option");
            option.value = province.province_id;
            option.setAttribute('attr-id', province.province_name);
            option.text = province.province_name;
            provinceDropdown.appendChild(option);
          });
          // Trigger the change event for province dropdown to update municipalities
          const provinceChangeEvent = new Event('change');
          provinceDropdown.dispatchEvent(provinceChangeEvent);
        })
        .catch(error => console.error('Error loading province JSON file:', error));
    });
    // Add event listener for province selection change
    const provinceDropdown = document.getElementById("provinceSelect");
    provinceDropdown.addEventListener("change", () => {
      // Get the selected province ID
      const selectedProvinceId = parseInt(provinceDropdown.value);

      // Fetch the municipality JSON file asynchronously
      fetch('json/table_municipality.json')
        .then(response => response.json())
        .then(municipalityData => {
          // Get the municipality select element
          const municipalityDropdown = document.getElementById("municipalitySelect");
          // Clear existing options
          municipalityDropdown.innerHTML = '<option value="" selected  disabled>Select Municipality</option>';
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
    const municipalityDropdown = document.getElementById("municipalitySelect");
    municipalityDropdown.addEventListener("change", () => {
      // Get the selected municipality ID
      const selectedMunicipalityId = parseInt(municipalityDropdown.value);

      // Fetch the barangay JSON file asynchronously
      fetch('json/table_barangay.json')
        .then(response => response.json())
        .then(barangayData => {
          // Get the barangay select element
          const barangayDropdown = document.getElementById("barangaySelect");

          // Clear existing options
          barangayDropdown.innerHTML = '<option value="" selected disabled>Select Barangay</option>';

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