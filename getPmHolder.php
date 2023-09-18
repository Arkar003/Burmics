<?php 
	require 'dbconfig.php';

	if(isset($_POST['id'])){
		$pmid = $_POST['id'];
		
		$get_holder = "SELECT holder_name FROM payment_method WHERE pm_id = '$pmid'";
		$rtn = mysqli_query($dbconn, $get_holder);
		$pmInfo = mysqli_fetch_assoc($rtn);
		echo $pmInfo['holder_name'];
	}
 ?>