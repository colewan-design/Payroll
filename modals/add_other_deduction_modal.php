<div class="modal fade" id="add-other-deduction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h4 class="modal-title w-100 text-center" id="modalLabel">
          Add Other Deduction
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Deduction List</label>
            <div class="col-sm-8">
           <div style="position: relative; width: 100%;">
              <select class="selectpicker form-control" name="otherDeductionId" id="otherDeductionId" style="position: relative; width: 100%; z-index: 1;">
                <option value="">Select</option>
                <?php
                  $result = $mysqli->query("SELECT * FROM otherdeductions") or die($mysqli->error);
                  while ($row_otherdeductions = mysqli_fetch_array($result)) {
                    $row_otherdeductions_s[] = $row_otherdeductions;
                  }
                  foreach ($row_otherdeductions_s as $row_otherdeductions) {
                    print "<option value='" . $row_otherdeductions['otherDeductionId'] . "'>" . $row_otherdeductions['otherDeductionName'] . "</option>";
                  }
                ?>
              </select>
             
            </div>


            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label font-weight-bold">Deduction Amount</label>
            <div class="col-sm-8">
              <input name="employeeOtherDeductionAmount" step="0.01" class="form-control" type="number" placeholder="Enter Amount" required>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <button type="submit" name="addEmployeeOtherDeduction" value="employee-details.php?addEmployeeOtherDeduction" class="btn btn-success mr-2">
              Save
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Close
            </button>
          </div>
        </form>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
