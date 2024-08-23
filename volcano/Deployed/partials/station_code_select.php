<select name="stationCode" class="form-select shadow-sm" required="required">
    <option value="" selected disabled>Select Here</option>
    <?php
    foreach ($station_codes as $code) {
        echo "<option value='" . $code['code_id'] . "'>" . $code['code'] . "</option>";
    }
    ?>
</select>