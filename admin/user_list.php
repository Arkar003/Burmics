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
    <title>BURMICS - User List</title>
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
        $f_user = "SELECT * FROM user";
        $fu_rtn = mysqli_query($dbconn, $f_user);
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
                            <h3>All User Account List</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bg-light rounded p-3">
                            <table id="user_list_tb" class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>User_ID</th>
                                        <th>Username</th>
                                        <th>Email Address</th>
                                        <th>Type</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Warnings</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($fu_rtn->num_rows == 0){
                                    ?>
                                    <tr>
                                        <td>--</td>
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
                                            while($users = mysqli_fetch_assoc($fu_rtn)){
                                    ?>
                                    <tr>
                                        <td><div class="mt-2"><?php echo $users['user_id']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $users['username']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $users['email']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $users['acc_type']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $users['create_date']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $users['status']; ?></div></td>
                                        <td><div class="mt-2"><?php echo getWarningCount($users['user_id']); ?></div></td>
                                        <td>
                                            <?php
                                                if(isBanned($users['user_id'])){
                                            ?>
                                            <button class="btn btn-outline-danger px-4 fw-bold" disabled>BANNED</button>
                                            <?php
                                                }else{
                                            ?>
                                            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo $users['user_id']; ?>w">Warn</button>
                                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo $users['user_id']; ?>b">Ban</button>
                                            <?php
                                                }
                                            ?>
                                            
                                        </td>
                                        <div class="modal fade" id="<?php echo $users['user_id']; ?>w">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">User Account Warning</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" for="user_id">User ID :</label>
                                                                        <input class="form-control" placeholder="<?php echo $users['user_id']; ?>" type="text" id="user_id" disabled readonly>
                                                                    </div>
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" for="user_name">Username :</label>
                                                                        <input class="form-control" placeholder="<?php echo $users['username']; ?>" type="text" id="user_name" disabled readonly>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="warnReason" class="form-label">Give a reason</label>
                                                                        <textarea class="form-control" name="warnReason" id="warnReason" rows="3" required></textarea>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <div class="text-center">
                                                                            <button class="btn btn-outline-secondary" type="reset" data-bs-dismiss="modal">Cancel</button>
                                                                            <button class="btn btn-warning" type="submit" name="<?php echo $users['user_id']; ?>warn">Warn</button>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="<?php echo $users['user_id']; ?>b">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">User Account Banning</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" for="user_id">User ID :</label>
                                                                        <input class="form-control" placeholder="<?php echo $users['user_id']; ?>" type="text" id="user_id" disabled readonly>
                                                                    </div>
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" for="user_name">Username :</label>
                                                                        <input class="form-control" placeholder="<?php echo $users['username']; ?>" type="text" id="user_name" disabled readonly>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label" for="banDura">Banning Period (in days) :</label>
                                                                        <input class="form-control" type="number" id="banDura" name="banDura">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="banReason" class="form-label">Give a reason</label>
                                                                        <textarea class="form-control" id="banReason" rows="3" name="banReason" required></textarea>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <div class="text-center">
                                                                            <button class="btn btn-outline-secondary" type="reset" data-bs-dismiss="modal">Cancel</button>
                                                                            <button class="btn btn-danger" type="submit" name="<?php echo $users['user_id']; ?>ban">Ban</button>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            if(isset($_REQUEST[$users['user_id']."warn"]) || isset($_REQUEST[$users['user_id']."ban"])){
                                                $user_id = $users['user_id'];
                                                $banDate = date('Y-m-d');
                                                if(isset($_REQUEST[$users['user_id']."warn"])){
                                                    $dura = "";
                                                    $releaseDate = "";
                                                    $reason = $_REQUEST['warnReason'];
                                                    $sts = "Warning";
                                                }else{
                                                    $dura = $_REQUEST['banDura'];
                                                    $releaseDate = date('Y-m-d H:i:s', strtotime('+'.$dura.' day',strtotime($banDate)));
                                                    $reason = $_REQUEST['banReason'];
                                                    $sts = "Banned";
                                                }

                                                $check_banned = "SELECT * FROM bannedList WHERE user_id = '$user_id' AND release_date != '0000-00-00' AND status = 'Banned'";
                                                $cb_rtn = mysqli_query($dbconn,$check_banned);
                                                if($cb_rtn->num_rows == 0){
                                                    $get_last = "SELECT ban_id FROM bannedList ORDER BY ban_id DESC LIMIT 1";
                                                    $glst_rtn = mysqli_query($dbconn, $get_last);
                                                    if($glst_rtn->num_rows == 0)
                                                        $bID = "B0000001";
                                                    else{
                                                        $banListData = mysqli_fetch_assoc($glst_rtn);
                                                        $bID = ++$banListData['ban_id'];
                                                    }

                                                    $add_to_List = "INSERT INTO bannedList VALUES ('$bID','$user_id','$dura','$reason','$banDate','$releaseDate','$sts')";
                                                    $atl_rtn = mysqli_query($dbconn, $add_to_List);

                                                    if($sts = "Banned"){
                                                        $check_warning = "SELECT * FROM bannedList WHERE user_id = '$user_id' AND status = 'Warning'";
                                                        $cw_rtn = mysqli_query($dbconn, $check_warning);
                                                        if($cw_rtn->num_rows != 0){
                                                            while($warnData = mysqli_fetch_assoc($cw_rtn)){
                                                                $w_bid = $warnData['ban_id'];
                                                                $upd_w = "UPDATE bannedList SET status = 'Warned' WHERE ban_id = '$w_bid'";
                                                                $uw_rtn = mysqli_query($dbconn, $upd_w);
                                                            }
                                                        }
                                                    }

                                                    if($atl_rtn)
                                                        echo "<script>alert('update success.');
                                                        location.assign('user_list.php');</script>";
                                                }else
                                                    echo "<script>alert('Already Banned');</script>";

                                                
                                            }                                
                                        ?>
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
        new DataTable('#user_list_tb');
    </script>
</body>
</html>