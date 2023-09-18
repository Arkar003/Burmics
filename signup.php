<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign up page</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript">
		function ph_box(x){
			if (x == 0)
				document.getElementById("phone_numb").style.display = "block";
			else
				document.getElementById("phone_numb").style.display = "none";
			return;
		}
	</script>
</head>
<body>
	<form method="post">
		<div class="register-box p-2">
			<div class="mb-2">
				<label class="form-label" for="uname">Username</label>
				<input class="form-control" type="text" name="uname" id="uname" required>
			</div>
			<div class="mb-2">
				<label class="form-label" for="uemail">Email</label>
				<input class="form-control" type="email" name="uemail" id="uemail" required>
			</div>
			<div class="mb-2 pw-box">
				<label class="form-label" for="pword">Password</label>
				<input class="form-control" type="password" name="pword" id="pword" required>
                <i class="bi bi-eye-fill ic fs-4" id="show-pw"></i>
			</div>
			<div class="mb-2">
				<select class="form-select" name="u_age" required>
					<option selected value="">Select your age</option>
					<option value="below_16">Below 16</option>
					<option value="16_to_18">Between 16 & 18</option>
					<option value="above_18">Above 18</option>
				</select>
			</div>
			<div class="mb-2 d-flex">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="acctype" id="reader" value="reader" onclick="ph_box(1)" checked>
					<label class="form-check-label" for="reader">Reader</label>
				</div>
				<div class="form-check ms-3">
					<input class="form-check-input" type="radio" name="acctype" id="creator" value="creator" onclick="ph_box(0)">
					<label class="form-check-label" for="creator">Creator</label>
				</div>
			</div>
			<div class="mb-2" id="phone_numb" style="display: none;">
				<label class="form-label" for="phone">Phone Number</label>
				<input class="form-control" type="text" name="phone" id="phone">
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

	<script type="text/javascript">
		var pass = document.getElementById("pword");
        var showPass = document.getElementById("show-pw");

        showPass.addEventListener("click",function(){
            this.classList.toggle("bi-eye-slash-fill");
            var type = pass.getAttribute("type") === "password" ?  "text" : "password";
            pass.setAttribute("type",type);
        })

		pass.addEventListener("input", function(event){
			var tar = event.target;
			var pword = tar.value;
			var strenght = 0;

			var lenCheck = /.{8,}/;
			var lowUpCheck = /(?=.*[a-z])(?=.*[A-Z])/;
			var ltrNumCheck = /(?=.*[a-zA-Z])(?=.*\d)/;
			var symbolCheck = /[\[\]\(\)\{\}\*\!\+\?\^\$\.\\\-#:;,_`~%'"@/]/;

			pass.classList.remove("strong", "weak");
			if(pword.match(lenCheck) && pword.match(lowUpCheck) && pword.match(ltrNumCheck) && pword.match(symbolCheck))
				pass.classList.add("strong");
			else
				pass.classList.add("weak");
		})
	</script>


	<?php 
		require 'dbconfig.php';
		date_default_timezone_set("Asia/Yangon");

		if(isset($_REQUEST['register'])){
			$uname = $_REQUEST['uname'];
			$email = $_REQUEST['uemail'];
			$age = $_REQUEST['u_age'];
			$type = $_REQUEST['acctype'];
			$c_date = date('Y-m-d');
			$phone = $_REQUEST['phone'];

            $pw = $_REQUEST['pword'];
            $uppercase = preg_match('@[A-Z]@', $pw);
            $lowercase = preg_match('@[a-z]@', $pw);
            $number    = preg_match('@[0-9]@', $pw);
            $specialChars = preg_match('@[^\w]@', $pw);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pw) < 8) {
                echo "<script>alert('Your password is weak. A strong password should be at least 8 characters in length and must include at least one upper case letter, one number, and one special character.')</script>";
            }else{
                $password = md5($_REQUEST['pword']);
                $fet_uname = "SELECT username FROM user WHERE username = '$uname'";//fetching_username
                $fet_name_rtn = mysqli_query($dbconn, $fet_uname);

                $fet_email = "SELECT email FROM user WHERE email = '$email'";//fetching user email
                $fet_email_rtn = mysqli_query($dbconn, $fet_email);

                if($fet_name_rtn->num_rows == 0 && $fet_email_rtn->num_rows == 0){
                    $fetch_uid = "SELECT user_id, wallet_id FROM user ORDER BY user_id DESC LIMIT 1";
                    $fetch_uid_rtn = mysqli_query($dbconn, $fetch_uid);

                    if($fetch_uid_rtn->num_rows == 0){
                        $u_id = 'U0000001'; //setting the user id
                        $w_id = 'W0000001'; //setting the wallet id
                    }
                    else{
                        $userdata = mysqli_fetch_assoc($fetch_uid_rtn);
                        $fetched_uid = $userdata['user_id'];
                        $fetched_wid = $userdata['wallet_id'];
                        $u_id = ++$fetched_uid;
                        $w_id = ++$fetched_wid;
                    }

                    $create_wallet = "INSERT INTO wallet (wallet_id) VALUES ('$w_id')"; //creating wallet
                    $cw_rtn = mysqli_query($dbconn, $create_wallet);

                    $create_user_acc = "INSERT INTO user (user_id, username, email, password, age, acc_type, create_date, wallet_id) VALUES ('$u_id', '$uname', '$email', '$password', '$age', '$type', '$c_date', '$w_id')";
                    $cu_rtn = mysqli_query($dbconn, $create_user_acc);

                    if($cu_rtn)
                        echo "<script>alert('Create user account success.');</script>";
                    else
                        echo mysqli_error($dbconn);

                    if($type == 'creator'){
                        $fet_cid = "SELECT creator_id FROM creator ORDER BY creator_id DESC LIMIT 1";
                        $fc_rtn = mysqli_query($dbconn, $fet_cid);

                        if($fc_rtn->num_rows == 0)
                            $cid = 'C0000001';
                        else{
                            $cData = mysqli_fetch_assoc($fc_rtn);
                            $fetched_cid = $cData['creator_id'];
                            $cid = ++$fetched_cid;
                        }

                        $create_c_acc = "INSERT INTO creator (creator_id, user_id, phone_no) VALUES ('$cid', '$u_id', '$phone')"; //creating creator accoutn
                        $create_c_rtn = mysqli_query($dbconn, $create_c_acc);

                        if($create_c_rtn)
                            echo "<script>alert('Create creator account success.');</script>";
                        else
                            echo mysqli_error($dbconn);
                    }
                }
                else{
                    if($fet_name_rtn->num_rows == 1)
                        echo "<script>alert('Username already exists! try another one.');</script>";
                    else
                        echo "<script>alert('Email already used! try another one.');</script>";
                }
            }
		}
	 ?>
</body>
</html>