<?php
    require '../dbconfig.php';
    include '../controller.php';
    date_default_timezone_set("Asia/Yangon");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURMICS - Coin Purchase List</title>
    <link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../bs5.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
    <?php
        $f_cpl = "SELECT C.cpr_id, C.user_id, C.coin_amount, C.amount, C.cp_date, C.payment_ss, P.payment_method FROM coin_purchase_rec C INNER JOIN payment_method P ON C.pm_id = P.pm_id WHERE C.status = 'Pending' ORDER BY C.cp_date";
        $fcpl_rtn = mysqli_query($dbconn, $f_cpl);
    ?>
    <div class="container-fluid vh-100">
        <div class="row min-vh-100">
            <div class="col-2 bg-light pe-0">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-10 bg-secondary-subtle px-1">
                <div class="p-3">
                    <div class="row">
                        <div class="text-center mb-3">
                            <h3>Coin Purchase List</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bg-light rounded p-3">
                            <table id="purc_list_table" class="table table-striped align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Coin</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Receipt</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($fcpl_rtn->num_rows == 0){
                                    ?>
                                    <tr>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>--</td>
                                    </tr>
                                    <?php        
                                        }
                                        else{
                                            while($cpl = mysqli_fetch_assoc($fcpl_rtn)){
                                    ?>
                                    <tr>
                                        <td><div class="mt-2"><?php echo $cpl['cp_date']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $cpl['cpr_id']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $cpl['coin_amount']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $cpl['amount']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $cpl['payment_method']; ?></div></td>
                                        <td>
                                            <div>
                                                <button class="btn" data-bs-toggle="modal" data-bs-target="#<?php echo $cpl['payment_ss']; ?>"><?php echo $cpl['payment_ss']; ?></button>
                                                <div class="modal fade" id="<?php echo $cpl['payment_ss']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="prevSsImg">
                                                                    <img src="../data/coin_purchase/<?php echo $cpl['payment_ss']; ?>" alt="payment ss" style="max-height: 700px; width:350px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </td>
                                        <td>
                                            <form method="post">
                                                <button class="btn btn-danger" type="submit" name="<?php echo $cpl['cpr_id']; ?>reject">Cancel</button>
                                                <button class="btn btn-primary" type="submit" name="<?php echo $cpl['cpr_id']; ?>accept">Confirm</button>
                                            </form>
                                            <?php
                                                if(isset($_REQUEST[$cpl['cpr_id'].'reject']) || isset($_REQUEST[$cpl['cpr_id'].'accept'])){
                                                    $staff_id = $_SESSION['stid'];
                                                    $update_Date = date('Y-m-d H:i:s');
                                                    $cpl_id = $cpl['cpr_id'];

                                                    if(isset($_REQUEST[$cpl['cpr_id'].'accept'])){
                                                        $sts = "Success";
                                                        $userID = $cpl['user_id'];
                                                        $c_amt = $cpl['coin_amount'];
                                                        add_coin($userID, $c_amt);
                                                    }else
                                                        $sts = "Rejected";

                                                    $update_pay = "UPDATE coin_purchase_rec SET confirm_date = '$update_Date', staff_id = '$staff_id', status = '$sts' WHERE cpr_id = '$cpl_id'";
                                                    $update_rtn = mysqli_query($dbconn, $update_pay);

                                                    if($update_rtn)
                                                        echo "<script>
                                                            alert('update success.');
                                                            location.assign('coin_purchase_list.php');
                                                        </script>";
                                                    else
                                                        echo mysqli_error($dbconn);
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>	
        new DataTable('#purc_list_table');
    </script>
</body>
</html>