<?php 
	session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create new Series</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-3 text-center fs-4 border-end mx-0 py-2 px-0 bg-secondary-subtle">
				<a class="text-dark text-decoration-none p-3" href="createSeries.php">Create New Series</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="createChapter.php">Add New Chapter</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="viewDraftChap.php">Draft Chapters</a>
			</div>
			<div class="col-3 text-center fs-4 mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="viewCreatedSeries.php">View Created Series</a>
			</div>
		</div>
	</div>
	<div class="container-fluid bg-secondary-subtle p-5">
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
							<input class="form-control" type="text" name="sname" id="sname">
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="author">
								Aurthor Name:
							</label>
						</div>
						<div class="col-8">
							<input class="form-control" type="text" name="author" id="author">
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-4 text-end">
							<label class="form-label" for="artist">
								Artist Name:
							</label>
						</div>
						<div class="col-8">
							<input class="form-control" type="text" name="artist" id="artist">
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
										<option value="" selected>Genre 1</option>
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
										<option value="" selected>Genre 2</option>
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
										<option value="" selected>Genre 3</option>
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
								<option value="all_ages" selected>All ages</option>
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
							<textarea class="form-control" name="description" id="description" rows="4"></textarea>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="preview_cv mt-3 rounded" id="preview">
						
					</div>
					<div class="mt-4">
						<input type="file" name="coverImg" accept="image/*" onchange="preview();">
					</div>
				</div>
			</div>
			<div class="row justify-content-center mt-5">
				<div class="col-2">
					<button class="btn btn-outline-primary w-100" type="reset">Cancel</button>
				</div>
				<div class="col-2">
					<button class="btn btn-primary w-100" type="submit" name="creSeries">Create</button>
				</div>
			</div>
		</form>
	</div>

	<?php 
		require 'dbconfig.php';
		date_default_timezone_set("Asia/Yangon");

		if(isset($_REQUEST['creSeries'])){
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
			$c_date = date('Y-m-d');


			$f_series = "SELECT series_id FROM series WHERE series_name = '$sName'";
			$fs_rtn = mysqli_query($dbconn, $f_series);

			if($fs_rtn->num_rows == 0){
				$u_id = $_SESSION['uid'];
				$f_cid = "SELECT creator_id FROM creator WHERE user_id = '$u_id'";//getting creator id from user id
				$fcid_rtn = mysqli_query($dbconn, $f_cid);
				$c_data = mysqli_fetch_assoc($fcid_rtn);
				$c_id = $c_data['creator_id'];
				
				$f_lastSeries = "SELECT series_id FROM series ORDER BY series_id DESC LIMIT 1";//creating series id

				$fls_rtn = mysqli_query($dbconn, $f_lastSeries);

				if($fls_rtn->num_rows == 0){
					$s_id = 'S0000001'; //setting the series id for the very first one.
				}
				else{
					$s_data = mysqli_fetch_assoc($fls_rtn);
					$fetched_sid = $s_data['series_id'];
					$s_id = ++$fetched_sid;
				}

				//changing cover image name
				$imgDiv = explode('.',$cv_img);
				$imgExt = strtolower(end($imgDiv));
				$imgName = $s_id . 'CV.' . $imgExt; //setting image name as the series id
				//end of image name changing

				$create_series = "INSERT INTO series VALUES ('$s_id','$c_id','$sName','$aurthor','$artist','$genre1','$genre2','$genre3','$dspt','$imgName','$age_rest','$c_date','')";
				$cs_rtn = mysqli_query($dbconn,$create_series);

				if($cs_rtn){
					move_uploaded_file($cimg_dir, "data/cv/$imgName");
					mkdir("data/series/$sName", 0777, true); //creating folder for the created series
					echo "<script>alert('Create series success.');</script>";
				}
				else
					echo mysqli_error($dbconn);
			}
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