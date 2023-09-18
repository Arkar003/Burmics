<?php 
	require 'dbconfig.php';

	if(isset($_POST['id'])){
		$pmid = $_POST['id'];
		
		$get_accNum = "SELECT acc_number FROM payment_method WHERE pm_id = '$pmid'";
		$rtn = mysqli_query($dbconn, $get_accNum);
		$pmInfo = mysqli_fetch_assoc($rtn);
		echo $pmInfo['acc_number'];
	}
 ?>