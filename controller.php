<?php
    function getCreatorId($user_id){
        require 'dbconfig.php';
        $fetch_cid = "SELECT creator_id FROM creator WHERE user_id = '$user_id'";
        $fet_rtn = mysqli_query($dbconn, $fetch_cid);
        $c_info = mysqli_fetch_assoc($fet_rtn);
        $cid = $c_info['creator_id'];
        return $cid;
    }
    function getUserId($creator_id){
        require 'dbconfig.php';
        $fet_uid = "SELECT user_id FROM creator WHERE creator_id = '$creator_id'";
        $fui_rtn = mysqli_query($dbconn, $fet_uid);
        $u_info = mysqli_fetch_assoc($fui_rtn);
        $uid = $u_info['user_id'];
        return $uid;
    }
    function getUserName($user_id){
        require 'dbconfig.php';
        $fet_uname = "SELECT username FROM user WHERE user_id = '$user_id'";
        $fu_rtn = mysqli_query($dbconn, $fet_uname);
        $u_info = mysqli_fetch_assoc($fu_rtn);
        $uName = $u_info['username'];
        return $uName;
    }
    function getStaffName($staff_id){
        require 'dbconfig.php';
        $fet_sname = "SELECT full_name FROM staff WHERE staff_id = '$staff_id'";
        $fs_rtn = mysqli_query($dbconn, $fet_sname);
        $s_info = mysqli_fetch_assoc($fs_rtn);
        $sName = $s_info['full_name'];
        return $sName;
    }
    function getCoins($user_id){
        require 'dbconfig.php';
        $fet_wall = "SELECT W.amount FROM wallet W INNER JOIN user U ON W.wallet_id = U.wallet_id WHERE U.user_id = '$user_id'";
        $fw_rtn = mysqli_query($dbconn, $fet_wall);
        $wallInfo = mysqli_fetch_assoc($fw_rtn);
        $coins = $wallInfo['amount'];
        return $coins;
    }
    function getLastChap($sid){
        require 'dbconfig.php';
        $fet_lc = "SELECT chap_no FROM chapter WHERE series_id = '$sid' ORDER BY upload_date DESC LIMIT 1";
        $flc_rtn = mysqli_query($dbconn, $fet_lc);
        $chapData = mysqli_fetch_assoc($flc_rtn);
        return $chapData['chap_no'];
    }
    function getFirstChap($sid){
        require 'dbconfig.php';
        $fet_lc = "SELECT chap_no FROM chapter WHERE series_id = '$sid' ORDER BY upload_date ASC LIMIT 1";
        $flc_rtn = mysqli_query($dbconn, $fet_lc);
        $chapData = mysqli_fetch_assoc($flc_rtn);
        return $chapData['chap_no'];
    }
    function getSeriesId($sname){
        require 'dbconfig.php';
        $fet_sid = "SELECT series_id FROM series WHERE series_name = '$sname'";
        $fsid_rtn = mysqli_query($dbconn, $fet_sid);
        $sid = mysqli_fetch_assoc($fsid_rtn);
        return $sid['series_id'];
    }
    function add_coin($uid, $amt){
        require 'dbconfig.php';
        $get_wallet = "SELECT W.wallet_id, W.amount FROM user U INNER JOIN wallet W ON U.wallet_id = W.wallet_id WHERE user_id = '$uid'";
        $gw_rtn = mysqli_query($dbconn, $get_wallet);
        $walletInfo = mysqli_fetch_assoc($gw_rtn);
        $wallID = $walletInfo['wallet_id'];
        $ogAmt = $walletInfo['amount'];
        $updated_amt = $ogAmt + $amt;
        $update_coin = "UPDATE wallet SET amount = '$updated_amt' WHERE wallet_id = '$wallID'";
        $upC_rtn = mysqli_query($dbconn, $update_coin);
        return;
    }
    function reduce_coin($uid, $amt){
        require 'dbconfig.php';
        $get_wallet = "SELECT W.wallet_id, W.amount FROM user U INNER JOIN wallet W ON U.wallet_id = W.wallet_id WHERE user_id = '$uid'";
        $gw_rtn = mysqli_query($dbconn, $get_wallet);
        $walletInfo = mysqli_fetch_assoc($gw_rtn);
        $wallID = $walletInfo['wallet_id'];
        $ogAmt = $walletInfo['amount'];
        $reduced_amt = $ogAmt - $amt;
        $up_coin = "UPDATE wallet SET amount = '$reduced_amt' WHERE wallet_id = '$wallID'";
        $upc_rtn = mysqli_query($dbconn, $up_coin);
        return;
    }
?>