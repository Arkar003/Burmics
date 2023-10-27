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
    <title>BURMICS - Banned List</title>
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
        $f_banned = "SELECT * FROM bannedList WHERE status = 'Banned' AND release_date != '0000-00-00'";
        $fb_rtn = mysqli_query($dbconn, $f_banned);
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
                            <h3>Banned User Account List</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bg-light rounded p-3">
                            <table id="Banned_List_table" class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Ban ID</th>
                                        <th>User_ID</th>
                                        <th>Username</th>
                                        <th>Banned Date</th>
                                        <th>Release Date</th>
                                        <th>Duration</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($fb_rtn->num_rows == 0){
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
                                            while($bUsers = mysqli_fetch_assoc($fb_rtn)){
                                    ?>
                                    <tr>
                                        <td><div class="mt-2"><?php echo $bUsers['ban_id']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $bUsers['user_id']; ?></div></td>
                                        <td><div class="mt-2"><?php echo getUserName($bUsers['user_id']); ?></div></td>
                                        <td><div class="mt-2"><?php echo $bUsers['ban_date']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $bUsers['release_date']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $bUsers['period']; ?></div></td>
                                        <td><div class="mt-2"><?php echo $bUsers['reason']; ?></div></td>
                                        <td>
                                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo $bUsers['ban_id']; ?>e">Edit</button>
                                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo $bUsers['ban_id']; ?>r">Release Now</button>
                                        </td>
                                        <div class="modal fade" id="<?php echo $bUsers['ban_id']; ?>e">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit banned account</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" for="user_id">User ID :</label>
                                                                        <input class="form-control" placeholder="<?php echo $bUsers['user_id']; ?>" type="text" id="user_id" disabled readonly>
                                                                    </div>
                                                                    <div class="col-6 mb-3">
                                                                        <label class="form-label" for="user_name">Username :</label>
                                                                        <input class="form-control" placeholder="<?php echo getUserName($bUsers['user_id']); ?>" type="text" id="user_name" disabled readonly>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label" for="editBanDura">Banning Period (in days) :</label>
                                                                        <input class="form-control" type="number" id="editBanDura" name="editBanDura" value="<?php echo $bUsers['period']; ?>">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="editReason" class="form-label">Reason</label>
                                                                        <textarea class="form-control" name="editReason" id="editReason" rows="3" required><?php echo $bUsers['reason']; ?></textarea>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <div class="text-center">
                                                                            <button class="btn btn-outline-secondary" type="reset" data-bs-dismiss="modal">Cancel</button>
                                                                            <button class="btn btn-primary" type="submit" name="<?php echo $bUsers['ban_id']; ?>edit">Edit</button>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="<?php echo $bUsers['ban_id']; ?>r">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Are you sure?</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p>User id : <?php echo $bUsers['user_id']; ?></p>
                                                                        <p>Username : <?php echo getUserName($bUsers['user_id']); ?></p>
                                                                        <p>You are about to release this account from banned list. <br> Are you sure?</p>
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <div class="text-center">
                                                                            <button class="btn btn-outline-secondary" type="reset" data-bs-dismiss="modal">Cancel</button>
                                                                            <button class="btn btn-success" type="submit" name="<?php echo $bUsers['ban_id']; ?>release">Confirm</button>
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
                                            if(isset($_REQUEST[$bUsers['ban_id']."edit"])){
                                                $banID = $bUsers['ban_id'];
                                                $bannedDate = $bUsers['ban_date'];
                                                $newPeriod = $_REQUEST['editBanDura'];
                                                $newRson = $_REQUEST['editReason'];
                                                $newRlDate = date('Y-m-d H:i:s', strtotime('+'.$newPeriod.' day',strtotime($bannedDate)));
                                                $upd_ban = "UPDATE bannedList SET period = '$newPeriod', reason = '$newRson', release_date = '$newRlDate' WHERE ban_id = '$banID'";
                                                $upb_rtn = mysqli_query($dbconn, $upd_ban);
                                                if($upb_rtn)
                                                    echo "<script>alert('Edited successfully.');
                                                    location.assign('bannedList.php');</script>";
                                            }

                                            if(isset($_REQUEST[$bUsers['ban_id']."release"])){
                                                $banID = $bUsers['ban_id'];
                                                $newPeriod = 0;
                                                $newRlDate = "";
                                                $upd_ban = "UPDATE bannedList SET period = '$newPeriod', release_date = '$newRlDate' WHERE ban_id = '$banID'";
                                                $upb_rtn = mysqli_query($dbconn, $upd_ban);
                                                if($upb_rtn)
                                                    echo "<script>alert('Released successfully.');
                                                    location.assign('bannedList.php');</script>";
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
        new DataTable('#Banned_List_table');
    </script>
</body>
</html>