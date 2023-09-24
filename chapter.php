<?php
    require 'dbconfig.php';
    include 'controller.php';
    if(isset($_GET['sname']))
        $seriesName = $_GET['sname'];
    else
        $seriesName = "none";

    if(isset($_GET['chap']))
        $chapterNo = $_GET['chap'];
    else
        $chapterNo = "none";

    $sID = getSeriesId($seriesName);
    $getChapDtl = "SELECT * FROM chapter WHERE chap_no = '$chapterNo' AND series_id = '$sID'";
    $gcd_rtn = mysqli_query($dbconn, $getChapDtl);
    $chapDetail = mysqli_fetch_assoc($gcd_rtn);
    
    $curr = $_GET['chap'];
    
    if($curr == getFirstChap($sID))
        $prev = $curr;
    else{
        $numb = intval(substr($curr, 5));
        $numb--;
        $prev = "Chap " . $numb;
    }
    
    if($curr == getLastChap($sID))
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
    <title><?php echo $seriesName . " - " . $chapterNo; ?> - BURMICS</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="bs5.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <section>
        <div>
            <button class="btn btn-success rounded-circle goTop" onclick="window.location.href='#top'"><i class="bi bi-arrow-up-short fs-1"></i></button>
        </div>
        <div class="container py-5">
            <div class="mb-5">
                <h2 id="top"><?php echo $seriesName . " - " . $chapterNo; ?></h2>
            </div>
            <nav class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="home.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="series.php?sname=<?php echo $seriesName; ?>"><?php echo $seriesName; ?></a></li>
                    <li class="breadcrumb-item"><?php echo $chapterNo; ?></li>
                </ol>
            </nav>
            <div class="row justify-content-between mb-3">
                <div class="col-1"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $prev; ?>'">Prev</button></div>
                <div class="col-1">
                    <div class="dropdown">
                        <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown"><?php echo $chapterNo; ?></button>
                        <ul class="dropdown-menu chapListDD p-0">
                            <?php
                                $fetChs = "SELECT chap_no FROM chapter WHERE series_id = '$sID' ORDER BY chap_no DESC";
                                $fc_rtn = mysqli_query($dbconn, $fetChs);
                                while($chInfo = mysqli_fetch_assoc($fc_rtn)){
                            ?>
                            <li><a class="dropdown-item" href="chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $chInfo['chap_no']; ?>"><?php echo $chInfo['chap_no']; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-1"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $next; ?>'">Next</button></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="display_content">
                        <?php 
                            $images = json_decode($chapDetail['images'],true);
                            foreach ($images as $img){
                        ?>
                        <img src="data/series/<?php echo $seriesName; ?>/<?php echo $chapterNo ?>/<?php echo $img; ?>" alt="<?php echo $img; ?>">
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between mt-5">
                <div class="col-1"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $prev; ?>'">Prev</button></div>
                <div class="col-1">
                    <div class="dropdown">
                        <button class="btn btn-primary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown"><?php echo $chapterNo; ?></button>
                        <ul class="dropdown-menu chapListDD p-0">
                            <?php
                                $fetChs = "SELECT chap_no FROM chapter WHERE series_id = '$sID' ORDER BY chap_no DESC";
                                $fc_rtn = mysqli_query($dbconn, $fetChs);
                                while($chInfo = mysqli_fetch_assoc($fc_rtn)){
                            ?>
                            <li><a class="dropdown-item" href="chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $chInfo['chap_no']; ?>"><?php echo $chInfo['chap_no']; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-1"><button class="btn btn-primary w-100" onclick="window.location.href='chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $next; ?>'">Next</button></div>
            </div>
        </div>
    </section>
    <script>
        const goTopBtn = document.querySelector('.goTop');
        window.addEventListener('scroll',function(){
            if(window.scrollY > 200)
                goTopBtn.style.display = "flex";
            else
                goTopBtn.style.display = "none";
        })
    </script>
</body>
</html>