<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add new Chapter</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>

	<?php 
		require 'dbconfig.php';

		//getting creator id
		$user_id = $_SESSION['uid'];
		$f_cid = "SELECT creator_id FROM creator WHERE user_id = '$user_id'";
		$fcid_rtn = mysqli_query($dbconn,$f_cid);
		$c_data = mysqli_fetch_assoc($fcid_rtn);
		$cid = $c_data['creator_id'];

		//getting the created series
		$series = "SELECT series_id, series_name FROM series WHERE creator_id = '$cid'";
		$series_rtn = mysqli_query($dbconn, $series);
	?>

	<script type="text/javascript">
		function chap_preview(){
	        var totalFiles = $('#chapImg').get(0).files.length;
	        var imagediv= document.getElementById('chapPreview');
	        imagediv.innerHTML='';
	        
	        for(var i = 0; i < totalFiles; i++){
	          $('#chapPreview').append("<img src = '"+URL.createObjectURL(event.target.files[i])+"'>");
	        }
	    }

		function locked(x){
			if (x == 1)
				document.getElementById("lockChap").style.display = "block";
			else
				document.getElementById("lockChap").style.display = "none";
			return;
		}
	</script>
	
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="createSeries.php">Create New Series</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2 bg-secondary-subtle">
				<a class="text-dark text-decoration-none p-3" href="createChapter.php">Add New Chapter</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2 ">
				<a class="text-dark text-decoration-none p-3" href="viewDraftChap.php">Draft Chapters</a>
			</div>
			<div class="col-3 text-center fs-4 mx-0 px-0 py-2 ">
				<a class="text-dark text-decoration-none p-3" href="viewCreatedSeries.php">View Created Series</a>
			</div>
		</div>
	</div>
	<div class="container-fluid bg-secondary-subtle p-5">
		<form enctype="multipart/form-data" method="post">
			<div class="row justify-content-center">
				<div class="col-6 p-3">
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="crtSeries">
								Select Series:
							</label>
							<select class="form-select" name="crtSeries" id="crtSeries" required>
								<option value="s1" selected>Select Series</option>

								<?php 
									while($s_data = mysqli_fetch_assoc($series_rtn)){
								?>
								<option value="<?php echo $s_data['series_id']; ?>"><?php echo $s_data['series_name']; ?></option>

								<?php		
									}
								?>
							</select>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<div class="row">
								<div class="col-4">
									<label class="form-label" for="chapNo">Chapter no. :</label>
									<input class="form-control" type="number" name="chapNo" id="chapNo">
								</div>
								<div class="col-8">
									<label class="form-label" for="prevChap">Previous chapter :</label>
									<input class="form-control" type="text" name="prevChap" id="prevChap" value="" disabled>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="chapName">
								Chapter Name:
							</label>
							<input class="form-control" type="text" name="chapName" id="chapName">
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="chapImg">
								Upload Images :
							</label>
							<input type="file" name="chapImg[]" id="chapImg" accept="image/*" multiple onchange="chap_preview();" required>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="chapStatus">
								Status:
							</label>
							<select class="form-select" name="chapStatus" id="chapStatus" required>
								<option value="published" selected>Published</option>
								<option value="locked">Locked</option>
								<option value="private">Private</option>
							</select>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8" id="lockChap" style="display: none;">
							<div class="row">
								<div class="col-4">
									<div class="input-group">
										<span class="input-group-text" for="lockedCoin">Coins</span>
										<input type="number" class="form-control" name="lockedCoin" id="lockedCoin">
									</div>
								</div>
								<div class="col-8">
									<div class="input-group">
										<span class="input-group-text" for="expDate">Expire date</span>
										<input type="date" class="form-control" name="expDate" id="expDate">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="description">
								Chapter note:
							</label>
							<textarea class="form-control" name="description" id="description" rows="2"></textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="preview_chap mt-3 rounded" id="chapPreview"></div>
				</div>
			</div>
			<div class="row justify-content-center mt-5">
				<div class="col-2">
					<button class="btn btn-outline-primary w-100" type="reset">Cancel</button>
				</div>
				<div class="col-2">
					<button class="btn btn-secondary w-100" type="submit" name="saveDraft">Save as Draft</button>
				</div>
				<div class="col-2">
					<button class="btn btn-primary w-100" type="submit" name="creChap">Create</button>
				</div>
			</div>
		</form>
	</div>

	<?php 
		if((isset($_REQUEST['saveDraft'])) || (isset($_REQUEST['creChap']))){
			$s_id = $_REQUEST['crtSeries'];
			$c_no = "Chap ".$_REQUEST['chapNo'];
			$c_name = $_REQUEST['chapName'];
			$c_note = $_REQUEST['description'];
			$c_date = date('Y-m-d H:i:s');

			if(isset($_REQUEST['saveDraft'])){
				$status = "draft";
			}
			else{
				$status = $_REQUEST['chapStatus'];
			}

			$f_chap = "SELECT chap_id FROM chapter WHERE chap_no = '$c_no' AND series_id = '$s_id'";
			$fchap_rtn = mysqli_query($dbconn, $f_chap);

			if($fchap_rtn->num_rows == 0){
				$f_lastChap = "SELECT chap_id FROM chapter ORDER BY chap_id DESC LIMIT 1";//creating chapter id
				$flc_rtn = mysqli_query($dbconn, $f_lastChap);

				if($flc_rtn->num_rows == 0){
					$chap_id = 'CH000001'; //setting the chap id for the first time.
				}
				else{
					$c_data = mysqli_fetch_assoc($flc_rtn);
					$f_cid = $c_data['chap_id'];
					$chap_id = ++$f_cid;
				}//end of creating chapter id

				$f_sname = "SELECT series_name FROM series WHERE series_id = '$s_id'";//creating folder for the uploaded new chapter
				$fsname_rtn = mysqli_query($dbconn, $f_sname);
				$serData = mysqli_fetch_assoc($fsname_rtn);
				$s_name = $serData['series_name'];
				$path = "data/series/$s_name/$c_no";
				mkdir($path, 0777, true);//end of creating folder
				

				//getting multiple images from form input and put them altogether in an array, then json encode that array.
				$imgArr = array();
				$i = 1;
				foreach ($_FILES['chapImg']['name'] as $key => $imgName){
					if(!empty($imgName)){
						$tmpName = $_FILES['chapImg']['tmp_name'][$key];
						
						$nameDiv = explode('.', $imgName);
						$ext = strtolower(end($nameDiv));

						if($i < 10)
							$newImgName = '00'.$i.'.'.$ext;
						else
							$newImgName = '0'.$i.'.'.$ext;

						$new_path = "$path/$newImgName";
						move_uploaded_file($tmpName, $new_path);

						$i++;
						$imgArr[] = $newImgName;
					}
				}

				$imgNames = json_encode($imgArr);
				// print_r($imgNames);
				//end of getting multiple images

				//putting all the data into database
				$ch_data = "INSERT INTO chapter VALUES ('$chap_id','$s_id','$c_no','$c_name','$imgNames','$c_note','$c_date','$status')";
				$chdata_rtn = mysqli_query($dbconn, $ch_data);

				if($chdata_rtn)
					echo "<script>alert('Create chapter success.');</script>";
				else
					echo mysqli_error($dbconn);
				
				$sup_date = date('Y-m-d');
				$up_series = "UPDATE series SET last_update = '$sup_date' WHERE series_id = '$s_id'";
				$ups_rtn = mysqli_query($dbconn, $up_series);

				if($status == "locked"){
					$lcPrice = $_REQUEST['lockedCoin'];
					$expDate = $_REQUEST['expDate'];
					$lc_date = date('Y-m-d');
					$fet_lcid = "SELECT lock_id FROM locked_chapter ORDER BY lock_id DESC LIMIT 1";
					$flcid_rtn = mysqli_query($dbconn,$fet_lcid);
					if($flcid_rtn->num_rows == 0)
						$lcid = "L0000001";
					else{
						$lcData = mysqli_fetch_assoc($flcid_rtn);
						$prev_id = $lcData['lock_id'];
						$lcid = ++$prev_id;
					}
					$c_lock = "INSERT INTO locked_chapter VALUES ('$lcid','$chap_id','$lcPrice','$lc_date','$expDate')";
					$cl_rtn = mysqli_query($dbconn, $c_lock);
				}
			}
			else
				echo "<script>alert('Chapter already existed! Check your chapter number again.');</script>";
		}
	 ?>
	<script type="text/javascript">
		document.getElementById("crtSeries").addEventListener("change",function(){
			var selSeries = this.options[this.selectedIndex];
			var sereisVal = selSeries.value;
			$.ajax({
                    url: 'getLastChap.php',
                    type: 'POST',
                    data: { id: sereisVal },
                    success: function(response) {
                        document.getElementById("prevChap").value = response;
                    }
                });
		});

		document.getElementById("chapStatus").addEventListener("change",function(){
			var selOpt = this.options[this.selectedIndex];
			var selVal = selOpt.value;

			if(selVal == "locked")
				document.getElementById("lockChap").style.display = "block";
			else
				document.getElementById("lockChap").style.display = "none";
		});
	</script>
</body>
</html>