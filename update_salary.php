<div class="modal fade" id="update_modal<?php echo $fetch['id']?>" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="update_query.php">
				<div class="modal-header">
					<h3 class="modal-title">Update Salary</h3>
				</div>
				<div class="modal-body">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<div class="form-group">
							<label>Salary Grade</label>
							<input type="hidden" name="id" value="<?php echo $fetch['id']?>"/>
							<input type="text" name="salaryGrade" value="<?php echo $fetch['salaryGrade']?>" class="form-control" required="required"/>
						</div>
						<div class="form-group">
							<label>Step</label>
							<input type="text" name="salaryStep" value="<?php echo $fetch['salaryStep']?>" class="form-control" required="required" />
						</div>
						<div class="form-group">
						<label>Position</label>
					
							<select name="position" class="selectpicker">
							<option value="">Select</option>
							<?php
						
							
							while ($srow = mysqli_fetch_array($result_position)) {
								$srows[] = $srow;
							}
							foreach ($srows as $srow) {
								print "<option value='" . $srow['positionName'] . "'>" . $srow['positionName'] . "</option>";
							}
							?>
						</select>
						</div>
						<div class="form-group">
							<label>Salary Amount</label>
							<input type="text" name="salaryAmount" value="<?php echo $fetch['salaryAmount']?>" class="form-control" required="required"/>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="modal-footer">
					<button name="update" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
					<button class="btn btn-danger" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
				</div>
				</div>
			</form>
		</div>
	</div>
</div>