<div class="modal fade" id="update_modal<?php echo $fetch['deductionId']?>" tabindex="-1" role="dialog" aria-labelledby="update_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="update_modal_label">Update Deduction</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="update_mandatory_deductions.php">
        <input type="hidden" name="deductionId" value="<?php echo $fetch['deductionId']?>" />
        <div class="modal-body">
          <div class="form-group">
            <label for="deductionName">Deduction Name</label>
            <input type="text" class="form-control" name="deductionName" id="deductionName" value="<?php echo $fetch['deductionName']?>" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" value="<?php echo $fetch['description']?>" required>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="amount">Amount</label>
              <input type="number" class="form-control" name="amount" id="amount" value="<?php echo $fetch['amount']?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="deductionType">Deduction Type</label>
              <select class="form-control" name="deductionType" id="deductionType" required>
                <option value="percentage"<?php if($fetch['deductionType'] == 'percentage') echo ' selected'?>>Percentage</option>
                <option value="real_value"<?php if($fetch['deductionType'] == 'real_value') echo ' selected'?>>Real Value</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="minDeductionLimit">Deduction Limit (Minimum)</label>
              <input type="number" class="form-control" name="minDeductionLimit" id="minDeductionLimit" min="1" step="0.01" value="<?php echo $fetch['minDeductionLimit']?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="maxDeductionLimit">Deduction Limit (Maximum)</label>
              <input type="number" class="form-control" name="maxDeductionLimit" id="maxDeductionLimit" min="1" step="0.01" value="<?php echo $fetch['maxDeductionLimit']?>" required>
            </div>
          </div>
        </div>
							<div class="modal-footer d-flex justify-content-center">
								<button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
								<button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
							</div>
				
					</form>
				</div>
			</div>
				</div>