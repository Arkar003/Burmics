<?php 
	function deleteChap($id){
		require 'dbconfig.php';

		$del_chap = "DELETE FROM chapter WHERE chap_id = '$id'";
		$delc_rtn = mysqli_query($dbconn, $del_chap);

		if($delc_rtn)
			echo "Delete chapter $id successfully.";
		else
			echo mysqli_error($dbconn);
	}

	if(isset($_POST['id'])){
		$cid = $_POST['id'];
		deleteChap($cid);
	}
 ?>