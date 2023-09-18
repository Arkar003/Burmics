<?php 
	session_start();
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
<body>
	<header>
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#">Burmics</a>
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
		      	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAcc">
					Create Account
				</button>
				<div class="modal fade" id="createAcc" data-bs-backdrop="static" data-bs-keyboard="false">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h1 class="modal-title fs-5 m-auto">Create your Account for free</h1>
				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				      </div>
				      <div class="modal-body">
				        <?php include 'signup.php'; ?>
				      </div>
				    </div>
				  </div>
				</div>

		      	<button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#login">
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

	<footer>
		
	</footer>
</body>
</html>