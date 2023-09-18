
<?php 
	require 'dbconfig.php';

	// print_r($_POST);

	if(isset($_FILES['chapImg']['name'])){
		$totalImg = count($_FILES['chapImg']['name']);
		$imgArr = array();

		for($i = 0; $i < $totalImg; $i++){
			$imgName = $_FILES['chapImg']['name'][$i];
			$tmpName = $_FILES['chapImg']['tmp_name'][$i];

			$nameDiv = explode('.', $imgName);
			$ext = strtolower(end($nameDiv));

			if($i < 10)
				$newImgName = '00'.$i.'.'.$ext;
			else
				$newImgName = '0'.$i.'.'.$ext;

			$imgArr[] = $newImgName;
		}

		print_r($imgArr);

		$imgNames = json_encode($imgArr);
		print_r($imgNames);
	}
 ?>	