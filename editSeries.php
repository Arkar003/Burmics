<?php 
    require 'dbconfig.php';
    date_default_timezone_set("Asia/Yangon");
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editing Series</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>
    <?php
        $seriesID = $_GET['sid'];
        $getDetail = "SELECT * FROM series WHERE series_id = '$seriesID'";
        $gD_rtn = mysqli_query($dbconn, $getDetail);
        $sData = mysqli_fetch_assoc($gD_rtn);
		if($sData['creator_id'] == getCreatorId($_SESSION['uid'])){
	?>
	<div class="container-fluid bg-secondary-subtle p-5 pt-1">
        <h3 class="text-center p-3">Editing Series</h3>
		<form method="post" enctype="multipart/form-data">
			<div class="row justify-content-center">
				<div class="col-8 p-3">
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="sname">
								Series Name:
							</label>
						</div>
						<div class="col-8">
							<input class="form-control" type="text" name="sname" id="sname" value="<?php echo $sData['series_name']; ?>">
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="author">
								Aurthor Name:
							</label>
						</div>
						<div class="col-8">
							<input class="form-control" type="text" name="author" id="author" value="<?php echo $sData['author']; ?>">
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="artist">
								Artist Name:
							</label>
						</div>
						<div class="col-8">
							<input class="form-control" type="text" name="artist" id="artist" value="<?php echo $sData['artist']; ?>">
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="genre">
								Select Genre:
							</label>
						</div>
						<div class="col-8">
							<div class="row">
								<div class="col-4">
									<select class="form-select" name="genre1" id="genre" required>
										<option value="<?php echo $sData['genre_1']; ?>" selected><?php echo $sData['genre_1']; ?></option>
										<option value="fantasy">Fantasy</option>
										<option value="action">Action</option>
										<option value="adventure">Adventure</option>
										<option value="comedy">Comedy</option>
										<option value="fiction">Fiction</option>
										<option value="romance">Romance</option>
										<option value="mystery">Mystery</option>
										<option value="horror">Horror</option>
										<option value="drama">Drama</option>
										<option value="slice_of_life">Slice of life</option>
										<option value="superhero">Superhero</option>
										<option value="Sci-Fi">Sci-Fi</option>
										<option value="thriller">Thriller</option>
										<option value="supernatural">Supernatural</option>
										<option value="sports">Sports</option>
										<option value="historical">Historical</option>
										<option value="BL">BL</option>
										<option value="GL">GL</option>
									</select>
								</div>
								<div class="col-4">
									<select class="form-select" name="genre2" id="genre">
										<option value="<?php echo $sData['genre_2']; ?>" selected><?php echo $sData['genre_2']; ?></option>
                                        <option value="">--</option>
										<option value="fantasy">Fantasy</option>
										<option value="action">Action</option>
										<option value="adventure">Adventure</option>
										<option value="comedy">Comedy</option>
										<option value="fiction">Fiction</option>
										<option value="romance">Romance</option>
										<option value="mystery">Mystery</option>
										<option value="horror">Horror</option>
										<option value="drama">Drama</option>
										<option value="slice_of_life">Slice of life</option>
										<option value="superhero">Superhero</option>
										<option value="Sci-Fi">Sci-Fi</option>
										<option value="thriller">Thriller</option>
										<option value="supernatural">Supernatural</option>
										<option value="sports">Sports</option>
										<option value="historical">Historical</option>
										<option value="BL">BL</option>
										<option value="GL">GL</option>
									</select>
								</div>
								<div class="col-4">
									<select class="form-select" name="genre3" id="genre">
										<option value="<?php echo $sData['genre_3']; ?>" selected><?php echo $sData['genre_3']; ?></option>
										<option value="">--</option>
										<option value="fantasy">Fantasy</option>
										<option value="action">Action</option>
										<option value="adventure">Adventure</option>
										<option value="comedy">Comedy</option>
										<option value="fiction">Fiction</option>
										<option value="romance">Romance</option>
										<option value="mystery">Mystery</option>
										<option value="horror">Horror</option>
										<option value="drama">Drama</option>
										<option value="slice_of_life">Slice of life</option>
										<option value="superhero">Superhero</option>
										<option value="Sci-Fi">Sci-Fi</option>
										<option value="thriller">Thriller</option>
										<option value="supernatural">Supernatural</option>
										<option value="sports">Sports</option>
										<option value="historical">Historical</option>
										<option value="BL">BL</option>
										<option value="GL">GL</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="age_restrict">
								Age restriction:
							</label>
						</div>
						<div class="col-8">
							<select class="form-select" name="age_restrict" id="age_restrict" required>
								<option value="<?php echo $sData['age_restrict']; ?>" selected><?php echo $sData['age_restrict']; ?></option>
                                <option value="all_ages">All ages</option>
								<option value="teen">Teen</option>
								<option value="mature">Mature</option>
								<option value="adult">Adult</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-4 text-end">
							<label class="form-label" for="description">
								Description:
							</label>
						</div>
						<div class="col-8">
							<textarea class="form-control" name="description" id="description" rows="4"><?php echo $sData['description']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="preview_cv mt-3 rounded" id="preview">
						<img src="data/cv/<?php echo $sData['cover_img']; ?>" alt="<?php echo $sData['cover_img']; ?>">
					</div>
					<div class="mt-4">
						<input type="file" name="coverImg" accept="image/*" onchange="preview();">
					</div>
				</div>
			</div>
			<div class="row justify-content-center mt-5">
				<div class="col-2">
					<button class="btn btn-outline-primary w-100" type="button" onclick="window.location.href='viewCreatedSeries.php'">Cancel</button>
				</div>
				<div class="col-2">
					<button class="btn btn-primary w-100" type="submit" name="updSeries">Update</button>
				</div>
			</div>
		</form>
	</div>
	<?php
		}else{
    ?>
	<div class="container-fluid bg-secondary-subtle p-5 min-vh-100">
		<h1 class="text-center">You don't have access to other creators' series details.</h1>
	</div>
	<?php
		}
	?>
	<?php 

		if(isset($_REQUEST['updSeries'])){
			$sName = $_REQUEST['sname'];
			$aurthor = $_REQUEST['author'];
			$artist = $_REQUEST['artist'];
			$genre1 = $_REQUEST['genre1'];
			$genre2 = $_REQUEST['genre2'];
			$genre3 = $_REQUEST['genre3'];
			$age_rest = $_REQUEST['age_restrict'];
			$dspt = $_REQUEST['description'];
			$cv_img = $_FILES['coverImg']['name'];
			$cimg_dir = $_FILES['coverImg']['tmp_name'];


			$f_series = "SELECT series_id FROM series WHERE series_name = '$sName' AND series_id != '$seriesID'";
			$fs_rtn = mysqli_query($dbconn, $f_series);

			if($fs_rtn->num_rows == 0){
				$c_id = $sData['creator_id'];

				//changing cover image name
				$imgDiv = explode('.',$cv_img);
				$imgExt = strtolower(end($imgDiv));
				$imgName = $seriesID . 'CV.' . $imgExt; //setting image name as the series id
				//end of image name changing

				$update_series = "UPDATE series SET series_name = '$sName', author = '$aurthor', artist = '$artist', genre_1 = '$genre1', genre_2 = '$genre2', genre_3 = '$genre3', description = '$dspt', age_restrict = '$age_rest' WHERE series_id = '$seriesID'";
				$us_rtn = mysqli_query($dbconn,$update_series);

				if($us_rtn){
                    $oldCV = "data/cv/$imgName";
                    if(file_exists($oldCV))
                        unlink($oldCV);
                    
					move_uploaded_file($cimg_dir, "data/cv/$imgName");
					echo "<script>alert('Update series success.');
                    location.assign('editSeries.php?sid=$seriesID')</script>";
				}
				else
					echo mysqli_error($dbconn);
			}else
				echo "<script>alert('The updated series is already used by other creator. Please try another one.');</script>";
		}

	 ?>

	<script type="text/javascript">
		function preview(){
			var image=URL.createObjectURL(event.target.files[0]);
		    var imagediv= document.getElementById('preview');
		    var newimg=document.createElement('img');
		    imagediv.innerHTML='';
		    newimg.src=image;
		    imagediv.appendChild(newimg);
		}
	</script>
</body>
</html>