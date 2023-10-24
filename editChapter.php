<?php 
	session_start();
    require 'dbconfig.php';
	date_default_timezone_set("Asia/Yangon");
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editing Chapter</title>
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
        $seriesID = $_GET['sid'];
        $chapID = $_GET['cid'];
        $getDetail = "SELECT * FROM chapter WHERE chap_id = '$chapID'";
        $gD_rtn = mysqli_query($dbconn, $getDetail);
        $cData = mysqli_fetch_assoc($gD_rtn);
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
	
	<div class="container-fluid bg-secondary-subtle p-5 pt-1">
        <h3 class="text-center p-3">Editing Chapter</h3>
		<form enctype="multipart/form-data" method="post">
			<div class="row justify-content-center">
				<div class="col-6 p-3">
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="crtSeries">Selected Series:</label>
							<input class="form-control" type="text" name="crtSeries" id="crtSeries" value="<?php echo getSeriesName($seriesID); ?>" disabled>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<div class="row">
								<div class="col-4">
									<label class="form-label" for="chapNo">Chapter no. :</label>
									<input class="form-control" type="text" name="chapNo" id="chapNo" value="<?php echo $cData['chap_no']; ?>">
								</div>
								<div class="col-8">
                                    <label class="form-label" for="chapName">Chapter Name:</label>
                                    <input class="form-control" type="text" name="chapName" id="chapName" value="<?php echo $cData['chap_name']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="chapImg">
								Re-upload Images :
							</label>
							<input type="file" name="chapImg[]" id="chapImg" accept="image/*" multiple onchange="chap_preview();" disabled>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8">
							<label class="form-label" for="chapStatus">
								Status:
							</label>
							<select class="form-select" name="chapStatus" id="chapStatus" required>
								<option value="<?php echo $cData['status']; ?>" selected><?php echo $cData['status']; ?></option>
								<option value="published">Published</option>
								<option value="locked">Locked</option>
								<option value="private">Private</option>
							</select>
						</div>
					</div>
					<div class="row mb-4 justify-content-end">
						<div class="col-8" id="lockChap">
                            <?php
                                if($cData['status'] == "locked"){
                                    $get_lockDetail = "SELECT price, expire_date FROM locked_chapter WHERE chap_id = '$chapID'";
                                    $gld_rtn = mysqli_query($dbconn, $get_lockDetail);
                                    $lockDetail = mysqli_fetch_assoc($gld_rtn);
                                    $lockCoin = $lockDetail['price'];
                                    $expire = $lockDetail['expire_date'];
                                }else{
                                    $lockCoin = 0;
                                    $expire = "0000-00-00";
                                }
                            ?>
							<div class="row">
								<div class="col-4">
									<div class="input-group">
										<span class="input-group-text" for="lockedCoin">Coins</span>
										<input type="number" class="form-control" name="lockedCoin" id="lockedCoin" value="<?php echo $lockCoin;?>">
									</div>
								</div>
								<div class="col-8">
									<div class="input-group">
										<span class="input-group-text" for="expDate">Expire date</span>
										<input type="date" class="form-control" name="expDate" id="expDate" value="<?php echo $expire;?>">
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
							<textarea class="form-control" name="description" id="description" rows="2"><?php echo $cData['note']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="preview_chap mt-3 rounded" id="chapPreview">
                        <?php
                            $images = json_decode($cData['images'],true);
                            foreach($images as $img){
                        ?>
                        <img src="data/series/<?php echo getSeriesName($seriesID); ?>/<?php echo $cData['chap_no']; ?>/<?php echo $img; ?>" alt="<?php echo $img; ?>">
                        <?php
                            }
                        ?>
                    </div>
				</div>
			</div>
			<div class="row justify-content-center mt-5">
				<div class="col-2">
					<button class="btn btn-outline-primary w-100" type="button" onclick="window.location.href='viewCreatedSeries.php'">Cancel</button>
				</div>
				<div class="col-2">
					<button class="btn btn-secondary w-100" type="submit" name="saveDraft">Save as Draft</button>
				</div>
				<div class="col-2">
					<button class="btn btn-primary w-100" type="submit" name="creChap">Update</button>
				</div>
			</div>
		</form>
	</div>

	<?php 
		if((isset($_REQUEST['saveDraft'])) || (isset($_REQUEST['creChap']))){
			$c_no = $_REQUEST['chapNo'];
			$c_name = $_REQUEST['chapName'];
			$c_note = $_REQUEST['description'];
			$c_date = date('Y-m-d H:i:s');

			if(isset($_REQUEST['saveDraft'])){
				$status = "draft";
			}
			else{
				$status = $_REQUEST['chapStatus'];
			}

			$f_chap = "SELECT chap_id FROM chapter WHERE chap_no = '$c_no' AND series_id = '$seriesID' AND chap_id != '$chapID'";
			$fchap_rtn = mysqli_query($dbconn, $f_chap);

			if($fchap_rtn->num_rows == 0){
				//putting all the data into database
				$ch_data = "UPDATE chapter SET chap_no = '$c_no', chap_name = '$c_name', note = '$c_note', upload_date = '$c_date', status = '$status' WHERE chap_id = '$chapID'";
				$chdata_rtn = mysqli_query($dbconn, $ch_data);
				
				$up_series = "UPDATE series SET last_update = '$c_date' WHERE series_id = '$s_id'";
				$ups_rtn = mysqli_query($dbconn, $up_series);

				if($status == "locked"){
					$lcPrice = $_REQUEST['lockedCoin'];
					$expDate = $_REQUEST['expDate'];
					$lc_date = date('Y-m-d');
                    $fet_lock = "SELECT lock_id FROM locked_chapter WHERE chap_id = '$chapID'";
                    $fl_rtn = mysqli_query($dbconn, $fet_lock);
                    if($fl_rtn->num_rows == 0){
                        $fet_lcid = "SELECT lock_id FROM locked_chapter ORDER BY lock_id DESC LIMIT 1";
                        $flcid_rtn = mysqli_query($dbconn,$fet_lcid);
                        if($flcid_rtn->num_rows == 0)
                            $lcid = "L0000001";
                        else{
                            $lcData = mysqli_fetch_assoc($flcid_rtn);
                            $prev_id = $lcData['lock_id'];
                            $lcid = ++$prev_id;
                        }
                        $c_lock = "INSERT INTO locked_chapter VALUES ('$lcid','$chapID','$lcPrice','$lc_date','$expDate')";
                        $cl_rtn = mysqli_query($dbconn, $c_lock);
                    }else{
                        $get_lid = mysqli_fetch_assoc($fl_rtn);
                        $l_id = $get_lid['lock_id'];
                        $upd_lock = "UPDATE locked_chapter SET price = '$lcPrice', expire_date = '$expDate' WHERE lock_id = '$l_id'";
                        $upl_rtn = mysqli_query($dbconn,$upd_lock);
                    }
				}else{
                    $fet_lock = "SELECT lock_id FROM locked_chapter WHERE chap_id = '$chapID'";
                    $fl_rtn = mysqli_query($dbconn, $fet_lock);
                    if($fl_rtn->num_rows != 0){
                        $get_lid = mysqli_fetch_assoc($fl_rtn);
                        $l_id = $get_lid['lock_id'];
                        $upd_lock = "UPDATE locked_chapter SET expire_date = '0000-00-00' WHERE lock_id = '$l_id'";
                        $upl_rtn = mysqli_query($dbconn,$upd_lock);
                    }
                }

                if($chdata_rtn)
					echo "<script>alert('Chpater updated successfully.');
                    location.assign('editChapter.php?sid=$seriesID&cid=$chapID');</script>";
				else
					echo mysqli_error($dbconn);
			}
			else
				echo "<script>alert('Chapter already existed! Check your chapter number again.');</script>";
		}
	 ?>
</body>
</html>