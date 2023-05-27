<div class="modal fade" id="add-employee-deduction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #98FB98;">
        <h4 class="modal-title text-center w-100" id="modalLabel">
          Add Mandatory Deduction
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="form-group row">
            <label for="employeeDeductionId" class="col-sm-4 col-form-label">Deduction List:</label>
            <div class="col-sm-8">
              <select class="form-control selectpicker" name="employeeDeductionId" id="employeeDeductionId">
                <option value="">Select</option>
                <?php
                  $result = $mysqli->query("SELECT * FROM deductions") or die($mysqli->error);
                  while ($trow = mysqli_fetch_array($result)) {
                    $trows[] = $trow;
                  }
                  foreach ($trows as $trow) {
                    print "<option value='" . $trow['deductionId'] . "'>" . $trow['deductionName'] . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-center">
              <button type="submit" name="addEmployeeDeduction" value="employee-details.php?addEmployeeDeduction" class="btn btn-success">
                Save
              </button>
              <button type="button" class="btn btn-secondary ml-4" data-dismiss="modal">
                Close
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
