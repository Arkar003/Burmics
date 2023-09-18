<?php 
	require '../dbconfig.php';
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<script type="text/javascript" src="../bs5.3/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<?php 
		$f_pm = "SELECT * FROM payment_method";
		$fpm_rtn = mysqli_query($dbconn, $f_pm);
	 ?>
	<div class="container-fluid">
		<div class="row min-vh-100">
			<div class="col-2 bg-light pe-0">
				<?php include 'sidebar.php'; ?>
			</div>
			<div class="col-10 bg-secondary-subtle ps-0">
				<div class="row py-3 mb-3">
					<div class="col-6">
						<div class="bg-light rounded mx-auto w-75 p-3 pb-4">
							<h4 class="text-center mb-4">Current rates</h4>
							<table class="table fs-5 mb-3">
								<tr>
									<td>Purchase rate</td>
									<td>
										<?php 
											$f_prate = "SELECT rate_per_coin FROM exchange_rate WHERE er_type = 'PURC'";
											$fp_rtn = mysqli_query($dbconn, $f_prate);

											if($fp_rtn->num_rows == 0){
												$set_prate = "INSERT INTO exchange_rate values ('PURC','0')";
												$sp_rtn = mysqli_query($dbconn, $set_prate);
												echo 0;
											}
											else{
												$rate_data = mysqli_fetch_assoc($fp_rtn);
												echo $rate_data['rate_per_coin'];
											}
										 ?>
									</td>
									<td>MMK per coin</td>
								</tr>
								<tr>
									<td>Withdraw rate</td>
									<td>
										<?php 
											$f_wrate = "SELECT rate_per_coin FROM exchange_rate WHERE er_type = 'WIDW'";
											$fw_rtn = mysqli_query($dbconn, $f_wrate);

											if($fw_rtn->num_rows == 0){
												$set_wrate = "INSERT INTO exchange_rate values ('WIDW','0')";
												$sw_rtn = mysqli_query($dbconn, $set_wrate);
												echo 0;
											}
											else{
												$rate_data = mysqli_fetch_assoc($fw_rtn);
												echo $rate_data['rate_per_coin'];
											}
										 ?>
									</td>
									<td>MMK per coin</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-6">
						<div class="bg-light rounded mx-auto w-75 p-3">
							<h4 class="text-center mb-3">Update rates</h4>
							<form method="post">
								<table class="table fs-5">
									<tr>
										<td><label class="form-label" for="prate">Purchase rate</label></td>
										<td class="w-25"><input class="form-control" type="number" name="prate" id="prate"></td>
										<td><button class="btn btn-primary w-100" type="submit" name="upPrate">Update</button></td>
									</tr>
									<tr>
										<td><label class="form-label" for="wrate">Withdraw rate</label></td>
										<td class="w-25"><input class="form-control" type="number" name="wrate" id="wrate"></td>
										<td><button class="btn btn-primary w-100" type="submit" name="upWrate">Update</button></td>
									</tr>
								</table>
							</form>
							<?php 
								if(isset($_REQUEST['upPrate'])){
									$amt = $_REQUEST['prate'];

									$up_prate = "UPDATE exchange_rate SET rate_per_coin = '$amt' WHERE er_type = 'PURC'";
									$upp_rtn = mysqli_query($dbconn, $up_prate);

									if($upp_rtn){
										echo "<script>
											alert('Update purchase rate successfully');
											location.assign('packageNrates.php');</script>";

									}
									else
										echo mysqli_error($dbconn);
								}

								if(isset($_REQUEST['upWrate'])){
									$wamt = $_REQUEST['wrate'];

									$up_wrate = "UPDATE exchange_rate SET rate_per_coin = '$wamt' WHERE er_type = 'WIDW'";
									$upw_rtn = mysqli_query($dbconn, $up_wrate);

									if($upw_rtn){
										echo "<script>
											alert('Update withdraw rate successfully');
											location.assign('packageNrates.php');</script>";

									}
									else
										echo mysqli_error($dbconn);
								}
							 ?>
						</div>
					</div>
				</div>
				<div class="row px-5">
					<div class="bg-light rounded p-4">
						<h4 class="text-center mb-3">Available payment methods</h4>
						<table class="table">
							<tr>
								<th>Payment method</th>
								<th>Account holder name</th>
								<th>Acc number</th>
								<th>
									<button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#addpm">Add new</button>
									<div class="modal fade" id="addpm" data-bs-backdrop="static" data-bs-keyboard="false">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title mx-auto">
														Adding new payment method
													</h4>
												</div>
												<div class="modal-body">
													<form method="post">
														<div class="mb-3">
															<label class="form-label" for="pmethod">Payment method</label>
															<input class="form-control" type="text" name="pmethod" id="pmethod">
														</div>
														<div class="mb-3">
															<label class="form-label" for="holder">Account holder name</label>
															<input class="form-control" type="text" name="holder" id="holder">
														</div>
														<div class="mb-3">
															<label class="form-label" for="accNumb">Account number</label>
															<input class="form-control" type="text" name="accNumb" id="accNumb">
														</div>
														<div class="mb-3">
															<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
															<button class="btn btn-primary" type="submit" name="addPayMethod">Add</button>
														</div>
													</form>
													
												</div>
											</div>
										</div>
									</div>
								</th>
							</tr>
							<?php 
								if($fpm_rtn->num_rows == 0){
							?>
							<tr>
								<td colspan="4" class="text-center">There's nothing to show here! add payment method.</td>
							</tr>
							<?php
								}
								else{
									while($pm_data = mysqli_fetch_assoc($fpm_rtn)){
							?>
							<tr>
								<td><?php echo $pm_data['payment_method']; ?></td>
								<td><?php echo $pm_data['holder_name']; ?></td>
								<td><?php echo $pm_data['acc_number']; ?></td>
								<td>
									<button class="btn btn-danger">Delete</button>
									<button class="btn btn-primary">Edit</button>
								</td>
							</tr>
							<?php
									}
								}
							 ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php 
		if(isset($_REQUEST['addPayMethod'])){
			$pm = $_REQUEST['pmethod'];
			$holderName = $_REQUEST['holder'];
			$accNum = $_REQUEST['accNumb'];

			$check_pm = "SELECT pm_id FROM payment_method WHERE payment_method = '$pm'";
			$cpm_rtn = mysqli_query($dbconn, $check_pm);

			if($cpm_rtn->num_rows == 0){
				$f_pmdata = "SELECT pm_id FROM payment_method ORDER BY pm_id DESC LIMIT 1";
				$fpm_rtn = mysqli_query($dbconn, $f_pmdata);
				if($fpm_rtn->num_rows == 0)
					$pmID = 'PM01';
				else{
					$payData = mysqli_fetch_assoc($fpm_rtn);
					$fet_pmid = $payData['pm_id'];
					$pmID = ++$fet_pmid;
				}

				$create_pm = "INSERT INTO payment_method VALUES ('$pmID','$pm','$accNum','$holderName')";
				$createpm_rtn = mysqli_query($dbconn, $create_pm);
				if($createpm_rtn)
					echo "<script>
							alert('Add payment method success.');
							location.assign('packageNrates.php');
						</script>";
				else
					echo mysqli_error($dbconn);
			}
		}
	 ?>
</body>
</html>