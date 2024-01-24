<?php 
	session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Created Series</title>

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

		//getting the series id
		$series = "SELECT * FROM series WHERE creator_id = '$cid'";
		$series_rtn = mysqli_query($dbconn, $series);
	?>

	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="createSeries.php">Create New Series</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="createChapter.php">Add New Chapter</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="viewDraftChap.php">Draft Chapters</a>
			</div>
			<div class="col-3 text-center fs-4 mx-0 px-0 py-2 bg-secondary-subtle">
				<a class="text-dark text-decoration-none p-3" href="viewCreatedSeries.php">View Created Series</a>
			</div>
		</div>
	</div>
	<div class="bg-secondary-subtle p-5">
			<div class="accordion px-5 mx-5" id="seriesAccordion">
				<?php 
					if($series_rtn->num_rows == 0){
				?>
				<div class="accordion-item">
					<h2>There is nothing to show! You haven't created any series.</h2>
				</div>
				<?php		
					}
					else{
						while($s_data = mysqli_fetch_assoc($series_rtn)){
				?>
				<div class="accordion-item">
					<div class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $s_data['series_id']; ?>">
							<div class="container-fluid">
								<div class="row">
									<div class="col-2">
										<img src="data/cv/<?php echo $s_data['cover_img']; ?>" width="100%" height="auto">
									</div>
									<div class="col-10">
										<h2 class="mb-3"><?php echo $s_data['series_name']; ?></h2>
										<p class="mb-2 fs-5">Series ID: <?php echo $s_data['series_id']; ?></p>
										<p class="mb-2 fs-5">Artist: <?php echo $s_data['artist']; ?></p>
										<p class="mb-2 fs-5">Author: <?php echo $s_data['author']; ?></p>
										<p class="mb-2 fs-5">Create date: <?php echo $s_data['create_date']; ?></p>
										<p class="mb-2 fs-5">Total views: <?php echo getTotalViews($s_data['series_id']); ?></p>
									</div>
								</div>
							</div>
						</button>
					</div>
					<div class="accordion-collapse collapse" id="<?php echo $s_data['series_id']; ?>" data-bs-parent="#seriesAccordion">
						<div class="accordion-body">
							<div class="text-end">
								<a class="btn btn-primary" href="editSeries.php?sid=<?php echo $s_data['series_id']; ?>">Edit Series</a>
							</div>
							<?php 
								$series_id = $s_data['series_id'];
								$fet_chaps = "SELECT * FROM chapter WHERE series_id = '$series_id'";
								$fchap_rtn = mysqli_query($dbconn, $fet_chaps);
							?>
							<table class="table">
								<thead>
									<tr>
										<th>Chapter No.</th>
										<th>Chapter Name</th>
										<th>Date</th>
										<th>Status</th>
										<th>Views</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										while($ch_data = mysqli_fetch_assoc($fchap_rtn)){
									?>
									<tr>
										<td>
											<?php echo $ch_data['chap_no']; ?>
										</td>
										<td>
											<?php echo $ch_data['chap_name']; ?>
										</td>
										<td>
											<?php echo $ch_data['upload_date']; ?>
										</td>
										<td>
											<?php echo $ch_data['status']; ?>
										</td>
										<td>
											<?php echo getChapterViews($ch_data['chap_id']); ?>
										</td>
										<td>
											<!-- <button class="btn btn-danger">Delete</button> -->
											<a class="btn btn-primary" href="editChapter.php?sid=<?php echo $ch_data['series_id']; ?>&cid=<?php echo $ch_data['chap_id']; ?>">Edit Chapter</a>
										</td>
									</tr>
									<?php
										}
									?>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php			
						}
					}
				 ?>
			</div>
	</div>
</body>
</html>