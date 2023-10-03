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
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>
	<section class="bg-dark pt-5">
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
				?>
				<div class="col-3 mb-4">
					<div class="mb-5">
						<div class="series-cv rounded mx-auto mb-2">
							<a href="series.php?sid=<?php echo $allSeries['series_id']; ?>" title="<?php echo $allSeries['series_name']; ?>">
								<img src="data/cv/<?php echo $allSeries['cover_img']; ?>" alt="<?php echo $allSeries['series_name']; ?>">
							</a>
						</div>
						<div class="mx-4 mb-2 series-title">
							<h4 class="text-light mb-0"><?php echo $allSeries['series_name']; ?></h4>
						</div>
						<div class="mx-4 mb-4 text-light">
							views and ratings
						</div>
						<div class="mx-4 rounded bg-dark-subtle py-2 ps-3">
							<a class="text-dark text-decoration-none" href="chapter.php?sid=<?php echo $allSeries['series_id']; ?>&chap=<?php echo getLastChap($allSeries['series_id']); ?>"><h5 class="text-dark mb-0"><?php echo getLastChap($allSeries['series_id']); ?></h5></a>
						</div>
					</div>
				</div>
				<?php		
						}
					}
				?>
				
			</div>
		</div>
	</section>
</body>
</html>