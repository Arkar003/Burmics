<?php 
	session_start();
	include 'controller.php';
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
		if(checkOverLimit($_SESSION['uid']))
			echo "<script>showModal();</script>";
	?>
	<div class="modal" id="limitModal" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Your FREE access is all used.</h4>
					<button type="button" class="btn-close"></button>
				</div>
				<div class="modal-body">
					<p>Your free access for 10 chapters daily is all used for today.<br>Come back again tomorrow to get another free 10 chaps. <br> But <b>if you can't wait and can't get enough with just 10 chaps daily </b>, you can buy our premium packages with affordable price.</p>
					<div>
						<a class="btn btn-outline-secondary" href="home.php">Nah, I'm good.</a>
						<a class="btn btn-primary" href="#">Purchase Premium</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="bg-success-subtle pt-5">
		<?php
			$getAllSeries = "SELECT * FROM series WHERE last_update != '0000-00-00' ORDER BY last_update DESC";
			$gas_rtn = mysqli_query($dbconn,$getAllSeries);
		?>
		<div class="container">
			<div class="row mt-3">
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
						<div class="mx-4 mb-2 series-title">
							<h4 class="text-light mb-0"><?php echo $allSeries['series_name']; ?></h4>
						</div>
						<div class="mx-4 mb-4 text-light">
							views and ratings
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
						<div class="mx-4 rounded bg-dark-subtle py-2 ps-3 ch-box">
							<a class="text-dark text-decoration-none" href="series.php?sid=<?php echo $seriesID; ?>"><h5 class="text-dark mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
							<i class="bi bi-lock-fill lock_ic fs-5"></i>
						</div>
						<?php
								}else{
						?>
						<div class="mx-4 rounded bg-dark-subtle py-2 ps-3 ch-box">
							<a class="text-dark text-decoration-none" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapDetail['chap_no']; ?>"><h5 class="text-dark mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
							<i class="bi bi-unlock-fill lock_ic fs-5"></i>
						</div>
						<?php
								}
							}else{
						?>
						<div class="mx-4 rounded bg-dark-subtle py-2 ps-3">
							<a class="text-dark text-decoration-none" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapDetail['chap_no']; ?>"><h5 class="text-dark mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
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
				
			</div>
		</div>
	</section>
	<footer>
		<div class="container-fluid bg-body-tertiary pt-4">
			<?php include 'footer.php'; ?>
		</div>
	</footer>
</body>
</html>