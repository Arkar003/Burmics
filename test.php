<?php
	require 'dbconfig.php';
	$get_pData = "SELECT * FROM package ORDER BY package_id DESC LIMIT 1";
	$gpd_rtn = mysqli_query($dbconn, $get_pData);

	$pacInfo = mysqli_fetch_assoc($gpd_rtn);
	$pacID = ++$pacInfo['package_id'];
	$pname = "testing";
	$pDura = 20;
	$pPrice = 300;
	$addPac = "INSERT INTO package VALUES ('$pacID','$pname','$pDura','$pPrice')";
	$apc_rtn = mysqli_query($dbconn, $addPac);
?>