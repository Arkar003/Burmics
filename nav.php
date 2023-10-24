<?php 
	require 'dbconfig.php';
	include_once 'controller.php';
 ?>

<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="bs5.3/js/bootstrap.bundle.min.js"></script>

<header class="p-3 border-bottom">
	<div class="container-fluid">
		<div class="d-flex flex-wrap align-items-center justify-content-start">
			<a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none" href="home.php"><span class="fs-2 ">BURMICS</span></a>
			<ul class="nav col-12 col-lg-auto ms-lg-auto mb-2 justify-content-center mb-md-0">
				<li>
					<a class="nav-link link-body-emphasis px-2" data-bs-toggle="collapse" href="#searchBox" role="button"><span><i class="bi bi-search fa-lg"></i></span></a>
				</li>
				<li>
					<a class="nav-link link-body-emphasis px-2" data-bs-toggle="collapse" href="#filterBox" role="button"><span><i class="bi bi-funnel fa-lg"></i></span></a>
				</li>
				<li>
					<div class="container px-2">
						<div class="row">
							<button class="btn link-body-emphasis" data-bs-toggle="modal" data-bs-target="#packagePurc"><i class="bi bi-cart-fill fa-lg"></i></button>
							<div class="modal fade" id="packagePurc" data-bs-backdrop="static" data-bs-keyboard="false">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Package Store</h4>
											<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
										</div>
										<div class="modal-body">
											<?php include 'package_Purchase.php'; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li>
					<a class="nav-link link-body-emphasis px-2" href="viewLibrary.php"><span><i class="bi bi-journal-bookmark-fill fa-lg"></i></span></a>
				</li>
				<li class="mx-3">
					<div class="container">
						<div class="row align-items-center border border-dark rounded py-1 px-0">
							<div class="col pe-0"><i class="bi bi-wallet2 fa-lg"></i></div>
							<div class="col">
							<?php
								$wid = $_SESSION['wid']; 
								$f_wallet = "SELECT amount FROM wallet WHERE wallet_id = '$wid'";
								$fw_rtn = mysqli_query($dbconn, $f_wallet);
								$wInfo = mysqli_fetch_assoc($fw_rtn);
								$w_amt = $wInfo['amount'];
								echo $w_amt;
							?>
							</div>
							<div class="col ps-0">
								<button class="btn p-0" type="button" data-bs-toggle="modal" data-bs-target="#coinPurchase"><i class="bi bi-plus-circle fa-lg"></i></button>
								<div class="modal fade" id="coinPurchase" data-bs-backdrop="static" data-bs-keyboard="false">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Coin purchasement store</h4>
												<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
											</div>
											<div class="modal-body">
												<?php include 'coin_purchase.php'; ?>
											</div>
										</div>                       			
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				
				<?php 
					if($_SESSION['acctype'] == 'creator'){
				?>
				<li class="me-3">
					<div class="container">
						<div class="row">
							<button class="btn btn-primary rounded-pill" onclick="window.location.href='createSeries.php'">Create</button>
						</div>
					</div>
				</li>
				<?php
					}
				?>
			</ul>
			<div class="dropdown text-end">
				<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
					<?php
						if($_SESSION['acctype'] == 'creator')
							echo "<img class='adminIcon' src='./imgs/icons/defIcon.png'>";
						else
							echo "<img class='icon' src='./imgs/icons/defIcon.png'>";
					?>
				</a>
				<ul class="dropdown-menu dropdown-menu-end">
					<li>
						<a class="dropdown-item">
							<p class="mb-0"><?php echo $_SESSION['uname']; ?></p>				
						</a>
					</li>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="#">Setting</a></li>
					<li><a class="dropdown-item" href="#">purchasement History</a></li>
					<?php 
						if($_SESSION['acctype'] == 'creator'){
					?>
					<li><a class="dropdown-item" href="#coinWithdraw" data-bs-toggle="modal">Withdraw</a></li>
					<li><a class="dropdown-item" href="#">Withdraw history</a></li>
					<?php 
						}
					?>
					<li><hr class="dropdown-divider"></li>
					<li><a class="dropdown-item" href="logout.php">logout</a></li>
				</ul>
			</div>
		</div>
	</div>	
</header>
<div class="modal fade" id="coinWithdraw" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Coin Withdrawl form</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<?php include 'coin_withdraw.php'; ?>
			</div>
		</div>
	</div>
</div>
<div class="collapse" id="searchBox">
	<div class="card card-body border-0 rounded-0">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-7">
					<form action="search.php" method="get" class="d-flex" role="search">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search..." name="srchInput" id="searchInput">
							<button class="btn btn-outline-primary" type="submit" name="search" id="searchBtn"><i class="bi bi-search fa-lg"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="collapse" id="filterBox">
	<div class="card card-body border-0 rounded-0">
		<div class="container">
			<form action="search.php" method="get">
				<div class="row px-4">
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="fantasy" id="fantasy">
							<label class="form-check-label" for="fantasy">Fantasy</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="action" id="action">
							<label class="form-check-label" for="action">Action</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="adventure" id="adventure">
							<label class="form-check-label" for="adventure">Adventure</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="comedy" id="comedy">
							<label class="form-check-label" for="comedy">Comedy</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="fiction" id="fiction">
							<label class="form-check-label" for="fiction">Fiction</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="romance" id="romance">
							<label class="form-check-label" for="romance">Romance</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="mystery" id="mystery">
							<label class="form-check-label" for="mystery">Mystery</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="horror" id="horror">
							<label class="form-check-label" for="horror">Horror</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="drama" id="drama">
							<label class="form-check-label" for="drama">Drama</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="slice_of_life" id="slice_of_life">
							<label class="form-check-label" for="slice_of_life">Slice of life</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="superhero" id="superhero">
							<label class="form-check-label" for="superhero">Superhero</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="Sci-Fi" id="Sci-Fi">
							<label class="form-check-label" for="Sci-Fi">Sci-Fi</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="thriller" id="thriller">
							<label class="form-check-label" for="thriller">Thriller</thrillerlabel>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="supernatural" id="supernatural">
							<label class="form-check-label" for="supernatural">Supernatural</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="sports" id="sports">
							<label class="form-check-label" for="sports">Sports</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="historical" id="historical">
							<label class="form-check-label" for="historical">Historical</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="BL" id="BL">
							<label class="form-check-label" for="BL">BL</label>
						</div>
					</div>
					<div class="col-2">
						<div class="form-check">
							<input class="form-check-input" name="genre[]" type="checkbox" value="GL" id="GL">
							<label class="form-check-label" for="GL">GL</label>
						</div>
					</div>
					<div class="col-12 text-center mt-3">
						<button class="btn btn-primary px-4" type="submit" name="filterSrch">Filter</button>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
