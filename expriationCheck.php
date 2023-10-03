<?php
    require 'dbconfig.php';
    date_default_timezone_set("Asia/Yangon");

    $currDatetime = date('Y-m-d H:i:s');
    $currDate = date('Y-m-d');

    $get_packPurc = "SELECT * FROM package_purchase_rec";
    $gpp_rtn = mysqli_query($dbconn, $get_packPurc);
    if($gpp_rtn->num_rows != 0){
        while($pacPurcInfo = mysqli_fetch_assoc($gpp_rtn)){
            if(($pacPurcInfo['expire_date'] <= $currDatetime) && ($pacPurcInfo['expire_date'] != "0000-00-00 00:00:00")){
                $userID = $pacPurcInfo['user_id'];
                $pprID = $pacPurcInfo['ppr_id'];
                $reset_sts = "UPDATE user SET status = 'free' WHERE user_id = '$userID'";
                $rs_rtn = mysqli_query($dbconn, $reset_sts);
                $reset_exp = "UPDATE package_purchase_rec SET expire_date = '0000-00-00 00:00:00' WHERE ppr_id='$pprID'";
                $re_rtn = mysqli_query($dbconn, $reset_exp);
            }
        }
    }

    $get_lock = "SELECT * FROM locked_chapter";
    $gl_rtn = mysqli_query($dbconn, $get_lock);
    if($gl_rtn->num_rows != 0){
        while($lcData = mysqli_fetch_assoc($gl_rtn)){
            if(($lcData['expire_date'] != "0000-00-00") && ($currDate >= $lcData['expire_date'])){
                $chID = $lcData['chap_id'];
                $lcID = $lcData['lock_id'];
                $reset_chap = "UPDATE chapter SET status = 'published' WHERE chap_id = '$chID'";
                $reset_lc = "UPDATE locked_chapter SET expire_date = '0000-00-00' WHERE lock_id = '$lcID'";
                $rch_rtn = mysqli_query($dbconn,$reset_chap);
                $rlc_rtn = mysqli_query($dbconn,$reset_lc);
            }
        }
    }
?>