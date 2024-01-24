<?php 
	session_start();
	session_unset();
	echo "<script>alert('Admin Logout successfully.');
	window.location.assign('adminLogin.php');</script>";
?>