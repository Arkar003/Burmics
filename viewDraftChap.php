<?php 
	session_start();
	//function for deleting the chapter
		
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Draft chapters</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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

		//getting draft chaps
		$f_dCh = "SELECT c.chap_id, s.series_name, c.chap_no, c.chap_name, c.upload_date FROM chapter c JOIN series s JOIN creator a ON c.series_id = s.series_id AND s.creator_id = a.creator_id WHERE a.creator_id = '$cid' AND c.status = 'draft' ORDER BY s.series_name";
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
	<div class="bg-secondary-subtle p-5">
		<div class="container bg-white pt-3">
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
							<button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
							<div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title m-auto">
												Are you sure?
											</h4>
										</div>
										<div class="modal-body text-center">
											<p>Once you deleted this draft chapter,<br>you won't be able to restore this chapter!</p>
											<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
											<button class="btn btn-danger" type="button" onclick="deleteChapter('<?php echo $chData['chap_id']; ?>')">DELETE</button>
										</div>
									</div>
								</div>
							</div>
							<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
							<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title m-auto">
												Editing Chapter
											</h4>
										</div>
										<div class="modal-body text-center">
											<?php 
												//getting all information of that chapter
												$chapter_ID = $chData['chap_id'];
												$fch_all_info = "SELECT * FROM chapter WHERE chap_id = '$chapter_ID'";
												$fai_rtn = mysqli_query($dbconn, $fch_all_info);
												$chapInfo = mysqli_fetch_assoc($fai_rtn);

											 ?>
											 <div class="container-fluid bg-secondary-subtle">
												<form enctype="multipart/form-data" method="post">
													<div class="row justify-content-center">
														<div class="col-12 p-3">
															<div class="row mb-2">
																<div class="col-8 justify-content-start">
																	<label class="form-label" for="crtSeries">
																		Select Series:
																	</label>
																	<select class="form-select" name="crtSeries" id="crtSeries" required>
																		<option value="s1" selected disabled>
																			<?php echo $chData['series_name']; ?>		
																		</option>
																	</select>
																</div>
															</div>
															<div class="row mb-4 justify-content-end">
																<div class="col-8">
																	<label class="form-label" for="chapNo">
																		Chapter no. :
																	</label>
																	<input class="form-control" type="number" name="chapNo" id="chapNo" value="<?php echo $chapInfo['chap_no']; ?>" >
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
																<div class="col-8">
																	<label class="form-label" for="description">
																		Chapter note:
																	</label>
																	<textarea class="form-control" name="description" id="description" rows="2"></textarea>
																</div>
															</div>
														</div>
														<!-- <div class="col-6">
															<div class="preview_chap mt-3 rounded" id="chapPreview">
																
															</div>
														</div> -->
													</div>
													<!-- <div class="row justify-content-center mt-5">
														<div class="col-2">
															<button class="btn btn-outline-primary w-100" type="reset">Cancel</button>
														</div>
														<div class="col-2">
															<button class="btn btn-secondary w-100" type="submit" name="saveDraft">Save as Draft</button>
														</div>
														<div class="col-2">
															<button class="btn btn-primary w-100" type="submit" name="creChap">Create</button>
														</div>
													</div> -->
												</form>
											</div>
											<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
											<button class="btn btn-primary" type="button" onclick="updateChapter('<?php echo $chData['chap_id']; ?>')">Update</button>
										</div>
									</div>
								</div>
							</div>
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