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
    function getChapID($cno, $sid){
        require 'dbconfig.php';
        $fet_cid = "SELECT chap_id FROM chapter WHERE series_id = '$sid' AND chap_no = '$cno'";
        $fcid_rtn = mysqli_query($dbconn, $fet_cid);
        $chapData = mysqli_fetch_assoc($fcid_rtn);
        return $chapData['chap_id'];
    }
    function getChapNo($cid, $sid){
        require 'dbconfig.php';
        $fet_cno = "SELECT chap_no FROM chapter WHERE series_id = '$sid' AND chap_id = '$cid'";
        $fcno_rtn = mysqli_query($dbconn, $fet_cno);
        $chapData = mysqli_fetch_assoc($fcno_rtn);
        return $chapData['chap_no'];
    }
    function getSeriesId($sname){
        require 'dbconfig.php';
        $fet_sid = "SELECT series_id FROM series WHERE series_name = '$sname'";
        $fsid_rtn = mysqli_query($dbconn, $fet_sid);
        $sid = mysqli_fetch_assoc($fsid_rtn);
        return $sid['series_id'];
    }
    function getSeriesName($sid){
        require 'dbconfig.php';
        $fet_sname = "SELECT series_name FROM series WHERE series_id = '$sid'";
        $fsn_rtn = mysqli_query($dbconn, $fet_sname);
        $sname = mysqli_fetch_assoc($fsn_rtn);
        return $sname['series_name'];
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
    function incCount($cid, $cdate){
        require 'dbconfig.php';
        $getCount = "UPDATE ch_view_count SET views = views + 1, last_update = '$cdate' WHERE chap_id = '$cid'";
        $gC_rtn = mysqli_query($dbconn, $getCount);
        return;
    }
    function hasBoughtEA($cid, $uid){
        require 'dbconfig.php';
        $check = "SELECT * FROM ea_purchase_rec E INNER JOIN locked_chapter L ON E.lock_id = L.lock_id WHERE L.chap_id = '$cid' AND E.user_id='$uid'";
        $rtn = mysqli_query($dbconn, $check);
        if($rtn->num_rows == 1)
            return true;
        else
            return false;
    }
    function isNxtLocked($cid, $sid, $uid){
        require 'dbconfig.php';
        $curChap = getChapNo($cid,$sid);
        if($curChap != getLastChap($sid)){
            $numb = intval(substr($curChap, 5));
            $numb++;
            $nextCh = "Chap " . $numb;
            $ncid = getChapID($nextCh,$sid);
            $c_lock = "SELECT * FROM chapter WHERE chap_id = '$ncid' AND status='locked'";
            $rtn = mysqli_query($dbconn, $c_lock);
            if($rtn->num_rows == 1){
                if(hasBoughtEA($ncid, $uid))
                    return false;
                else
                    return true;
            }else
                return false;
        }else
            return false;
    }
    function isNxtPub($cno, $sid){
        require 'dbconfig.php';
        if($cno != getLastChap($sid)){
            $numb = intval(substr($cno, 5));
            $numb++;
            $nextCh = "Chap " . $numb;
            $ncid = getChapID($nextCh,$sid);
            $c_pub = "SELECT * FROM chapter WHERE chap_id = '$ncid' AND status='published'";
            $rtn = mysqli_query($dbconn, $c_pub);
            if($rtn->num_rows == 1)
                return true;
            else
                return false;
        }else
            return false;
    }
    function alrdySaved($uid, $sname){
        require 'dbconfig.php';
        $fet_lib = "SELECT * FROM library WHERE user_id = '$uid'";
        $flib_rtn = mysqli_query($dbconn, $fet_lib);
        $libInfo = mysqli_fetch_assoc($flib_rtn);
        if($libInfo['series_names'] == "")
            return false;
        else{
            $seriesNames = json_decode($libInfo['series_names'], true);
            if(in_array($sname, $seriesNames))
                return true;
            else
                return false;
        }
    }
?>