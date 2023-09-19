<?php
    require 'dbconfig.php';
    if(isset($_POST['id'])){
		$sID = $_POST['id'];
		$getChap = "SELECT chap_no FROM chapter WHERE series_id = '$sID' ORDER BY chap_no DESC LIMIT 1";
        $gc_rtn = mysqli_query($dbconn, $getChap);
        if($gc_rtn->num_rows == 0)
            $lastChap = "no previous chapter";
        else{
            $gcData = mysqli_fetch_assoc($gc_rtn);
            $lastChap = $gcData['chap_no'];
        }
            
        echo $lastChap;
	}
?>