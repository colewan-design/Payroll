<div class="modal fade" id="update_modal<?php echo $employee_other_deductions_row['odId']?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <form method="POST" action="update_employee_other_deductions.php">
        <input type="hidden" name="odid" value="<?php echo $employee_other_deductions_row['odId']?>"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div class="modal-header bg-primary text-white">
          <h3 class="modal-title text-center m-0">
            Update <?php echo $employee_other_deductions_row['employeeOtherDeductionName']?>
          </h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Enter Amount</label>
            <input type="text" name="other_deduction_amount" value="<?php echo $employee_other_deductions_row['employeeOtherDeductionAmount']?>" class="form-control" required="required"/>
          </div>
        </div>
        <div class="modal-footer">
          <button name="update" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Update</button>
          <button class="btn btn-secondary ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
