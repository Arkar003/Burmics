<?php
    require '../dbconfig.php';
    include_once '../controller.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Account setting</title>
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
                <div class="container p-3">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h1 class="text-center">Account Setting</h1>
                        </div>
                        <div class="col-6 rounded bg-light">
                            <?php
                                $sid = $_SESSION['stid'];
                                $get_staffData = "SELECT * FROM staff WHERE staff_id = '$sid'";
                                $gsd_rtn = mysqli_query($dbconn, $get_staffData);
                                $sData = mysqli_fetch_assoc($gsd_rtn);
                            ?>
                            <form method="post">
                                <div class="row p-3 justify-content-center">
                                    <div class="col-5 mb-3">
                                        <label class="form-label" for="staffID">Staff ID : </label>
                                        <input class="form-control" type="text" id="staffID" placeholder="<?php echo $sid; ?>" disabled>
                                    </div>
                                    <div class="col-7 mb-3">
                                        <label class="form-label" for="staffName">Staff Name : </label>
                                        <input class="form-control" type="text" id="staffName" placeholder="<?php echo $sData['full_name']; ?>" disabled>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="staffEmail">Email : </label>
                                        <input class="form-control" type="text" id="staffEmail" name="nEmail" value="<?php echo $sData['email']; ?>">
                                    </div>
                                    <div class="col-7 mb-3">
                                        <label class="form-label" for="nrc">NRC number : </label>
                                        <input class="form-control" type="text" id="nrc" placeholder="<?php echo $sData['nrc']; ?>" disabled>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <label class="form-label" for="sPhone">Phone Number : </label>
                                        <input class="form-control" type="text" id="sPhone" name="nPhone" value="<?php echo $sData['phone_no']; ?>">
                                    </div>
                                    <div class="col-12 mb-5">
                                        <label class="form-label" for="sAddress">Address : </label>
                                        <textarea class="form-control" name="sAddress" id="sAddress" rows="3"><?php echo $sData['address']; ?></textarea>
                                    </div>
                                    <div class="col-3 mb-2">
                                        <button class="btn btn-outline-secondary w-100" type="reset">Reset</button>
                                    </div>
                                    <div class="col-3 mb-2">
                                        <button class="btn btn-primary w-100" type="submit" name="update">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            
                            <div class="container">
                                <form method="post">
                                    <div class="row  rounded bg-light p-3 justify-content-center mb-3">
                                        <h5 class="mb-4">Change password</h5>
                                        <div class="col-12 mb-3 pw-box">
                                            <label class="form-label" for="oldPass">Current Password : </label>
                                            <input class="form-control" type="password" name="oldPass" id="oldPass">
                                            <i class="bi bi-eye-fill ic admin-ic fs-4" id="show-opw"></i>
                                        </div>
                                        <div class="col-12 mb-3 pw-box">
                                            <label class="form-label" for="newPass">New Password : </label>
                                            <input class="form-control" type="password" name="newPass" id="newPass">
                                            <i class="bi bi-eye-fill ic admin-ic fs-4" id="show-npw"></i>
                                        </div>
                                        <div class="col-12 mb-3 pw-box">
                                            <label class="form-label" for="passCon">Confirm New Password : </label>
                                            <input class="form-control" type="password" name="passCon" id="passCon">
                                            <i class="bi bi-eye-fill ic admin-ic fs-4" id="show-pwc"></i>
                                        </div>
                                        <div class="col-3"><button class="btn btn-outline-secondary w-100" type="reset">Reset</button></div>
                                        <div class="col-3"><button class="btn btn-danger w-100" type="submit" name="changePass">Change</button></div>
                                    </div>
                                </form>
                                <div class="row rounded bg-light p-4 justify-content-center">
                                    <div class="col-6 mb-3">
                                        Working for : 
                                            <?php 
                                                $currdate = date('Y-m-d');
                                                $join_date = $sData['join_date'];
                                                $ts1 = strtotime($currdate);
                                                $ts2 = strtotime($join_date);
                                                $dif = $ts1 - $ts2;
                                                $result = floor($dif / (60*60*24));
                                                echo $result;
                                            ?> days
                                    </div>
                                    <div class="col-6 mb-3">Started date : <?php echo $sData['join_date']; ?></div>
                                    <div class="col-12">
                                        status - <span class="text-success">Currently working</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
    <script type="text/javascript">
		var oPass = document.getElementById("oldPass");
		var nPass = document.getElementById("newPass");
		var cPass = document.getElementById("passCon");
		var showOPass = document.getElementById("show-opw");
		var showNPass = document.getElementById("show-npw");
		var showCPass = document.getElementById("show-pwc");

        showOPass.addEventListener("click",function(){
            this.classList.toggle("bi-eye-slash-fill");
            var type = oPass.getAttribute("type") === "password" ?  "text" : "password";
            oPass.setAttribute("type",type);
        })
        showNPass.addEventListener("click",function(){
            this.classList.toggle("bi-eye-slash-fill");
            var type = nPass.getAttribute("type") === "password" ?  "text" : "password";
            nPass.setAttribute("type",type);
        })
        showCPass.addEventListener("click",function(){
            this.classList.toggle("bi-eye-slash-fill");
            var type = cPass.getAttribute("type") === "password" ?  "text" : "password";
            cPass.setAttribute("type",type);
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

        nPass.addEventListener("input", function(event){
			var tar = event.target;
			var pword = tar.value;
			var strength = getPassStrength(pword);
			nPass.classList.remove("strong", "weak");
			nPass.classList.add(strength);
		})
	</script>
	<?php
        if(isset($_REQUEST['update'])){
            //email and ph number needs to check
            $newEmail = $_REQUEST['nEmail'];
            $newNumb = $_REQUEST['nPhone'];
            $newAdd = $_REQUEST['sAddress'];

            $check_valid = "SELECT staff_id FROM staff WHERE email = '$newEmail' OR phone_no = '$newNumb'";
            $cv_rtn = mysqli_query($dbconn,$check_valid);
            if($cv_rtn->num_rows == 0){
                $upd_staff = "UPDATE staff SET email = '$newEmail', phone_no = '$newNumb', address= '$newAdd' WHERE staff_id = '$sid'";
                $upst_rtn = mysqli_query($dbconn, $upd_staff);
                if($upst_rtn)
                    echo "<script>alert('Account updated success');
                    location.assign('accountSetting.php');</script>";
            }else
                echo "<script>alert('Something went wrong! email, nrc or phone number already existed!');</script>";

        }

        if(isset($_REQUEST['changePass'])){
            $get_staffPass = "SELECT password FROM staff WHERE staff_id = '$sid'";
            $gsp_rtn = mysqli_query($dbconn, $get_staffPass);
            $staffData = mysqli_fetch_assoc($gsp_rtn);

            $oldpass = md5($_REQUEST['oldPass']);
            if($oldpass == $staffData['password']){
                $newPass = md5($_REQUEST['newPass']);
                $conPass = md5($_REQUEST['passCon']);
                if($newPass == $conPass){
                    $upd_pass = "UPDATE staff SET password = '$newPass' WHERE staff_id = '$sid'";
                    $up_rtn = mysqli_query($dbconn, $upd_pass);
                    if($up_rtn)
                        echo "<script>alert('Password changing success and new password has been set.');</script>";
                }else
                    echo "<script>alert('New password and confirm password do not match.  Please try again.');</script>";
            }else
                echo "<script>alert('The current password is incorrect! Please try again.');</script>";
        }
    ?>
</body>
</html>