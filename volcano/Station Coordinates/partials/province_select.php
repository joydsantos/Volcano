<select onchange="onProvinceChanged(event)" name="provinceId" class="form-select shadow-sm" required="required">
    <option value="" selected disabled>Select Here</option>
    <?php
    foreach ($provinces as $province) {
        echo "<option value='" . $province['id'] . "'>" . $province['name'] . "</option>";
    }
    ?>
</select>