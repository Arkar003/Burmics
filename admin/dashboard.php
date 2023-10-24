<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<script type="text/javascript" src="../bs5.3/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row min-vh-100">
			<div class="col-2 bg-light pe-0">
				<?php include 'sidebar.php'; ?>
			</div>
			<div class="col-10 bg-secondary-subtle ps-0">
				<div class="container">
					<div class="row p-3">
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-coins fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>Total Coin sold</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-coins fs-1"></i></div>
									<div class="col-9 px-0 text-end">
										<h5>Coin Withdraw</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-cart-shopping fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>Package Purc</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-user-plus fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>New users</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row px-4">
						<div class="col-12 bg-light rounded">
							<h1>Income chart</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>