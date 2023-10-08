<?php
    require 'dbconfig.php';
    include_once 'controller.php';
    date_default_timezone_set("Asia/Yangon");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
    <?php
        $get_pack = "SELECT * FROM package";
        $gpack_rtn = mysqli_query($dbconn, $get_pack);
    ?>
    <form method="post">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-info-subtle p-4 rounded text-center mb-3">
                        <p class="m-0 p-0">By purchasing premium package, you will have the <b>unlimited access</b> for reading chapters for a specific time.  <i>This doesn't mean you will have access to locked chapter.  You will still need to buy early access for that locked chapter.</i></p>
                    </div>
                </div>
                <div class="col-12 px-5">
                    <?php
                        if($gpack_rtn->num_rows == 0 ){
                    ?>
                    <div class="bg-warning rounded p-3 px-5">
                        <h4>Packages are not available at the moment.</h4>
                    </div>
                    <?php
                        }else{
                            while($packData = mysqli_fetch_assoc($gpack_rtn)){
                    ?>
                    <div class="form-check ps-0">
                        <input class="btn-check" type="radio" name="package" id="<?php echo $packData['package_id']; ?>" value="<?php echo $packData['package_id']; ?>" autocomplete="off">
                        <label class="btn btn-outline-primary w-100 mb-3" for="<?php echo $packData['package_id']; ?>">
                            <div class="d-flex p-2">
                                <div class="w-50 text-start">
                                    <h5 class="m-0"><?php echo $packData['package_name']; ?></h5>
                                </div>
                                <div class="w-50 text-end">
                                    <h5 class="m-0"><?php echo $packData['price']; ?> Coins</h5>
                                </div>
                            </div>
                        </label>
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>
                <div class="col-12">
                    <div class="text-center">
                        <button class="btn btn-outline-secondary" type="reset">Cancel</button>
                        <button class="btn btn-primary" type="submit" name="purcPack">Purchase</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
        if(isset($_REQUEST['purcPack'])){
            $userID = $_SESSION['uid'];
            $packID = $_REQUEST['package'];
            $currDate = date('Y-m-d H:i:s');

            $get_pacDu = "SELECT * FROM package WHERE package_id = '$packID'";
            $gpdu_rtn = mysqli_query($dbconn, $get_pacDu);
            $packINFO = mysqli_fetch_assoc($gpdu_rtn);
            $dura = $packINFO['duration_day'];
            $price = $packINFO['price'];

            if(getCoins($userID) >= $price){
                $get_purcRec = "SELECT * FROM package_purchase_rec ORDER BY ppr_id DESC LIMIT 1";
                $gpr_rtn = mysqli_query($dbconn,$get_purcRec);
                if($gpr_rtn->num_rows == 0)
                    $pRecID = "PP000001";
                else{
                    $purcRecInfo = mysqli_fetch_assoc($gpr_rtn);
                    $lastpprID = $purcRecInfo['ppr_id'];
                    $pRecID = ++$lastpprID;
                }

                $check_active = "SELECT * FROM package_purchase_rec WHERE user_id = '$userID' AND expire_date != '0000-00-00 00:00:00'";
                $ca_rtn = mysqli_query($dbconn, $check_active);
                if($ca_rtn->num_rows == 0)
                    $exp_date = date('Y-m-d H:i:s', strtotime('+'.$dura.' day',strtotime($currDate)));
                else{
                    $last_active = mysqli_fetch_assoc($ca_rtn);
                    $last_exp = $last_active['expire_date'];
                    $exp_date = date('Y-m-d H:i:s', strtotime('+'.$dura.' day',strtotime($last_exp)));
                }
                $add_prRow = "INSERT INTO package_purchase_rec VALUES ('$pRecID','$userID','$packID','$currDate','$exp_date')";
                $apr_rtn = mysqli_query($dbconn,$add_prRow);

                $user_update = "UPDATE user SET status = 'premium' WHERE user_id = '$userID'";
                $uup_rtn = mysqli_query($dbconn,$user_update);

                if($apr_rtn && $uup_rtn){
                    echo "<script>alert('Packpage purchase successfully.');</script>";
                    reduce_coin($userID,$price);
                }
                else
                    echo mysqli_error($dbconn);
            }else
                echo "<script>alert('You do not have enough coins.');</script>";
        }
    ?>
</body>
</html>