<?php
		if(checkOverLimit($_SESSION['uid']))
			echo "<script>showModal();</script>";
	?>
	<div class="modal" id="limitModal" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Your FREE access is all used.</h4>
					<button type="button" class="btn-close"></button>
				</div>
				<div class="modal-body">
					<p>Your free access for 10 chapters daily is all used for today.<br>Come back again tomorrow to get another free 10 chaps. <br> But <b>if you can't wait and can't get enough with just 10 chaps daily </b>, you can buy our premium packages with affordable price.</p>
					<div>
						<a class="btn btn-outline-secondary" href="home.php">Nah, I'm good.</a>
						<a class="btn btn-primary" href="#">Purchase Premium</a>
					</div>
				</div>
			</div>
		</div>
	</div>