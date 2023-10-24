<?php 
	session_start();
	include_once 'controller.php';
	require 'dbconfig.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
		function showModal(){
			window.onclick = function(event){
				var modal = document.getElementById("limitModal");
				modal.style.display = "block";
			}
		}
	</script>
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>
	<?php
		if(isFreeAcc($_SESSION['uid']) && checkOverLimit($_SESSION['uid'])){
	?>
	<section class="bg-success-subtle p-5 min-vh-100">
		<div class="container align-items-center justify-content-center">
			<div class="text-center">
				<h4>Your free access [free 10 chaps a day] for today is used up.</h4>
				<h4>Wait till tomorrow.</h4>
				<h4>If you are losing patience, you can buy our premium packages.</h4>
				<h4>Buy our premium packages and read unlimited chapters.</h4>
				<div class="m-5">
					<button class="btn btn-success fs-5 px-3" type="button" data-bs-toggle="modal" data-bs-target="#packagePurc">Purchase Premium</button>
				</div>
			</div>
		</div>
	</section>
	<?php
		}else{
	?>
	<section class="bg-success-subtle pt-5">
		<?php
			$fetRows = "SELECT * FROM series WHERE last_update != '0000-00-00'";
			$fr_rtn = mysqli_query($dbconn,$fetRows);
			$total_rows = $fr_rtn->num_rows;
			$limit = 8;
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start = ($page - 1) * $limit;
			$total_pages = ceil($total_rows / $limit);
			if($page < $total_pages)
				$next = $page + 1;
			else
				$next = $total_pages;

			if($page > 1)
				$prev = $page - 1;
			else
				$prev = 1;
			$getAllSeries = "SELECT * FROM series WHERE last_update != '0000-00-00' ORDER BY last_update DESC LIMIT $start, $limit";
			$gas_rtn = mysqli_query($dbconn,$getAllSeries);

			$getNewRelease = "SELECT * FROM series WHERE last_update != '0000-00-00' ORDER BY create_date DESC LIMIT 4";
			$gnr_rtn = mysqli_query($dbconn, $getNewRelease);

			$getHighRated = "SELECT * FROM series S INNER JOIN series_rating R ON S.series_id = R.series_id GROUP BY R.series_id ORDER BY AVG(R.rating) DESC";
			$ghr_rtn = mysqli_query($dbconn, $getHighRated);
		?>
		<div class="container">
			<div class="row mb-5">
				<div class="col-12 mb-3"><div class="border-bottom border-3 border-danger mb-3"><h4>New Release</h4></div></div>
				<?php
					if($gnr_rtn->num_rows == 0){
				?>
				<div class="col-12">
					<div><h2>There is nothing on this page.</h2></div>
				</div>
				<?php		
					}else{
						while($newReleaseS = mysqli_fetch_assoc($gnr_rtn)){
							$nrSID = $newReleaseS['series_id'];
				?>
				<div class="col-3">
					<div class="mb-3">
						<div class="series-cv rounded mx-auto mb-2">
							<a href="series.php?sid=<?php echo $nrSID; ?>" title="<?php echo $newReleaseS['series_name']; ?>">
								<img src="data/cv/<?php echo $newReleaseS['cover_img']; ?>" alt="<?php echo $newReleaseS['series_name']; ?>">
							</a>
						</div>
						<div class="mx-4 px-2 mb-2 series-title">
							<h4 class="text-dark mb-0"><?php echo $newReleaseS['series_name']; ?></h4>
						</div>
					</div>
				</div>
				<?php
						}
					}
				?>
			</div>
			<div class="row mb-5">
				<div class="col-12 mb-3"><div class="border-bottom border-3 border-danger mb-3"><h4>High Rating Series</h4></div></div>
				<?php
					if($ghr_rtn->num_rows == 0){
				?>
				<div class="col-12">
					<div><h2>There is nothing on this page.</h2></div>
				</div>
				<?php		
					}else{
						while($highRated = mysqli_fetch_assoc($ghr_rtn)){
							$hrSID = $highRated['series_id'];
				?>
				<div class="col-3">
					<div class="mb-3">
						<div class="series-cv rounded mx-auto mb-2">
							<a href="series.php?sid=<?php echo $hrSID; ?>" title="<?php echo $highRated['series_name']; ?>">
								<img src="data/cv/<?php echo $highRated['cover_img']; ?>" alt="<?php echo $highRated['series_name']; ?>">
							</a>
						</div>
						<div class="mx-4 px-2 mb-2 series-title">
							<h4 class="text-dark mb-0"><?php echo $highRated['series_name']; ?></h4>
						</div>
						<div class="mx-4 px-2 mb-2 text-dark">
							<i class="bi bi-eye-fill"></i> <?php echo getTotalViews($highRated['series_id']); ?>&nbsp;&nbsp; <i class="fa-solid fa-star"></i> <?php echo getSeriesRating($highRated['series_id']); ?>
						</div>
					</div>
				</div>
				<?php
						}
					}
				?>
			</div>
			<div class="row">
				<div class="col-12 mb-3"><div class="border-bottom border-3 border-danger mb-3"><h4>All Series</h4></div></div>
				<?php
					if($gas_rtn->num_rows == 0){
				?>
				<div class="col-12">
					<div><h2>There is nothing on this page.</h2></div>
				</div>
				<?php		
					}else{
						while($allSeries = mysqli_fetch_assoc($gas_rtn)){
							$seriesID = $allSeries['series_id'];
				?>
				<div class="col-3 mb-4">
					<div class="mb-5">
						<div class="series-cv rounded mx-auto mb-2">
							<a href="series.php?sid=<?php echo $seriesID; ?>" title="<?php echo $allSeries['series_name']; ?>">
								<img src="data/cv/<?php echo $allSeries['cover_img']; ?>" alt="<?php echo $allSeries['series_name']; ?>">
							</a>
						</div>
						<div class="mx-4 px-2 mb-2 series-title">
							<h4 class="text-dark mb-0"><?php echo $allSeries['series_name']; ?></h4>
						</div>
						<div class="mx-4 px-2 mb-4 text-dark">
							<i class="bi bi-eye-fill"></i> <?php echo getTotalViews($allSeries['series_id']); ?>&nbsp;&nbsp; <i class="fa-solid fa-star"></i> <?php echo getSeriesRating($allSeries['series_id']); ?>
						</div>
						<?php
							$chk_lastCh = "SELECT * FROM chapter WHERE series_id = '$seriesID' AND (status != 'private' AND status != 'draft') ORDER BY upload_date DESC LIMIT 1";
							$chk_rtn = mysqli_query($dbconn, $chk_lastCh);
							$chapDetail = mysqli_fetch_assoc($chk_rtn);
							$chID = $chapDetail['chap_id'];
							$uID = $_SESSION['uid'];
							if($chapDetail['status'] == "locked"){
								if(!hasBoughtEA($chID,$uID)){
						?>
						<div class="mx-4 rounded bg-success py-2 ps-3 ch-box">
							<a class="text-light text-decoration-none" href="series.php?sid=<?php echo $seriesID; ?>"><h5 class="mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
							<i class="bi bi-lock-fill lock_ic fs-5 text-light"></i>
						</div>
						<?php
								}else{
						?>
						<div class="mx-4 rounded bg-success py-2 ps-3 ch-box">
							<a class="text-light text-decoration-none" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapDetail['chap_no']; ?>"><h5 class="mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
							<i class="bi bi-unlock-fill lock_ic fs-5 text-light"></i>
						</div>
						<?php
								}
							}else{
						?>
						<div class="mx-4 rounded bg-success py-2 ps-3">
							<a class="text-light text-decoration-none" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapDetail['chap_no']; ?>"><h5 class="mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
						</div>
						<?php
							}
						?>
					</div>
				</div>
				<?php
						}
					}
				?>
				<div class="col-12 text-center mb-3">
					<nav class="d-inline-block">
						<ul class="pagination">
							<li class="page-item"><a class="page-link text-success" href="home.php?page=<?php echo $prev; ?>"><span>&laquo;</span></a></li>
							<?php
                                for($i = 1; $i <= $total_pages; $i++){
                            ?>
                            <li class="page-item"><a class="page-link text-success" href="home.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php
                                }
                            ?>
							<li class="page-item"><a class="page-link text-success" href="home.php?page=<?php echo $next; ?>"><span>&raquo;</span></a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<?php
		}
	?>
	
	<footer>
		<div class="container-fluid bg-body-tertiary">
			<?php include 'footer.php'; ?>
		</div>
	</footer>
</body>
</html>