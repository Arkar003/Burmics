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
<body class="min-vh-100">
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
	<section>

	</section>
	<footer class="d-flex flex-wrap justify-content-between align-items-center p-3 border-top fixed-bottom">
		<div class="col-md-4 d-flex align-items-center">
			<a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
				<h4>BURMICS</h4>
			</a>
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