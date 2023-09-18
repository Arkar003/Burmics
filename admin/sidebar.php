<div class="border-bottom p-3">
	<a class="fs-3 text-decoration-none font-monospace text-dark" href="#">
		ADMIN
	</a>
</div>
<div id="sideItemBox">
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark " href="dashboard.php">Dashboard</a>
	</div>
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark" role="button" href="#coin_mng" data-bs-toggle="collapse">Coin Management</a>
	</div>
	<div class="sbItem collapse" id="coin_mng">
		<div class="p-3 ps-4 sbItem"><a class="fs-6 text-decoration-none text-dark" href="coin_purchase_list.php">Coin Purchasement</a></div>
		<div class="p-3 ps-4 sbItem"><a class="fs-6 text-decoration-none text-dark" href="coin_purchase_history.php">Purchase History</a></div>
		<div class="p-3 ps-4 sbItem"><a class="fs-6 text-decoration-none text-dark" href="coin_withdraw_list.php">Coin Withdrawal</a></div>
		<div class="p-3 ps-4 sbItem"><a class="fs-6 text-decoration-none text-dark" href="coin_withdraw_history.php">Withdraw History</a></div>
	</div>
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark" role="button" href="#user_mng" data-bs-toggle="collapse">User Management</a>
	</div>
	<div class="sbItem collapse" id="user_mng">
		<div class="p-3 ps-4 sbItem"><a href="#" class="fs-6 text-decoration-none text-dark">All Users</a></div>
		<div class="p-3 ps-4 sbItem"><a href="#" class="fs-6 text-decoration-none text-dark">Creators</a></div>
		<div class="p-3 ps-4 sbItem"><a href="#" class="fs-6 text-decoration-none text-dark">Banned Users</a></div>
	</div>
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark" href="packageNrates.php">Packages and rates</a>
	</div>
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark" href="#">Reports</a>
	</div>
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark" href="adminSignUp.php">Admin Signup</a>
	</div>
	<div class="p-3 sbItem">
		<a class="fs-5 text-decoration-none text-dark" href="#">Account Setting</a>
	</div>
</div>
<div class="p-4">
	<div class="ms-4">
		<a class="fs-5 px-5 text-decoration-none btn btn-danger" role="button" href="#">
			Logout
		</a>
	</div>
</div>


<script type="text/javascript">
	var tabBox = document.getElementById("sideItemBox");
	var tabs = tabBox.getElementsByClassName("sbItem");

	for(var i = 0; i < tabs.length; i++){
		tabs[i].addEventListener('click', function(){
			var current = document.getElementsByClassName("active");
			current[0].className = current[0].className.replace(" active");
			this.className += " active";
		})
	}
</script>