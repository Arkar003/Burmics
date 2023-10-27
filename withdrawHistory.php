<?php
    require 'dbconfig.php';
    include 'controller.php';
	session_start();

    $uid = $_SESSION['uid'];
    $get_withDetail = "SELECT W.*, P.payment_method FROM coin_withdraw_rec W JOIN creator C JOIN payment_method P ON W.creator_id = C.creator_id AND W.pm_id = P.pm_id WHERE user_id = '$uid'";
    $gwd_rtn = mysqli_query($dbconn, $get_withDetail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURMCIS - Coin Purhcase History</title>
    <link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
	<header>
		<?php include 'nav.php'; ?>
	</header>
    <?php
        if($_SESSION['acctype'] != "creator"){
    ?>
    <section class="bg-success-subtle pt-3 min-vh-100">
        <div class="p-5"><h4 class="text-center text-success">You don't have access to this page.</h4></div>
    </section>
    <?php
        }else{
    ?>
    <section class="bg-success-subtle pt-3 min-vh-100">
		<div class="container-fluid px-3">
            <div class="row">
                <div class="col-12 mb-4"><h2 class="text-center text-success">Purchasement History</h2></div>
                <div class="col-12">
                    <div class="bg-light p-3 rounded-2 h-100">
                        <div class="mb-3 pb-2 border-bottom"><h3>Coin Purchasement</h3></div>
                        <table id="user_purc_history" class="table table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Coin</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Acc holder</th>
                                    <th>Acc Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($gwd_rtn->num_rows != 0){
                                        $count = 1;
                                        while($wDetail = mysqli_fetch_assoc($gwd_rtn)){
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($wDetail['w_date'])); ?></td>
                                    <td><?php echo $wDetail['coin_amount']; ?></td>
                                    <td><?php echo $wDetail['amount']; ?></td>
                                    <td><?php echo $wDetail['payment_method']; ?></td>
                                    <td><?php echo $wDetail['acc_holder']; ?></td>
                                    <td><?php echo $wDetail['acc_number']; ?></td>
                                    <td><?php echo $wDetail['status']; ?></td>
                                </tr>
                                <?php
                                            $count++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</section>
    <?php
        }
    ?>
	
	<footer>
		<div class="container-fluid bg-body-tertiary">
			<?php include 'footer.php'; ?>
		</div>
	</footer>
    <script>
        new DataTable('#user_purc_history');
    </script>
</body>
</html>