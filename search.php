<?php 
	session_start();
    require 'dbconfig.php';
	include 'controller.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURMICS - Search</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
		<?php include 'nav.php'; ?>
	</header>
    <section class="bg-success-subtle p-5 min-vh-100">
        <div class="container">
            <div class="row mt-3">
                <h5>Showing the results for : 
                    <?php
                        if(isset($_GET['srchInput']))
                            echo $_GET['srchInput'];
                        
                        if(isset($_GET['genre'])){
                            foreach($_GET['genre'] as $gen)
                                echo $gen . ", ";
                        }
                    ?>
                </h5>
            </div>
            <div class="row mt-3">
                <?php
                    if(isset($_REQUEST['search']) || isset($_REQUEST['filterSrch'])){
                        if(isset($_REQUEST['search'])){
                            $srcVal = $_GET['srchInput'];
                            $find_val = "SELECT * FROM series WHERE CONCAT(series_name, author, artist, genre_1, genre_2, genre_3) LIKE '%$srcVal%' AND last_update != '0000-00-00'";
                        }else{
                            $filVal = [];
                            $filVal = $_GET['genre'];
                            $filValStr = "'" . implode("', '", $filVal) . "'";
                            $find_val = "SELECT * FROM series WHERE (genre_1 IN ($filValStr) OR genre_2 IN ($filValStr) OR genre_3 IN ($filValStr))AND last_update != '0000-00-00'";
                        }
                        $fv_rtn = mysqli_query($dbconn, $find_val);
                        if($fv_rtn->num_rows == 0){
                ?>
                <div class="col-12">
                    <div>
                        <h2>Couldn't find anything. Try with another words or phrases.</h2>
                    </div>
                </div>
                <?php
                        }else{
                            while($srcSeries = mysqli_fetch_assoc($fv_rtn)){
                                $seriesID = $srcSeries['series_id'];
                ?>
                <div class="col-3 mb-4">
                    <div class="mb-5">
                        <div class="series-cv rounded mx-auto mb-2">
                            <a href="series.php?sid=<?php echo $seriesID; ?>" title="<?php echo $srcSeries['series_name']; ?>">
                                <img src="data/cv/<?php echo $srcSeries['cover_img']; ?>" alt="<?php echo $srcSeries['series_name']; ?>">
                            </a>
                        </div>
                        <div class="mx-4 px-2 mb-2 series-title">
							<h4 class="text-dark mb-0"><?php echo $srcSeries['series_name']; ?></h4>
						</div>
						<div class="mx-4 px-2 mb-2 text-dark">
							<i class="bi bi-eye-fill"></i> <?php echo getTotalViews($srcSeries['series_id']); ?>&nbsp;&nbsp; <i class="fa-solid fa-star"></i> <?php echo getSeriesRating($srcSeries['series_id']); ?>
						</div>
                        <?php
                                $chk_lastCh = "SELECT * FROM chapter WHERE series_id = '$seriesID' AND (status != 'private' AND status != 'draft') ORDER BY upload_date DESC LIMIT 1";
                                $chk_rtn = mysqli_query($dbconn, $chk_lastCh);
                                $chapDetail = mysqli_fetch_assoc($chk_rtn);
                                $chID = $chapDetail['chap_id'];
                                $uID = $_SESSION['uid'];
                                if($chapDetail['status'] == "locked"){
                                    if(!hasBoughtEA($chID,$uID)){
						?>
						<div class="mx-4 rounded bg-success py-2 ps-3 ch-box">
							<a class="text-light text-decoration-none" href="series.php?sid=<?php echo $seriesID; ?>"><h5 class="mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
							<i class="bi bi-lock-fill lock_ic fs-5"></i>
						</div>
						<?php
								    }else{
						?>
						<div class="mx-4 rounded bg-success py-2 ps-3 ch-box>
							<a class="text-light text-decoration-none" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapDetail['chap_no']; ?>"><h5 class="mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
							<i class="bi bi-unlock-fill lock_ic fs-5"></i>
						</div>
						<?php
                                    }
                                }else{
						?>
						<div class="mx-4 rounded bg-success py-2 ps-3 ch-box">
							<a class="text-light text-decoration-none" href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapDetail['chap_no']; ?>"><h5 class="mb-0"><?php echo $chapDetail['chap_no']; ?></h5></a>
						</div>
						<?php
							    }
						?>
                    </div>
                </div>
                <?php
                            } 
                        }
                    }
                ?>
            </div>
        </div>
        
    </section>
</body>
</html>