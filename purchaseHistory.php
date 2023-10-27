<?php
    require 'dbconfig.php';
    include 'controller.php';
	session_start();

    $uid = $_SESSION['uid'];
    $get_coinPurc = "SELECT C.*, P.payment_method FROM coin_purchase_rec C JOIN payment_method P ON C.pm_id = P.pm_id WHERE user_id = '$uid'";
    $gcp_rtn = mysqli_query($dbconn, $get_coinPurc);

    $get_pacPurc = "SELECT R.purchase_date, P.package_name, P.price FROM package_purchase_rec R JOIN package P ON R.package_id = P.package_id WHERE R.user_id = '$uid'";
    $gpp_rtn = mysqli_query($dbconn, $get_pacPurc);
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
	<section class="bg-success-subtle pt-3 min-vh-100">
		<div class="container-fluid px-3">
            <div class="row">
                <div class="col-12 mb-4"><h2 class="text-center text-success">Purchasement History</h2></div>
                <div class="col-7">
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
                                    <th>Details</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($gcp_rtn->num_rows != 0){
                                        $count = 1;
                                        while($cpDetail = mysqli_fetch_assoc($gcp_rtn)){
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($cpDetail['cp_date'])); ?></td>
                                    <td><?php echo $cpDetail['coin_amount']; ?></td>
                                    <td><?php echo $cpDetail['amount']; ?></td>
                                    <td><?php echo $cpDetail['payment_method']; ?></td>
                                    <td>
                                        <div>
                                            <button class="btn" data-bs-toggle="modal" data-bs-target="#<?php echo $cpDetail['cpr_id']; ?>"><?php echo $cpDetail['payment_ss']; ?></button>
                                            <div class="modal fade" id="<?php echo $cpDetail['cpr_id']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="prevSsImg">
                                                                <img src="../data/coin_purchase/<?php echo $cpDetail['payment_ss']; ?>" alt="payment ss">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                    </td>
                                    <td><?php echo $cpDetail['status']; ?></td>
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
                <div class="col-5">
                    <div class="bg-light p-3 rounded-2 h-100">
                        <div class="mb-3 pb-2 border-bottom"><h3>Package Purchasement</h3></div>
                        <table id="user_pack_history" class="table table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Pack</th>
                                    <th>Coins</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($gpp_rtn->num_rows != 0){
                                        $c = 1;
                                        while($packDetail = mysqli_fetch_assoc($gpp_rtn)){
                                ?>
                                <tr>
                                    <td><?php echo $c; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($packDetail['purchase_date'])); ?></td>
                                    <td><?php echo $packDetail['package_name']; ?></td>
                                    <td><?php echo $packDetail['price']; ?></td>
                                </tr>
                                <?php
                                            $c++;
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
	<footer>
		<div class="container-fluid bg-body-tertiary">
			<?php include 'footer.php'; ?>
		</div>
	</footer>
    <script>
        new DataTable('#user_purc_history');
        new DataTable('#user_pack_history');
    </script>
</body>
</html>