<select name="locationId" class="form-select shadow-sm" required="required">
    <option value="" selected disabled>Select Here</option>
    <?php
    foreach ($locations as $location) {
        echo "<option value='" . $location['id'] . "'>" . $location['location'] . "</option>";
    }
    ?>
</select>