<select onchange="onMunicipalityChanged(event)" name="municipalityId" class="form-select shadow-sm" required="required">
    <option value="" selected disabled>Select Here</option>
    <?php
    foreach ($municipalities as $municipality) {
        echo "<option value='" . $municipality['id'] . "'>" . $municipality['name'] . "</option>";
    }
    ?>
</select>