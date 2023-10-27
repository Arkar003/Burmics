<?php 
	session_start();
	require 'dbconfig.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User settings</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>
	<section class="bg-success-subtle p-5 min-vh-100">
		<div class="container">
			<div class="row">
				<div class="col-7 p-3">
					<div class="bg-light rounded-3 p-5 py-3">
						<h4>Profile setting</h4>
					</div>
				</div>
				<div class="col-5">
					<div class="bg-light rounded-3">

					</div>
				</div>
			</div>
		</div>
	</section>
	<footer>
		<div class="container-fluid bg-body-tertiary">
			<?php include 'footer.php'; ?>
		</div>
	</footer>
</body>
</html>