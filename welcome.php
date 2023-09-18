<?php 
	session_start();
	echo 'Welcome '.$_SESSION['uid'].' '.$_SESSION['uname'].' '.$_SESSION['acctype'] ;
 ?>