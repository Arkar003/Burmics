<?php 
	session_start();
	session_unset();
	echo "<script>alert('Logout successfully.');
	window.location.assign('index.php');</script>";
?>