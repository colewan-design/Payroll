<div class="modal fade" id="confirm-delete<?php echo $employee_other_deductions_row['odId'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center font-18">
          <h4 style="padding-top: 30px; margin-bottom:30px; font-weight:bold;">
            Delete this Employee's Other Deduction: <?php echo $employee_other_deductions_row['employeeOtherDeductionName']; ?>?
          </h4>
          <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
            <div class="col-6">
              <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal">
                <i class="fa fa-times"></i>
              </button>
            </div>
            <div class="col-6">
              <a class="btn btn-primary border-radius-100 btn-block confirmation-btn" href = "employee-details.php?admin_id=<?php echo $admin_id;?>&employeeotherdeductionDelete=<?php echo $employee_other_deductions_row['odId']; ?>">
                <i class="fa fa-check"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  