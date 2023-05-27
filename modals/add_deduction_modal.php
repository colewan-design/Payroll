<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="save_mandatory_deductions.php">
        <div style="background: #98FB98;"class="modal-header">
          <h3 class="modal-title w-100 text-center">Add New Deduction</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="deductionName">Deduction Name</label>
            <input type="text" id="deductionName" name="deductionName" class="form-control" required="required"/>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="description" name="description"  class="form-control" required="required" />
          </div>
          <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" id="amount" name="amount"  class="form-control" required="required" />                                                
          </div>
          <div class="form-group">
            <label for="deductionType">Deduction Type</label>
            <select class="form-control" id="deductionType" name="deductionType">
              <option value="percentage">Percentage</option>
              <option value="real_value">Real Value</option>
            </select>                                                  
          </div>
          <div class="form-group">
            <label for="minDeductionLimit">Deduction Limit (Minimum)</label>
            <input class="form-control" id="minDeductionLimit" min="1" step="0.01" name="minDeductionLimit" type="number" placeholder="Enter Minimum Deduction">
          </div>
          <div class="form-group">
            <label for="maxDeductionLimit">Deduction Limit (Maximum)</label>
            <input class="form-control" id="maxDeductionLimit" min="1" step="0.01" name="maxDeductionLimit" type="number" placeholder="Enter Maximum Deduction">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
