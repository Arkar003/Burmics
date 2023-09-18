<?php 
	require 'dbconfig.php';
	include 'controller.php';
	date_default_timezone_set("Asia/Yangon");
	// session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script type="text/javascript">
		function calWidMMK(rate){
			var coin = parseFloat(document.getElementById("amt_coin").value);

            if(isNaN(coin))
                coin = 0;
			
			var result = coin * parseFloat(rate);
			document.getElementById("amt_mmk").value = result;
		}
	</script>
</head>
<body>
	<?php 
		$get_Widrate = "SELECT rate_per_coin FROM exchange_rate WHERE er_type='WIDW'";
		$gw_rtn = mysqli_query($dbconn, $get_Widrate);
		$rateData = mysqli_fetch_assoc($gw_rtn);
	 ?>
	<form enctype="multipart/form-data" method="post">
		<div class="container">
			<div class="mb-3 row">
				<div class="text-center bg-success-subtle rounded p-3">
					<h4>Current withdrawal rate</h4>
					<p class="m-0">
						1 coin ~ <?php echo $rateData['rate_per_coin'] ?> MMK
					</p>
				</div>
			</div>
			<div class="mb-3 row">
				<div class="col-5">
					<div class="input-group">
						<input class="form-control" type="number" name="amt_coin" id="amt_coin" oninput="calWidMMK('<?php echo $rateData['rate_per_coin']; ?>')" min="100">
						<span class="input-group-text" for="amt_coin">Coins</span>
					</div>
				</div>
				<div class="col-2 text-center">
					<h4><i class="bi bi-arrow-right"></i></h4>
				</div>
				<div class="col-5">
					<div class="input-group">
						<input class="form-control" type="number" name="amt_mmk" id="amt_mmk" value="" disabled>
						<span class="input-group-text" for="amt_mmk">MMK</span>
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div>
					<div class="text-center bg-warning-subtle rounded p-2">
						<h6 class="mb-0">Minimum threshold amount to withdraw is 100 coins.</h6>
					</div>
				</div>
			</div>
			<div class="mb-3 row">
				<div>
					<?php 
						$fet_pm = "SELECT * FROM payment_method";
						$fpm_rtn = mysqli_query($dbconn, $fet_pm);
					 ?>
					<select class="form-select" id="paymethod" name="paymethod">
						<option selected value="">Choose Payment method</option>
						<?php 
							while($pm_data = mysqli_fetch_assoc($fpm_rtn)){
						?>
						<option value="<?php echo $pm_data['pm_id'] ?>">
							<?php echo $pm_data['payment_method']; ?>		
						</option>
						<?php		
							}
						 ?>
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<div>
					<label class="form-label" for="holName">Account holder name</label>
					<input class="form-control" type="text" name="holName" id="holName">
				</div>
			</div>
			<div class="mb-3 row">
				<div>
					<label class="form-label" for="accNo">Account Number</label>
					<input class="form-control" type="text" name="accNo" id="accNo">
				</div>
			</div>
			<div class="mb-3 row">
				<div class="text-center">
					<button class="btn btn-outline-secondary" type="reset">Cancel</button>
					<button class="btn btn-primary" type="submit" name="submitForm">Order</button>
				</div>
			</div>

		</div>
	</form>
	<?php 
		if(isset($_REQUEST['submitForm'])){
			$cID = getCreatorId($_SESSION['uid']);
			$coinAmt = $_REQUEST['amt_coin'];
			$multi = $rateData['rate_per_coin'];
			$MMKamt = $coinAmt * $multi;
			$wMethod = $_REQUEST['paymethod'];
			$holder = $_REQUEST['holName'];
			$accNo = $_REQUEST['accNo'];
			$wid_date = date('Y-m-d H:i:s');
			$stat = "Pending";

			$ownedCoin = getCoins($_SESSION['uid']);
			if($coinAmt <= $ownedCoin){
				$fet_forms = "SELECT w_id FROM coin_withdraw_rec WHERE creator_id = '$cID' AND status = '$stat'";
				$ff_rtn = mysqli_query($dbconn, $fet_forms);

				if($ff_rtn->num_rows == 0){
					$fet_wid = "SELECT w_id FROM coin_withdraw_rec ORDER BY w_id DESC LIMIT 1";
					$fwid_rtn = mysqli_query($dbconn, $fet_wid);
					if($fwid_rtn->num_rows == 0)
						$withdrawID = 'WD000001';
					else{
						$wid_info = mysqli_fetch_assoc($fwid_rtn);
						$last_wid = $wid_info['w_id'];
						$withdrawID = ++$last_wid;
					}
					$order_form = "INSERT INTO coin_withdraw_rec (w_id, creator_id, coin_amount, amount, pm_id, acc_holder, acc_number, w_date, status) VALUES ('$withdrawID','$cID','$coinAmt','$MMKamt','$wMethod','$holder','$accNo','$wid_date','$stat')";
					$of_rtn = mysqli_query($dbconn, $order_form);
					if($of_rtn)
						echo "<script>alert('Form requested successfully.');</script>";
					else
						echo mysqli_error($dbconn);
				}else{
					echo "
					<script>
						alert('You have a pending request form which is in process.  Please be patient. Only one withdraw form at a time.');
					</script>";
				}
			}else
				echo "<script>alert('You do not have enough coins!');</script>";
		}
	?>
</body>
</html>