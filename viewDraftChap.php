<?php 
	session_start();
	include_once 'controller.php';
		
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Draft chapters</title>
	<!-- <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>

	<?php 
		require 'dbconfig.php';

		$uid = $_SESSION['uid'];
		$cID = getCreatorId($uid);

		//getting draft chaps
		$f_dCh = "SELECT c.chap_id, s.series_name, s.series_id, c.chap_no, c.chap_name, c.upload_date FROM chapter c JOIN series s JOIN creator a ON c.series_id = s.series_id AND s.creator_id = a.creator_id WHERE a.creator_id = '$cID' AND c.status = 'draft' ORDER BY s.series_name";
		$fdCh_rtn = mysqli_query($dbconn,$f_dCh);
	?>

	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="createSeries.php">Create New Series</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="createChapter.php">Add New Chapter</a>
			</div>
			<div class="col-3 text-center fs-4 border-end mx-0 px-0 py-2 bg-secondary-subtle">
				<a class="text-dark text-decoration-none p-3" href="viewDraftChap.php">Draft Chapters</a>
			</div>
			<div class="col-3 text-center fs-4 mx-0 px-0 py-2">
				<a class="text-dark text-decoration-none p-3" href="viewCreatedSeries.php">View Created Series</a>
			</div>
		</div>
	</div>
	<div class="bg-secondary-subtle p-5 min-vh-100">
		<div class="container bg-white p-3 rounded">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Series Name</th>
						<th>Chapter no.</th>
						<th>Chapter name</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($fdCh_rtn->num_rows == 0){
					?>
					<tr>
						<td colspan="5" class="text-center">Nothing to show here!</td>
					</tr>
					<?php
						}
						else{
							while($chData = mysqli_fetch_assoc($fdCh_rtn)){
					?>
					<tr>
						<td>
							<?php echo $chData['series_name']; ?>
						</td>
						<td>
							<?php echo $chData['chap_no']; ?>
						</td>
						<td>
							<?php echo $chData['chap_name']; ?>
						</td>
						<td>
							<?php echo $chData['upload_date']; ?>
						</td>
						<td>
							<button class="btn btn-primary" type="button" onclick="window.location.href='editChapter.php?sid=<?php echo $chData['series_id']; ?>&cid=<?php echo $chData['chap_id']; ?>'">Edit</button>
						</td>
					</tr>
					<?php			
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
			function deleteChapter(chapterId){
				var chapId = chapterId;

				$.ajax({
                    url: 'deleteFunction.php',
                    type: 'POST',
                    data: { id: chapId },
                    success: function(response) {
                        alert(response);
                    }
                });

                location.assign('viewDraftChap.php');
			}

			function updateChapter(chapterId){
				var chapId = chapterId;

				$.ajax({
                    url: 'updateFunction.php',
                    type: 'POST',
                    data: { id: chapId },
                    success: function(response) {
                        alert(response);
                    }
                });

                location.assign('viewDraftChap.php');
			}
		</script>
</body>
</html>