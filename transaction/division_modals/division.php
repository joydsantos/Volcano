<style type="text/css">
    .border-red {
        border: 1px solid red;
    }
</style>

<div class="modal fade" id="divisionModal" name="" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container">
                    <h5 class="modal-title">Manage Division</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="container-fluid mt-2">
                    <form method="POST" id="division-form" enctype="form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Division</label><br>
                                    <select name="cboManageDivision" id="cboManageDivision" class="form-select shadow-sm">
                                        <option value="" selected disabled>Select Here</option>
                                        <?php
                                        # Loop through the result 
                                        mysqli_data_seek($result3, 0);
                                        while ($row1 = mysqli_fetch_assoc($result3)) {
                                            $division = $row1['division'];
                                            $division_id = $row1['id'];
                                            echo "<option value='" . htmlspecialchars($division, ENT_QUOTES) . "' data-cat-id='" . htmlspecialchars($division_id, ENT_QUOTES) . "'>" . htmlspecialchars($division, ENT_QUOTES) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Division</label>
                                    <input type="text" name="manageDivision" id="manageDivision" required="required" class="form-control shadow-sm" style="color: black;" value="<?php echo isset($_POST['manageDivision']) ? htmlspecialchars($_POST['manageDivision'], ENT_QUOTES) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn pt-2 btn-block shadow-sm" id="btnUpdateDivision" name="btnUpdateDivision" style="background-color: #1F5F54; color: white;">Update
                                        Division</button>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn pt-2 btn-block shadow-sm" id="btnDeleteDivision" name="btnDeleteDivision" style="background-color:#360909; color: white;">Delete
                                        Division</button>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>New Division</label>
                                    <input type="text" name="addDivision" id="addDivision" required="required" class="form-control shadow-sm" style="color: black;" value="<?php echo isset($_POST['addDivision']) ? htmlspecialchars($_POST['addDivision'], ENT_QUOTES) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn pt-2 btn-block shadow-sm" id="btnAddDivision1" name="btnAddDivision1" style="background-color: #0B5694;color: white;">Add
                                        Division</button>

                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group">
                                    <div class="alert shadow-sm  p-3  bg-body-tertiary rounded-1" role="alert" style="text-align: center;" id="DivisionAlert">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>