<select name="barangayId" class="form-select shadow-sm" required="required">
    <option value="" selected disabled>Select Here</option>
    <?php
    foreach ($barangays as $barangay) {
        echo "<option value='" . $barangay['id'] . "'>" . $barangay['name'] . "</option>";
    }
    ?>
</select>