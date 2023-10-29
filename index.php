<?php 
	session_start();
	require 'dbconfig.php';
	include_once 'controller.php';
	$getMostViews = "SELECT S.series_id, S.series_name, S.cover_img FROM ch_view_count V INNER JOIN chapter C INNER JOIN series S ON V.chap_id = C.chap_id AND S.series_id = C.series_id GROUP BY S.series_id ORDER BY SUM(V.views) DESC LIMIT 4";
	$gmv_rtn = mysqli_query($dbconn, $getMostViews);
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Burmics</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="bs5.3/js/bootstrap.min.js"></script>
</head>
<body class="min-vh-100 bg-success-subtle">
	<header class="mb-5">
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#"><h1>Burmics</h1></a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" aria-current="page" href="#">Home</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">Features</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">Reviews</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#">FAQs</a>
		        </li>
		      </ul>
		      	<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAcc">
					Create Account
				</button>
				<div class="modal fade" id="createAcc" data-bs-backdrop="static" data-bs-keyboard="false">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5 m-auto">Create your Account for free</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				      </div>
				      <div class="modal-body">
				        <?php include 'signup.php'; ?>
				      </div>
				    </div>
				  </div>
				</div>

		      	<button type="button" class="btn btn-outline-success ms-2" data-bs-toggle="modal" data-bs-target="#login">
					Login
				</button>
				<div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Login to your account</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				        <?php include 'signin.php'; ?>
				      </div>
				    </div>
				  </div>
				</div>
		    </div>
		  </div>
		</nav>
	</header>
	<section>
		<div class="container">
			<div class="row mb-5 p-3">
				<div class="col-7">
					<h1 class="text-success mb-5">
						<span class="heading_title">Myanmar Comics Creator? <br>Or Reader?</span>
					</h1>
					<p class="text-dark mb-5">
						<span class="fs-3">Visit the best online comics library <br> for Myanmar local comics in Myanmar Language</span>
					</p>
					<!-- <ul class="heading_list mb-5 fs-5">
						<li>Create free account</li>
						<li>Creators can upload for free</li>
						<li>Creators can earn income by uploading comics</li>
						<li>Read a variety of local comics</li>
					</ul> -->
					<div class="p-3"></div>
					<div class="mt-5">
						<button type="button" class="btn btn-success fs-4 px-4" data-bs-toggle="modal" data-bs-target="#createAcc">
							Get Started
						</button>
					</div>
				</div>
				<div class="col-5 pe-0">
					<img src="imgs/4738059.png" alt="icon" width="500px" height="auto">
				</div>
				
			</div>
			<div class="row mb-5 py-5">
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success">100+</h1>
						<p class="fs-4 mb-0">Series</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success">100+</h1>
						<p class="fs-4 mb-0">Active users</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success">OVER 15</h1>
						<p class="fs-4 mb-0">Different Genres</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success">DAILY</h1>
						<p class="fs-4 mb-0">Read 10 Chaps free</p>
					</div>
				</div>
			</div>
			<div class="row mb-5 py-5 border-bottom border-3 border-success rounded-3 bg-success">
				<div class="col-7 ps-5">
					<img class="ms-5" src="imgs/8731673.png" alt="alert" width="250px" height="auto">
				</div>
				<div class="col-5 mb-5 text-end pe-5">
					<h2 class=""><span class="text-light">What's good about us?</span></h2>
					<ul class="fs-5 list-group list-group-flush">
						<li class="list-group-item bg-transparent text-light border-0">Read comics conveniently</li>
						<li class="list-group-item bg-transparent text-light border-0">Can read 10 free chapters daily</li>
						<li class="list-group-item bg-transparent text-light border-0">Can support local creators and artist</li>
						<li class="list-group-item bg-transparent text-light border-0">User-friendly interfaces</li>
					</ul>
				</div>
			</div>
			<div class="row mb-5 py-5 border-bottom border-3 border-success rounded-3 bg-light-subtle">
				<div class="col-12 mb-5"><h2 class="text-center"><span class="text-success">Creators' benefits</span></h2></div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">FREE</h1>
						<p class="fs-4 mb-0">Creators can upload comics for free</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">EARN</h1>
						<p class="fs-4  mb-0">can earn through readers' purchasement</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">HIGH</h1>
						<p class="fs-4 mb-0">High profit share percentage</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">GROW</h1>
						<p class="fs-4 mb-0">can grow in skillset and experience</p>
					</div>
				</div>
			</div>
			<div class="row mb-5">
			<div class="col-12 mb-5"><h2 class="text-center"><span class="text-success">Here's the most viewed series on BURMICS</span></h2></div>
				<?php
					if($gmv_rtn->num_rows == 0){
				?>
				<div class="col-12">
					<div><h2>There is nothing on this page.</h2></div>
				</div>
				<?php		
					}else{
						while($highRated = mysqli_fetch_assoc($gmv_rtn)){
							$hrSID = $highRated['series_id'];
				?>
				<div class="col-3">
					<div class="mb-3">
						<div class="series-cv rounded mx-auto mb-2">
							<a href="#" data-bs-toggle="modal" data-bs-target="#createAcc">
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
				<div class="col-12 text-center mt-5">
					<button type="button" class="btn btn-success fs-4 px-4" data-bs-toggle="modal" data-bs-target="#createAcc">Start reading</button>
				</div>
			</div>
			<!-- <div class="row mb-5 py-5">
				<div class="col-12 mb-5"><h2 class="text-center"><span class="text-success">What our users says about us?</span></h2></div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">Reviews</h1>
						<p class="fs-4 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima aut ratione aliquid magni ipsum nemo vero sapiente, inventore libero? Quidem, praesentium eaque architecto assumenda distinctio animi a doloremque harum repudiandae.</p>
					</div>
				</div>
				<div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">Reviews</h1>
						<p class="fs-4 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima aut ratione aliquid magni ipsum nemo vero sapiente, inventore libero? Quidem, praesentium eaque architecto assumenda distinctio animi a doloremque harum repudiandae.</p>
					</div>
				</div><div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">Reviews</h1>
						<p class="fs-4 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima aut ratione aliquid magni ipsum nemo vero sapiente, inventore libero? Quidem, praesentium eaque architecto assumenda distinctio animi a doloremque harum repudiandae.</p>
					</div>
				</div><div class="col-3">
					<div class="bg-light rounded text-center p-3">
						<h1 class="text-success mb-4">Reviews</h1>
						<p class="fs-4 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima aut ratione aliquid magni ipsum nemo vero sapiente, inventore libero? Quidem, praesentium eaque architecto assumenda distinctio animi a doloremque harum repudiandae.</p>
					</div>
				</div>
			</div> -->
		</div>
	</section>
	<footer class="d-flex flex-wrap bg-light justify-content-between align-items-center p-3 border-top">
		<div class="col-md-4 d-flex align-items-center">
			<a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1"><h4>BURMICS</h4></a>
			<span class="mb-3 mb-md-0 text-body-secondary">© 2023 Arkar Minn, L5DC CP</span>
		</div>
		<ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
			<li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
			<li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
			<li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
		</ul>
	</footer>
</body>
</html>