<?php 
	require 'dbconfig.php';
	date_default_timezone_set("Asia/Yangon");
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
		function calMMK(rate){
			var coin = parseFloat(document.getElementById("coin_amt").value);
			if(isNaN(coin))
                coin = 0;
			var result = coin * parseFloat(rate);
			document.getElementById("mmk_amt").value = result;
		}
	</script>
</head>
<body>
	<?php 
		$get_rate = "SELECT rate_per_coin FROM exchange_rate WHERE er_type='PURC'";
		$rtn = mysqli_query($dbconn, $get_rate);
		$rateInfo = mysqli_fetch_assoc($rtn);
	 ?>
	<form enctype="multipart/form-data" method="post">
		<div class="container">
			<div class="mb-3 row">
				<div class="text-center bg-success-subtle rounded p-3">
					<h4>Current price</h4>
					<p class="m-0">
						1 coin ~ <?php echo $rateInfo['rate_per_coin'] ?> MMK
					</p>
				</div>
			</div>
			<div class="mb-3 row">
				<div class="col-5">
					<div class="input-group">
						<input class="form-control" type="number" name="coin_amt" id="coin_amt" oninput="calMMK('<?php echo $rateInfo['rate_per_coin']; ?>')">
						<span class="input-group-text" for="coin_amt">Coins</span>
					</div>
				</div>
				<div class="col-2 text-center">
					<h4><i class="bi bi-arrow-right"></i></h4>
				</div>
				<div class="col-5">
					<div class="input-group">
						<input class="form-control" type="number" name="mmk_amt" id="mmk_amt" value="" disabled>
						<span class="input-group-text" for="mmk_amt">MMK</span>
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
			<div class="mb-5 row" id="payDetail" style="display: none;">
				<div>
					<table class="table">
						<tr>
							<td>Acc holder name</td>
							<td id="hname"></td>
						</tr>
						<tr>
							<td>Acc number</td>
							<td id="accNumb"></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="mb-3 row">
				<div>
					<label class="form-label" for="payss">Upload screenshot of paycheck</label>
					<input class="form-control" type="file" name="payss" id="payss" accept="image/*">
				</div>
			</div>
			<div class="mb-3 row">
				<div class="text-center">
					<button class="btn btn-outline-secondary" type="reset">Cancel</button>
					<button class="btn btn-primary" type="submit" name="makeOrder">Order</button>
				</div>
			</div>

		</div>
	</form>
	<?php 
		if(isset($_REQUEST['makeOrder'])){
			$uid = $_SESSION['uid'];
			$camt = $_REQUEST['coin_amt'];
			$mul = $rateInfo['rate_per_coin'];
			$amt = $camt * $mul;
			$cpDate = date('Y-m-d H:i:s');
			$payID = $_REQUEST['paymethod'];
			$payImg = $_FILES['payss']['name'];
			$payImgDir = $_FILES['payss']['tmp_name'];
			$sts = "Pending";

			$f_order = "SELECT cpr_id FROM coin_purchase_rec WHERE user_id = '$uid' AND status = '$sts'";
			$fo_rtn = mysqli_query($dbconn, $f_order);

			if($fo_rtn->num_rows == 0){
				$f_oid = "SELECT cpr_id FROM coin_purchase_rec ORDER BY cpr_id DESC LIMIT 1";
				$foid_rtn = mysqli_query($dbconn, $f_oid);
				if($foid_rtn->num_rows == 0){
					$orderId = 'CP00000001';
				}
				else{
					$orderInfo = mysqli_fetch_assoc($foid_rtn);
					$last_oid = $orderInfo['cpr_id'];
					$orderId = ++$last_oid;
				}

				$ssDiv = explode('.', $payImg);
				$ssExt = strtolower(end($ssDiv));

				$paySsName = $orderId . '.' . $ssExt;

				$crt_order = "INSERT INTO coin_purchase_rec (cpr_id, user_id, coin_amount, amount, cp_date, pm_id, payment_ss, status) VALUES ('$orderId','$uid','$camt','$amt','$cpDate','$payID','$paySsName','$sts')";
				$crtOrder_rtn = mysqli_query($dbconn, $crt_order);

				if($crtOrder_rtn){
					move_uploaded_file($payImgDir, "data/coin_purchase/$paySsName");
					echo "<script>alert('Order success.');</script>";
				}
			}
			else{
				echo "<script>alert('You have an order already in pending. Please be patient.  Only one coin purchase order at a time.');</script>";
			}
		}
	?>

	<script type="text/javascript">
		document.getElementById("paymethod").addEventListener("change",function(){
			var sltOpt = this.options[this.selectedIndex];
			var sltVal = sltOpt.value;

			if(sltVal != "")
				document.getElementById("payDetail").style.display = "block";
			else
				document.getElementById("payDetail").style.display = "none";

			$.ajax({
                    url: 'getPmHolder.php',
                    type: 'POST',
                    data: { id: sltVal },
                    success: function(response) {
                        document.getElementById("hname").textContent = response;
                    }
                });


			$.ajax({
                    url: 'getPmAcc.php',
                    type: 'POST',
                    data: { id: sltVal },
                    success: function(response) {
                        document.getElementById("accNumb").textContent = response;
                    }
                });
		});
	</script>
</body>
</html>