<div class="modal fade" id="add-employee-allowance" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h4 class="modal-title text-center w-100" id="modal-label">Add New Allowance</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Allowance List</label>
            <div class="col-sm-8">
              <select class="selectpicker form-control" name="employeeAllowanceId">
                <option value=""></option>
                <?php
                  $allowances = $mysqli->query("SELECT * FROM allowance") or die($mysqli->error);
                  while ($row = mysqli_fetch_array($allowances)) {
                    echo "<option value='" . $row['allowanceId'] . "'>" . $row['allowanceName'] . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <button type="submit" name="addEmployeeAllowance" class="btn btn-success mr-2">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
