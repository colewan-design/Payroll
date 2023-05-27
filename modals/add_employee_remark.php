 <div class="modal fade" id="add-new-remark" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content">
		  <div class="modal-header" style="background: #98FB98;">
			  <h4 class="modal-title w-100 text-center" id="modalLabel">
				  Add a remark
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				    ×
				</button>
			</div>
			<div class="modal-body">
			  <form method="POST" >
				  <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="form-group">
					    <label class="col-sm-12 col-md-4 col-form-label"> Other Deductions</label>
						  <select class="selectpicker" name="get_other_deduction" id="" style="width: 250px;"><br>
							  <option value=""></option>
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
						
							<div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Remark</span>
                              </div>
                              <textarea name="remark_text" class="form-control" aria-label="With textarea"></textarea>
                            </div>
						</div>
                        <div class="d-flex justify-content-center">
						  <button type="submit" name="addRemark" class="btn btn-primary">
								Save
							</button>
							<button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">
								Close
							</button>
                         </div>
					</form>
				</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>