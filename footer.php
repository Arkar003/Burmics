<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
<footer class="py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-3 px-3">
        <div class="d-flex col-2">
            <button class="btn btn-info text-light" type="button" data-bs-toggle="modal" data-bs-target="#donate">Buy us a coffee</button>
            <div class="modal fade" id="donate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Buy us a coffee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="mb-3 fs-5">Please support our development team. <br>
                            Buy us a coffee. Thanks in advance! <br></p>
                            <form method="post">
                                <div class="input-group w-50 mx-auto mb-3">
                                    <span class="input-group-text">Donate </span>
                                    <input class="form-control" type="number" name="damt" min="1">
                                    <span class="input-group-text">coins</span>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-success" name="donate" type="submit">Donate</button>
                                </div>
                            </form>
                            <?php
                                date_default_timezone_set("Asia/Yangon");
                                if(isset($_REQUEST['donate'])){
                                    $uid = $_SESSION['uid'];
                                    $damt = $_REQUEST['damt'];
                                    $curDate = date('Y-m-d');
                                    if($damt <= getCoins($uid)){
                                        $get_last = "SELECT donation_id FROM donation ORDER BY donation_id DESC LIMIT 1";
                                        $gl_rtn = mysqli_query($dbconn, $get_last);
                                        if($gl_rtn->num_rows == 0)
                                            $dID = "D0000001";
                                        else{
                                            $lastID = mysqli_fetch_assoc($gl_rtn);
                                            $dID = ++$lastID['donation_id'];
                                        }
                                        $addRow = "INSERT INTO donation VALUES ('$dID','$uid','$damt','$curDate')";
                                        $ar_rtn = mysqli_query($dbconn,$addRow);
                                        if($ar_rtn){
                                            reduce_coin($uid, $damt);
                                            echo "<script>alert('Thank you for supporting us.');
                                            location.assign('home.php');</script>";
                                        }
                                    }else
                                        echo "<script>alert('Thanks for trying to support us. But you do not have enough coin.');</script>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav justify-content-center">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Privacy Policy</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Appreciation</a></li>
        </ul>
        <div class="d-flex col-2 justify-content-end">
            <button class="btn btn-danger text-light" type="button" data-bs-toggle="modal" data-bs-target="#rateUs">Rate Us</button>
            <div class="modal fade" id="rateUs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">What do you thing about us?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <?php
                                if (isAlreadyRated($_SESSION['uid'])){
                            ?>
                            <h5>You have already rated our website! <br> Thank you.</h5>
                            <?php
                                }else 
                                    include 'rating.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center px-3">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                <h3>BURMICS</h3>
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© Arkar Minn, L5DC, 2023</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-facebook fs-2"></i></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-instagram fs-2"></i></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-github fs-2"></i></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-linkedin fs-2"></i></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><i class="bi bi-discord fs-2"></i></a></li>
        </ul>
    </div>
</footer>
