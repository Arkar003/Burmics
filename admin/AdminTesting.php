<?php
    require '../dbconfig.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<script type="text/javascript" src="../bs5.3/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <?php
        $get_rows = "SELECT cpr_id FROM coin_purchase_rec";
        $getRows_rtn = mysqli_query($dbconn, $get_rows);
        $total_rows = $getRows_rtn->num_rows;
        $limit = 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;
        $total_pages = ceil($total_rows / $limit);
        if($page < $total_pages)
            $next = $page + 1;
        else
            $next = $total_pages;

        if($page > 1)
            $prev = $page - 1;
        else
            $prev = 1;
        $f_cpl = "SELECT C.cpr_id, C.user_id, C.coin_amount, C.amount, C.cp_date, C.payment_ss, C.confirm_date, C.staff_id, C.status, P.payment_method FROM coin_purchase_rec C INNER JOIN payment_method P ON C.pm_id = P.pm_id WHERE C.status = 'Success' OR C.status = 'Rejected' ORDER BY C.cp_date DESC LIMIT $start, $limit";
        $fcpl_rtn = mysqli_query($dbconn, $f_cpl);
    ?>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-2 bg-light pe-0">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-10 bg-secondary-subtle ps-0">
                <div class="p-3">
                    <div class="row">
                        <div class="text-center mb-3">
                            <h3>Coin Purchasement History</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bg-light rounded">
                            <table class="table table-striped align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>User ID</th>
                                        <th>Coin</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Receipt</th>
                                        <th>Staff ID</th>
                                        <th>Confirm date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($fcpl_rtn->num_rows == 0){
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nothing to show here.</td>
                                    </tr>
                                    <?php        
                                        }
                                        else{
                                            while($cpl = mysqli_fetch_assoc($fcpl_rtn)){
                                    ?>
                                    <tr>
                                        <td><div><?php echo $cpl['cp_date']; ?></div></td>
                                        <td><div><?php echo $cpl['cpr_id']; ?></div></td>
                                        <td><div><?php echo $cpl['user_id']; ?></div></td>
                                        <td><div><?php echo $cpl['coin_amount']; ?></div></td>
                                        <td><div><?php echo $cpl['amount']; ?></div></td>
                                        <td><div><?php echo $cpl['payment_method']; ?></div></td>
                                        <td>
                                            <div>
                                                <button class="btn" data-bs-toggle="modal" data-bs-target="#prevSSImg"><?php echo $cpl['payment_ss']; ?></button>
                                                <div class="modal fade" id="prevSSImg">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="prevSsImg">
                                                                    <img src="../data/coin_purchase/<?php echo $cpl['payment_ss']; ?>" alt="payment ss">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </td>
                                        <td><div><?php echo $cpl['staff_id']; ?></div></td>
                                        <td><div><?php echo $cpl['confirm_date']; ?></div></td>
                                        <td><div><?php echo $cpl['status']; ?></div></td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                            <div class="px-auto">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="coin_purchase_history.php?page=<?php echo $prev; ?>">Previous</a></li>
                                        <?php
                                            for($i = 1; $i <= $total_pages; $i++){
                                        ?>
                                        <li class="page-item"><a class="page-link" href="coin_purchase_history.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php
                                            }
                                        ?>
                                        
                                        <li class="page-item"><a class="page-link" href="coin_purchase_history.php?page=<?php echo $next; ?>">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>