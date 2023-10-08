<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EA purhcase</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        $get_lc = "SELECT * FROM locked_chapter WHERE chap_id = '$chID'";
        $glc_rtn = mysqli_query($dbconn, $get_lc);
        $lcDetails = mysqli_fetch_assoc($glc_rtn);
        $lcID = $lcDetails['lock_id'];
    ?>
    <div class="container">
        <p class="text-center">The chapter is locked at the moment <br> but will be release for free at <?php echo $lcDetails['expire_date']; ?>. <br> If you can't wait and want to read it now, <br> you can purchase the early access for this chapter.</p>
        <p class="text-center mt-2"><b>Want to purchase this chapter for <?php echo $lcDetails['price']; ?> coin?</b></p>
        <div class="text-center">
			<form method="post">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="pEA">Purchase</button>
			</form>
		</div>
		<?php
			if(isset($_REQUEST['pEA'])){
                require 'dbconfig.php';
                date_default_timezone_set("Asia/Yangon");

                $cost = $lcDetails['price'];
                $curDate = date('Y-m-d H:i:s');
                $uCoin = getCoins($uID);
                if($uCoin >= $cost){
                    $get_ea = "SELECT * FROM ea_purchase_rec ORDER BY eap_id DESC LIMIT 1";
                    $gea_rtn = mysqli_query($dbconn, $get_ea);
                    if($gea_rtn->num_rows == 0)
                        $eaID = "EAP00001";
                    else{
                        $eaD = mysqli_fetch_assoc($gea_rtn);
                        $eaID = ++$eaD['eap_id'];
                    }
                    
                    $add_ea = "INSERT INTO ea_purchase_rec VALUES ('$eaID','$uID','$lcID','$curDate')";
                    $ae_rtn = mysqli_query($dbconn, $add_ea);
                    if($ae_rtn){
                        reduce_coin($uID,$cost);
                        echo "<script>alert('Early Access Purchase success.');
                                    location.assign('series.php?sid=$seriesID');</script>";
                    }else
                        echo mysqli_error($dbconn);
                }else
                    echo "<script>alert('Not enough coin to purchase this!');</script>";
        
                
            }
		?>
    </div>
</body>
</html>