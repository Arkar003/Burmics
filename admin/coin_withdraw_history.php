<?php
    require '../dbconfig.php';
    include '../controller.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURMICS - Coin Withdraw History</title>
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
        $f_cwl = "SELECT W.w_id, W.creator_id, W.coin_amount, W.amount, P.payment_method, W.acc_holder, W.acc_number, W.w_date, W.staff_id, W.confirm_date, W.status FROM coin_withdraw_rec W INNER JOIN payment_method P ON W.pm_id = P.pm_id WHERE W.status = 'Success' OR W.status='Rejected' ORDER BY W.w_date";
        $fcwl_rtn = mysqli_query($dbconn, $f_cwl);
    ?>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-2 bg-light pe-0">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-10 bg-secondary-subtle px-1">
                <div class="p-3">
                    <div class="row">
                        <div class="text-center mb-3">
                            <h3>Coin Withdrawal History</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bg-light rounded p-3">
                            <table id="with_history" class="table table-striped align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Creator</th>
                                        <th>Coin</th>
                                        <th>Amount</th>
                                        <th>Payment details</th>
                                        <th>Staff</th>
                                        <th>Request Date</th>
                                        <th>Confirm date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($fcwl_rtn->num_rows == 0){
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Nothing to show here.</td>
                                    </tr>
                                    <?php        
                                        }
                                        else{
                                            while($cwl = mysqli_fetch_assoc($fcwl_rtn)){
                                    ?>
                                    <tr>
                                        <td><div><?php echo $cwl['w_id']; ?></div></td>
                                        <td><div><?php echo getUserName(getUserId($cwl['creator_id'])); ?></div></td>
                                        <td><div><?php echo $cwl['coin_amount']; ?></div></td>
                                        <td><div><?php echo $cwl['amount']; ?></div></td>
                                        <td>
                                            <div>
                                                <button class="btn" data-bs-toggle="modal" data-bs-target="#moreDetails"><?php echo $cwl['payment_method']; ?></button>
                                                <div class="modal fade" id="moreDetails">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5>Request ID : <?php echo $cwl['w_id']; ?></h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-6 text-end">Creator ID :</div>
                                                                        <div class="col-6 text-start"><?php echo $cwl['creator_id']; ?></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6 text-end">Payment Type :</div>
                                                                        <div class="col-6 text-start"><?php echo $cwl['payment_method']; ?></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6 text-end">Acc holder name :</div>
                                                                        <div class="col-6 text-start"><?php echo $cwl['acc_holder']; ?></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6 text-end">Acc Number :</div>
                                                                        <div class="col-6 text-start"><?php echo $cwl['acc_number']; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div><?php echo getStaffName($cwl['staff_id']); ?></div></td>
                                        <td><div><?php echo $cwl['w_date']; ?></div></td>
                                        <td><div><?php echo $cwl['confirm_date']; ?></div></td>
                                        <td><div><?php echo $cwl['status']; ?></div></td>
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
        new DataTable('#with_history');
    </script>
</body>
</html>