<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login page</title>
	<link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">

</head>
<body>
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-6 border border-dark rounded p-5">
				<div class="text-center fs-2">
					<h3>Login as Admin</h3>
				</div>
				<form method="post">
					<div class="login-box rounded p-2 mt-4">
						<div class="mb-2">
							<label class="form-label" for="semail">Email</label>
							<input class="form-control" type="email" name="semail" id="semail">
						</div>
						<div class="mb-2">
							<label class="form-label" for="pword">Password</label>
							<input class="form-control" type="password" name="pword" id="pword">
						</div>
						<div class="mt-5 row">
							<div class="col">
								<button class="btn btn-outline-primary w-100" type="reset" values="reset" name="cancel">Cancel</button>
							</div>
							<div class="col">
								<button class="btn btn-primary w-100" type="submit" values="submit" name="login">Login</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			
		</div>
		
	</div>

	<?php 
		require '../dbconfig.php';
		session_start();

		if(isset($_REQUEST['login'])){
			$semail = $_REQUEST['semail'];
			$pwd = md5($_REQUEST['pword']);

			//fetching staff id from database
			$fetch_sid = "SELECT staff_id, full_name FROM staff WHERE email = '$semail' AND password = '$pwd'";
			$fsid_return = mysqli_query($dbconn, $fetch_sid);

			$user_info = mysqli_fetch_assoc($fsid_return);

			if($fsid_return->num_rows == 1){
				$_SESSION['stid'] = $user_info['staff_id'];
				$_SESSION['name'] = $user_info['full_name'];
				echo "<script>alert('login success');
						window.location.assign('dashboard.php');</script>";
			}
			else
				echo "<script>alert('Login fail.');</script>";

		}
	 ?>

</body>
</html>