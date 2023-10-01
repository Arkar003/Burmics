<?php
	date_default_timezone_set("Asia/Yangon");

	$currDate = date('Y-m-d H:i:s');
	$dura = 1;
	$exp_date = date('Y-m-d H:i:s', strtotime('+'.$dura.' day',strtotime($currDate)));
	echo $currDate . " ";
	echo $exp_date;
?>