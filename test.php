<script>
		function showModal(){
			window.onclick = function(event){
				var modal = document.getElementById("coinWithdraw");
				modal.style.display = "block";
			}
		}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="bs5.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<?php
		$check = true;
		if($check){
			echo "<script>showModal();</script>";
		}
	?>
	<div class="modal" id="coinWithdraw" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Coin Withdrawl form</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<h3>HELLOOOO</h3>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>