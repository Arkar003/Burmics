<?php 
	function updateChap($id){
		require 'dbconfig.php';

		echo "i am here as $id, hehe";
	}

	if(isset($_POST['id'])){
		$cid = $_POST['id'];
		updateChap($cid);
	}
 ?>