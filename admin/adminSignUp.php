<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Sign up</title>
	<link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-2 bg-light pe-0">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-10 bg-secondary-subtle px-5">
                <div class="p-3">
                    <div class="row">
                        <div class="text-center mb-3">
                            <h3>Register new admin account</h3>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-8 bg-light rounded p-3">
							<form method="post">
								<div class="register-box rounded p-2">
									<div class="mb-2">
										<label class="form-label" for="fname">Full name</label>
										<input class="form-control" type="text" name="fname" id="fname">
									</div>
									<div class="mb-2">
										<label class="form-label" for="sEmail">Email</label>
										<input class="form-control" type="email" name="sEmail" id="sEmail">
									</div>
									<div class="mb-2 pw-box">
										<label class="form-label" for="pword">Password</label>
										<input class="form-control" type="password" name="pword" id="pword">
										<i class="bi bi-eye-fill ic fs-4" id="show-pw"></i>
									</div>
									<div class="mb-2">
										<label class="form-label" for="phone">Phone Number</label>
										<input class="form-control" type="text" name="phone" id="phone">
									</div>

									<div class="mb-2">
										<label class="form-label" for="nrc">NRC Number:</label>
										<input class="form-control" type="text" name="nrc" id="nrc">
									</div>
									<div class="mb-3">
										<label class="form-label" for="address">Enter Address :</label>
										<textarea class="form-control" name="address" id="address" rows="3"></textarea>
									</div>
									<div class="mb-2 row">
										<div class="col">
											<button class="btn btn-outline-primary w-100" type="reset" values="reset" name="cancel">Cancel</button>
										</div>
										<div class="col">
											<button class="btn btn-primary w-100" type="submit" values="submit" name="register">Register</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<script type="text/javascript">
		var pass = document.getElementById("pword");
		var showPass = document.getElementById("show-pw");

        showPass.addEventListener("click",function(){
            this.classList.toggle("bi-eye-slash-fill");
            var type = pass.getAttribute("type") === "password" ?  "text" : "password";
            pass.setAttribute("type",type);
        })

		function getPassStrength(pw){
			var lenCheck = /.{8,}/;
			var lowUpCheck = /(?=.*[a-z])(?=.*[A-Z])/;
			var ltrNumCheck = /(?=.*[a-zA-Z])(?=.*\d)/;
			var symbolCheck = /[\[\]\(\)\{\}\*\!\+\?\^\$\.\\\-#:;,_`~%'"@/]/;
			if(pw.match(lenCheck) && pw.match(lowUpCheck) && pw.match(ltrNumCheck) && pw.match(symbolCheck))
				return "strong";
			else
				return "weak";
		}

		pass.addEventListener("input", function(event){
			var tar = event.target;
			var pword = tar.value;
			var strength = getPassStrength(pword);
			pass.classList.remove("strong", "weak");
			pass.classList.add(strength);
		})
	</script>
	<?php 
		require '../dbconfig.php';
		date_default_timezone_set("Asia/Yangon");

		if(isset($_REQUEST['register'])){
			$name = $_REQUEST['fname'];
			$email = $_REQUEST['sEmail'];
			$pword = md5($_REQUEST['pword']);
			$phone = $_REQUEST['phone'];
			$nrc = $_REQUEST['nrc'];
			$address = $_REQUEST['address'];
			$s_date = date('Y-m-d');
			$f_sdata = "SELECT email, phone_no, nrc FROM staff WHERE email = '$email' OR phone_no = '$phone' OR nrc = '$nrc'";
			$fsdata_rtn = mysqli_query($dbconn, $f_sdata);
			if($fsdata_rtn->num_rows == 0){
				    $fetch_sid = "SELECT staff_id FROM staff ORDER BY staff_id DESC LIMIT 1";
					$fsid_rtn = mysqli_query($dbconn, $fetch_sid);
					if($fsid_rtn->num_rows == 0){
						$s_id = 'SID00001';
					}
					else{
						$staff_data = mysqli_fetch_assoc($fsid_rtn);
						$fetched_sid = $staff_data['staff_id'];
						$s_id = ++$fetched_sid;
					}
					$create_staff = "INSERT INTO staff VALUES ('$s_id', '$name', '$email', '$pword', '$phone', '$nrc', '$address', '$s_date')";
					$cs_rtn = mysqli_query($dbconn, $create_staff);
					if($cs_rtn)
						echo "<script>alert('Create staff acc success.');</script>";
					else
						echo mysqli_error($dbconn);
			} 
			else{
				echo "<script>alert('Something went wrong! email, nrc or phone number already existed!');</script>";
			}
		}
	 ?>
</body>
</html>