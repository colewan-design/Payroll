 <div class="modal fade" id="update_modal<?php echo $employee_remark_row['id']?>" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<form method="POST" action="update_remarks.php">
          <input type="hidden" name="id" value="<?php echo $employee_remark_row['id']?>"/>
          <input type="hidden" name="emp_id" value="<?php echo $employee_remark_row['emp_id']?>"/>
			<div style="background: #98FB98;" class="modal-header">
				<h3  class="modal-title w-100 text-center">Update Remarks</h3>
			</div>
			<div style="background:#E0FFFF;" class="modal-body">
					
					
					<div class="form-group">
						<label>Remark</label>
						<input type="text" name="remark_text" value="<?php echo $employee_remark_row['remark_text']?>" class="form-control" required="required"/>
					</div>
			</div>
			<div style="clear:both;"></div>
			<div style="background: #40E0D0;"class="modal-footer d-flex justify-content-center">
				<button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
				<button class="btn btn-danger ml-2" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
			</div>
			</div>
		</form>
	</div>
</div>