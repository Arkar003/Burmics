<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login page</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<form method="post">
		<div class="login-box p-2">
			<div class="mb-2">
				<label class="form-label" for="username">Username</label>
				<input class="form-control" type="text" name="username" id="username">
			</div>
			<div class="mb-2 pw-box">
				<label class="form-label" for="password">Password</label>
				<input class="form-control" type="password" name="password" id="password" required>
                <i class="bi bi-eye-fill ic fs-4" id="show-pass"></i>
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
	<script type="text/javascript">
		var pwd = document.getElementById("password");
        var showPwd = document.getElementById("show-pass");

        showPwd.addEventListener("click",function(){
            this.classList.toggle("bi-eye-slash-fill");
            var type = pwd.getAttribute("type") === "password" ?  "text" : "password";
            pwd.setAttribute("type",type);
        })
	</script>
	<?php 
		require 'dbconfig.php';
		if(isset($_REQUEST['login'])){
			$uname = $_REQUEST['username'];
			$pwd = md5($_REQUEST['password']);

			//fetching user_id from database
			$fetch_uid = "SELECT user_id, username, acc_type, user_icon, wallet_id FROM user WHERE username = '$uname' AND password = '$pwd'";
			$fetch_uid_return = mysqli_query($dbconn, $fetch_uid);

			$user_info = mysqli_fetch_assoc($fetch_uid_return);

			if($fetch_uid_return->num_rows == 1){
				$_SESSION['uid'] = $user_info['user_id'];
				$_SESSION['uname'] = $user_info['username'];
				$_SESSION['acctype'] = $user_info['acc_type'];
				$_SESSION['uicon'] = $user_info['user_icon'];
				$_SESSION['wid'] = $user_info['wallet_id'];

				echo "<script>alert('login success');
					window.location.assign('home.php');</script>";
			}
			else

				echo "<script>alert('Login fail. Incorrect username or incorrect password. Please try again!');</script>";

		}
	 ?>

</body>
</html>