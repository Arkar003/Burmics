<?php
    function getCreatorId($user_id){
        require 'dbconfig.php';
        $fetch_cid = "SELECT creator_id FROM creator WHERE user_id = '$user_id'";
        $fet_rtn = mysqli_query($dbconn, $fetch_cid);
        $c_info = mysqli_fetch_assoc($fet_rtn);
        return $c_info['creator_id'];
    }
    function getUserId($creator_id){
        require 'dbconfig.php';
        $fet_uid = "SELECT user_id FROM creator WHERE creator_id = '$creator_id'";
        $fui_rtn = mysqli_query($dbconn, $fet_uid);
        $u_info = mysqli_fetch_assoc($fui_rtn);
        return $u_info['user_id'];
    }
    function getUserName($user_id){
        require 'dbconfig.php';
        $fet_uname = "SELECT username FROM user WHERE user_id = '$user_id'";
        $fu_rtn = mysqli_query($dbconn, $fet_uname);
        $u_info = mysqli_fetch_assoc($fu_rtn);
        return $u_info['username'];
    }
    function getStaffName($staff_id){
        require 'dbconfig.php';
        $fet_sname = "SELECT full_name FROM staff WHERE staff_id = '$staff_id'";
        $fs_rtn = mysqli_query($dbconn, $fet_sname);
        $s_info = mysqli_fetch_assoc($fs_rtn);
        return $s_info['full_name'];
    }
    function getCoins($user_id){
        require 'dbconfig.php';
        $fet_wall = "SELECT W.amount FROM wallet W INNER JOIN user U ON W.wallet_id = U.wallet_id WHERE U.user_id = '$user_id'";
        $fw_rtn = mysqli_query($dbconn, $fet_wall);
        $wallInfo = mysqli_fetch_assoc($fw_rtn);
        return $wallInfo['amount'];
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
    function isFreeAcc($uid){
        require 'dbconfig.php';
        $get_data = "SELECT status FROM user WHERE user_id = '$uid'";
        $gd_rtn = mysqli_query($dbconn, $get_data);
        $uData = mysqli_fetch_assoc($gd_rtn);
        if($uData['status'] == "free")
            return true;
        else
            return false;
    }
    function checkOverLimit($uid){
        require 'dbconfig.php';
        date_default_timezone_set("Asia/Yangon");
        $curDate = date('Y-m-d');
        $get_rec = "SELECT * FROM chap_read_track WHERE user_id = '$uid' AND DATE(read_date) = '$curDate'";
        $gr_rtn = mysqli_query($dbconn, $get_rec);
        if($gr_rtn->num_rows < 10)
            return false;
        else
            return true;
    }
    function getWarningCount($uid){
        require 'dbconfig.php';
        $get_counts = "SELECT COUNT(ban_id) AS count FROM bannedList WHERE user_id = '$uid' AND status='Warning'";
        $rtn = mysqli_query($dbconn,$get_counts);
        if($rtn->num_rows == 0)
            return 0;
        else{
            $data = mysqli_fetch_assoc($rtn);
            return $data['count'];
        }
    }
    function isBanned($uid){
        require 'dbconfig.php';
        $check_banned = "SELECT * FROM bannedList WHERE user_id = '$uid' AND status = 'Banned' AND release_date != '0000-00-00'";
        $rtn = mysqli_query($dbconn, $check_banned);
        if($rtn->num_rows == 0)
            return false;
        else
            return true;
    }
    function getTotalViews($sid){
        require 'dbconfig.php';
        $getView = "SELECT SUM(V.views) AS totalViews FROM ch_view_count V INNER JOIN chapter C ON V.chap_id = C.chap_id WHERE C.series_id = '$sid'";
        $gv_rtn = mysqli_query($dbconn, $getView);
        $viewDetail = mysqli_fetch_assoc($gv_rtn);
        return $viewDetail['totalViews'];
    }
    function getChapterViews($cid){
        require 'dbconfig.php';
        $getChView = "SELECT views FROM ch_view_count WHERE chap_id = '$cid'";
        $rtn = mysqli_query($dbconn, $getChView);
        $views = mysqli_fetch_assoc($rtn);
        return $views['views'];
    }
    function getSeriesRating($sid){
        require 'dbconfig.php';
        $get_detail = "SELECT SUM(S.rating) AS total, COUNT(S.rate_id) AS num FROM series_rating S WHERE S.series_id = '$sid' GROUP BY S.series_id";
        $rtn = mysqli_query($dbconn, $get_detail);
        if($rtn->num_rows == 0)
            return 0;
        else{
            $rating = mysqli_fetch_assoc($rtn);
            $total = $rating['total'];
            $numb = $rating['num'];
            $avg = number_format($total / $numb, 1);
            return $avg;
        }
    }
    function isAlreadyRated($uid){
        require 'dbconfig.php';
        $check_rate = "SELECT * FROM rating WHERE user_id = '$uid'";
        $cr_rtn = mysqli_query($dbconn,$check_rate);
        if($cr_rtn->num_rows == 0)
            return false;
        else
            return true;
    }
    function isChapOwner($chid, $uid){
        require 'dbconfig.php';
        $get_cid = "SELECT S.creator_id FROM chapter C INNER JOIN series S ON C.series_id = S.series_id WHERE C.chap_id = '$chid'";
        $rtn = mysqli_query($dbconn, $get_cid);
        $chapID = mysqli_fetch_assoc($rtn);
        $check_creator = "SELECT acc_type FROM user WHERE user_id = '$uid'";
        $check_rtn = mysqli_query($dbconn, $check_creator);
        $checker = mysqli_fetch_assoc($check_rtn);
        if($checker['acc_type'] == "creator"){
            if(getCreatorId($uid) == $chapID['creator_id'])
                return true;
            else
                return false;
        }else
            return false;
        
    }
    function getUserCount($year,$month,$type){
        require 'dbconfig.php';
        if($month == 0){
            if($type == 'all')
                $get_userCount = "SELECT COUNT(user_id) AS uCount FROM user WHERE YEAR(create_date) = '$year' GROUP BY YEAR(create_date)";
            else
                $get_userCount = "SELECT COUNT(user_id) AS uCount FROM user WHERE YEAR(create_date) = '$year' AND acc_type = '$type' GROUP BY YEAR(create_date)";
        }    
        else{
            if($type == 'all')
                $get_userCount = "SELECT COUNT(user_id) AS uCount FROM user WHERE MONTH(create_date) = '$month' AND YEAR(create_date) = '$year' GROUP BY MONTH(create_date)";
            else
                $get_userCount = "SELECT COUNT(user_id) AS uCount FROM user WHERE MONTH(create_date) = '$month' AND YEAR(create_date) = '$year' AND acc_type = '$type' GROUP BY MONTH(create_date)";
        }
            
        $rtn = mysqli_query($dbconn, $get_userCount);
        if($rtn->num_rows == 0)
            return 0;
        else{
            $count = mysqli_fetch_assoc($rtn);
            return $count['uCount'];
        }
    }
    function getTotalCoins($year,$month,$type){
        require 'dbconfig.php';
        if($month == 0){
            if($type == 'sold')
                $get_Coins = "SELECT SUM(coin_amount) AS coins FROM coin_purchase_rec WHERE YEAR(confirm_date) = '$year' AND status = 'Success' GROUP BY YEAR(confirm_date)";
            else
                $get_Coins = "SELECT SUM(coin_amount) AS coins FROM coin_withdraw_rec WHERE YEAR(confirm_date) = '$year' AND status = 'Success' GROUP BY YEAR(confirm_date)";
        }else{
            if($type == 'sold')
                $get_Coins = "SELECT SUM(coin_amount) AS coins FROM coin_purchase_rec WHERE YEAR(confirm_date) = '$year' AND MONTH(confirm_date) = '$month' AND status = 'Success' GROUP BY MONTH(confirm_date)";
            else
                $get_Coins = "SELECT SUM(coin_amount) AS coins FROM coin_withdraw_rec WHERE YEAR(confirm_date) = '$year' AND MONTH(confirm_date) = '$month' AND status = 'Success' GROUP BY MONTH(confirm_date)";
        }
        $rtn = mysqli_query($dbconn, $get_Coins);
        if($rtn->num_rows == 0)
            return 0;
        else{
            $total = mysqli_fetch_assoc($rtn);
            return $total['coins'];
        }
            
    }
    function getPackPurcCounts($year,$month,$id){
        require 'dbconfig.php';
        if($month == 0){
            if($id == "all")
                $get_packCount = "SELECT COUNT(ppr_id) AS packs FROM package_purchase_rec WHERE YEAR(purchase_date) = '$year' GROUP BY YEAR(purchase_date)";
            else
                $get_packCount = "SELECT COUNT(ppr_id) AS packs FROM package_purchase_rec WHERE YEAR(purchase_date) = '$year' AND package_id = '$id' GROUP BY YEAR(purchase_date)";
        }else{
            if($id == "all")
                $get_packCount = "SELECT COUNT(ppr_id) AS packs FROM package_purchase_rec WHERE YEAR(purchase_date) = '$year' AND MONTH(purchase_date) = '$month' GROUP BY YEAR(purchase_date)";
            else
                $get_packCount = "SELECT COUNT(ppr_id) AS packs FROM package_purchase_rec WHERE YEAR(purchase_date) = '$year' AND MONTH(purchase_date) = '$month' AND package_id = '$id' GROUP BY YEAR(purchase_date)";
        }
        $rtn = mysqli_query($dbconn, $get_packCount);
        if($rtn->num_rows == 0)
            return 0;
        else{
            $counts = mysqli_fetch_assoc($rtn);
            return $counts['packs'];
        }
    }
    function getCEIncome($year,$month){
        require 'dbconfig.php';
        if($month == 0){
            $get_pCoins = "SELECT SUM(amount) AS cost FROM coin_purchase_rec WHERE YEAR(confirm_date) = '$year' AND status = 'Success' GROUP BY YEAR(confirm_date)";
            $get_wCoins = "SELECT SUM(amount) AS cost FROM coin_withdraw_rec WHERE YEAR(confirm_date) = '$year' AND status = 'Success' GROUP BY YEAR(confirm_date)";
        }else{
            $get_pCoins = "SELECT SUM(amount) AS cost FROM coin_purchase_rec WHERE YEAR(confirm_date) = '$year' AND MONTH(confirm_date) = '$month' AND status = 'Success' GROUP BY MONTH(confirm_date)";
            $get_wCoins = "SELECT SUM(amount) AS cost FROM coin_withdraw_rec WHERE YEAR(confirm_date) = '$year' AND MONTH(confirm_date) = '$month' AND status = 'Success' GROUP BY MONTH(confirm_date)";
        }
        $p_rtn = mysqli_query($dbconn, $get_pCoins);
        $w_rtn = mysqli_query($dbconn, $get_wCoins);
        if($p_rtn->num_rows == 0)
            $pTotal = 0;
        else{
            $pPrice = mysqli_fetch_assoc($p_rtn);
            $pTotal = $pPrice['cost'];
        }

        if($w_rtn->num_rows == 0)
            $wTotal = 0;
        else{
            $wPrice = mysqli_fetch_assoc($w_rtn);
            $wTotal = $wPrice['cost'];
        }
        return $pTotal - $wTotal;

    }
    function getPackIncome($year,$month,$type){
        require 'dbconfig.php';
        if($month == 0){
            if($type == "all")
                $get_packPrice = "SELECT SUM(P.price) AS price FROM package_purchase_rec R INNER JOIN package P ON R.package_id = P.package_id WHERE YEAR(purchase_date) = '$year' GROUP BY YEAR(purchase_date)";
            else
                $get_packPrice = "SELECT SUM(P.price) AS price FROM package_purchase_rec R INNER JOIN package P ON R.package_id = P.package_id WHERE YEAR(R.purchase_date) = '$year' AND R.package_id = '$type' GROUP BY YEAR(R.purchase_date)";
        }else{
            if($type == "all")
                $get_packPrice = "SELECT SUM(P.price) AS price FROM package_purchase_rec R INNER JOIN package P ON R.package_id = P.package_id WHERE YEAR(R.purchase_date) = '$year' AND MONTH(R.purchase_date) = '$month' GROUP BY MONTH(R.purchase_date)";
            else
                $get_packPrice = "SELECT SUM(P.price) AS price FROM package_purchase_rec R INNER JOIN package P ON R.package_id = P.package_id WHERE YEAR(R.purchase_date) = '$year' AND MONTH(R.purchase_date) = '$month' AND R.package_id = '$type' GROUP BY MONTH(R.purchase_date)";
        }
        $rtn = mysqli_query($dbconn, $get_packPrice);

        $get_rate = "SELECT rate_per_coin AS rate FROM exchange_rate WHERE er_type = 'PURC'";
        $rate_rtn = mysqli_query($dbconn, $get_rate);
        if($rtn->num_rows == 0 || $rate_rtn->num_rows == 0)
            return 0;
        else{
            $total = mysqli_fetch_assoc($rtn);
            $getRate = mysqli_fetch_assoc($rate_rtn);
            return $total['price'] * $getRate['rate'];
        }
    }
    function getDonationIncome($year, $month){
        require 'dbconfig.php';
        if($month == 0)
            $get_donation = "SELECT SUM(amount) AS dc FROM donation WHERE YEAR(donate_date) = '$year' GROUP BY YEAR(donate_date)";
        else
            $get_donation = "SELECT SUM(amount) AS dc FROM donation WHERE YEAR(donate_date) = '$year' AND MONTH(donate_date) = '$month' GROUP BY MONTH(donate_date)";
        $drtn = mysqli_query($dbconn, $get_donation);

        $get_rate = "SELECT rate_per_coin AS rate FROM exchange_rate WHERE er_type = 'PURC'";
        $rate_rtn = mysqli_query($dbconn, $get_rate);

        if($drtn->num_rows == 0 || $rate_rtn->num_rows == 0)
            return 0;
        else{
            $donCoin = mysqli_fetch_assoc($drtn);
            $getRate = mysqli_fetch_assoc($rate_rtn);
            return $donCoin['dc'] * $getRate['rate'];
        }
    }
    function getTotalIncome($year,$month){
        require 'dbconfig.php';
        $coinEx = getCEIncome($year,$month);
        $pacInc = getPackIncome($year,$month,"all");
        $donation = getDonationIncome($year,$month);
        return $coinEx + $pacInc + $donation;
    }
    function getUserIDFromChapID($chapID){
        require 'dbconfig.php';
        $get_uid = "SELECT R.user_id FROM series S JOIN chapter C JOIN creator R ON S.series_id = C.series_id AND S.creator_id = R.creator_id WHERE C.chap_id = '$chapID'";
        $rtn = mysqli_query($dbconn, $get_uid);
        $uid = mysqli_fetch_assoc($rtn);
        return $uid['user_id'];
    }
?>