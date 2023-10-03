<?php
    require 'dbconfig.php';
    include 'controller.php';
    session_start();
    date_default_timezone_set("Asia/Yangon");

    if(isset($_GET['sid']))
        $seriesID = $_GET['sid'];
    else
        $seriesID = "none";

    if(isset($_GET['chap']))
        $chapterNo = $_GET['chap'];
    else
        $chapterNo = "none";

    $getChapDtl = "SELECT * FROM chapter WHERE chap_no = '$chapterNo' AND series_id = '$seriesID'";
    $gcd_rtn = mysqli_query($dbconn, $getChapDtl);
    $chapDetail = mysqli_fetch_assoc($gcd_rtn);

    if($chapterNo == getFirstChap($seriesID)){
        $prevbtn = "invisible";
        $nxtbtn = "visible";
    }elseif($chapterNo == getLastChap($seriesID)){
        $prevbtn = "visible";
        $nxtbtn = "invisible";
    }else{
        $prevbtn = "visible";
        $nxtbtn = "visible";
    }
    
    $curr = $_GET['chap'];
    if($curr == getFirstChap($seriesID))
        $prev = $curr;
    else{
        $numb = intval(substr($curr, 5));
        $numb--;
        $prev = "Chap " . $numb;
    }
    
    if($curr == getLastChap($seriesID))
        $next = $curr;
    else{
        $numb = intval(substr($curr, 5));
        $numb++;
        $next = "Chap " . $numb;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getSeriesName($seriesID) . " - " . $chapterNo; ?> - BURMICS</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="bs5.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <section>
        <div>
            <button class="btn btn-success rounded-circle goTop" id="goToTop" ><i class="bi bi-arrow-up-short fs-1"></i></button>
        </div>
        <div class="container py-5">
            <div class="mb-5">
                <h2 id="top"><?php echo getSeriesName($seriesID) . " - " . $chapterNo; ?></h2>
            </div>
            <nav class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="home.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="series.php?sid=<?php echo $seriesID; ?>"><?php echo getSeriesName($seriesID); ?></a></li>
                    <li class="breadcrumb-item"><?php echo $chapterNo; ?></li>
                </ol>
            </nav>
            <div class="row justify-content-between mb-3">
                <div class="col-1 <?php echo $prevbtn; ?>"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $prev; ?>'">Prev</button></div>
                <div class="col-1">
                    <div class="dropdown">
                        <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown"><?php echo $chapterNo; ?></button>
                        <ul class="dropdown-menu chapListDD p-0">
                            <?php
                                $fetChs = "SELECT chap_no FROM chapter WHERE series_id = '$seriesID' ORDER BY chap_no DESC";
                                $fc_rtn = mysqli_query($dbconn, $fetChs);
                                while($chInfo = mysqli_fetch_assoc($fc_rtn)){
                            ?>
                            <li><a class="dropdown-item" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chInfo['chap_no']; ?>"><?php echo $chInfo['chap_no']; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-1 <?php echo $nxtbtn; ?>"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $next; ?>'">Next</button></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="display_content">
                        <?php 
                            $images = json_decode($chapDetail['images'],true);
                            foreach ($images as $img){
                        ?>
                        <img src="data/series/<?php echo getSeriesName($seriesID); ?>/<?php echo $chapterNo ?>/<?php echo $img; ?>" alt="<?php echo $img; ?>">
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between mt-5">
                <div class="col-1 <?php echo $prevbtn; ?>"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $prev; ?>'">Prev</button></div>
                <div class="col-1">
                    <div class="dropdown">
                        <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown"><?php echo $chapterNo; ?></button>
                        <ul class="dropdown-menu chapListDD p-0">
                            <?php
                                $fetChs = "SELECT chap_no FROM chapter WHERE series_id = '$seriesID' ORDER BY chap_no DESC";
                                $fc_rtn = mysqli_query($dbconn, $fetChs);
                                while($chInfo = mysqli_fetch_assoc($fc_rtn)){
                            ?>
                            <li><a class="dropdown-item" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chInfo['chap_no']; ?>"><?php echo $chInfo['chap_no']; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-1 <?php echo $nxtbtn; ?>"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $next; ?>'">Next</button></div>
            </div>
        </div>
    </section>
    <?php
        $getChView = "SELECT * FROM chap_read_track ORDER BY crt_id DESC LIMIT 1";
        $gcv_rtn = mysqli_query($dbconn, $getChView);
        if($gcv_rtn->num_rows == 0){
            $crtID = "CR000001";
        }
        else{
            $crtInfo = mysqli_fetch_assoc($gcv_rtn);
            $chapRead = $crtInfo['crt_id'];
            $crtID = ++$chapRead;
        }

        $chID = $chapDetail['chap_id'];
        $uID = $_SESSION['uid'];
        $curDate = date('Y-m-d H:i:s');

        $getCRD = "SELECT read_date FROM chap_read_track WHERE chap_id = '$chID' AND user_id = '$uID' ORDER BY read_date DESC LIMIT 1";
        $gcrd_rtn = mysqli_query($dbconn, $getCRD);
        if($gcrd_rtn->num_rows == 0){
            $addRow = "INSERT INTO chap_read_track VALUES ('$crtID','$uID','$chID','$curDate')";
            $ar_rtn = mysqli_query($dbconn, $addRow);
            incCount($chID,$curDate);
        }else{
            $crdInfo = mysqli_fetch_assoc($gcrd_rtn);
            $lastDate = $crdInfo['read_date'];
            $ts1 = strtotime($curDate);
            $ts2 = strtotime($lastDate);
            if($ts1 - $ts2 > 45){
                $addRow = "INSERT INTO chap_read_track VALUES ('$crtID','$uID','$chID','$curDate')";
                $ar_rtn = mysqli_query($dbconn, $addRow);
                incCount($chID,$curDate);
            }
        }
    ?>
    <script>
        const goTopBtn = document.querySelector('.goTop');
        window.addEventListener('scroll',function(){
            if(window.scrollY > 200)
                goTopBtn.style.display = "flex";
            else
                goTopBtn.style.display = "none";
        });
        $(document).ready(function() {
            $("#goToTop").click(function() {
                $("html, body").animate({ scrollTop: 0 }, 10);
            });
        });
    </script>
</body>
</html>