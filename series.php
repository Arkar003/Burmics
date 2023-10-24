<?php
    require 'dbconfig.php';
    include 'controller.php';
    session_start();
    if(isset($_GET['sid']))
        $seriesID = $_GET['sid'];
    else
        $seriesID = "none";
    
    $uID = $_SESSION['uid'];
    $getSDetail = "SELECT * FROM series WHERE series_id = '$seriesID'";
    $gsd_rtn = mysqli_query($dbconn, $getSDetail);
    $seriesDetail = mysqli_fetch_assoc($gsd_rtn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURMICS - <?php echo getSeriesName($seriesID); ?></title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
		<?php include 'nav.php'; ?>
	</header>
    <?php
		if(isFreeAcc($_SESSION['uid']) && checkOverLimit($_SESSION['uid'])){
	?>
	<section class="bg-success-subtle p-5 min-vh-100">
		<div class="container align-items-center justify-content-center">
			<div class="text-center">
				<h4>Your free access [free 10 chaps a day] for today is used up.</h4>
				<h4>Wait till tomorrow.</h4>
				<h4>If you are losing patience, you can buy our premium packages.</h4>
				<h4>Buy our premium packages and read unlimited chapters.</h4>
				<div class="m-5">
					<button class="btn btn-success fs-5 px-3" type="button" data-bs-toggle="modal" data-bs-target="#packagePurc">Purchase Premium</button>
				</div>
			</div>
		</div>
	</section>
	<?php
		}else{
	?>
    <section>
        <div class="container pt-2 pb-5">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="home.php">Home</a></li>
                    <li class="breadcrumb-item"><?php echo getSeriesName($seriesID); ?></li>
                </ol>
            </nav>
            <div class="row rounded-5 bg-dark-subtle p-4 mb-5">
                <div class="col-3">
                    <div class="show-series-cv rounded-4 me-auto">
						<img src="data/cv/<?php echo $seriesDetail['cover_img']; ?>" alt="<?php echo $seriesDetail['series_name']; ?>">
					</div>
                </div>
                <div class="col-6">
                    <div class="p-3">
                        <div class="mb-3"><h1><?php echo $seriesDetail['series_name']; ?></h1></div>
                        <div class="fs-4 mb-3">
                            <div class="bg-danger rounded d-inline-block px-2">views : <?php echo getTotalViews($seriesDetail['series_id']); ?></div>
                            <div class="bg-danger rounded d-inline-block px-2">Rating : <?php echo getSeriesRating($seriesDetail['series_id']); ?></div>
                        </div>
                        <div class="fs-4 mb-3">Author : <?php echo $seriesDetail['author']; ?></div>
                        <div class="fs-4 mb-3">Artist(s) : <?php echo $seriesDetail['artist']; ?></div>
                        <div class="fs-4 mb-3">Genres : <?php echo $seriesDetail['genre_1']; ?>, <?php echo $seriesDetail['genre_2']; ?>, <?php echo $seriesDetail['genre_3']; ?></div>                            
                        <div class="fs-4 mb-3">Age restriction : <?php echo $seriesDetail['age_restrict']; ?></div>
                        <div class="fs-4 mb-3">Release date : <?php echo $seriesDetail['create_date']; ?></div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="p-3 pe-0">
                       <div class="mb-3 fs-4">
                            <span class="fs-5">Publish By</span> <br> <?php echo getUserName(getUserId($seriesDetail['creator_id'])); ?>
                        </div>
                        <div class="mb-3">
                            <form method="post">
                                <?php
                                    if(alrdySaved($uID,$seriesDetail['series_name'])){
                                ?>
                                <button class="btn btn-danger w-100 fs-5" type="submit" name="rmvBookmark"><i class="bi bi-bookmark-dash"></i> Remove From Library</button>
                                <?php
                                    }else{
                                ?>
                                <button class="btn btn-danger w-100 fs-5" type="submit" name="bookmark"><i class="bi bi-bookmark-check"></i> Add to Library</button>
                                <?php
                                    }
                                ?>
                            </form>
                        </div>
                        <?php
                            $creatorUID = getUserId($seriesDetail['creator_id']);
                            if($uID == $creatorUID){
                        ?>
                        <div class="mb-3">
                            <div class="py-4 bg-success rounded">
                                <h5 class="text-center">You cannot rate your own series.</h5>
                            </div>
                        </div>
                        <?php
                            }else{
                                $get_sRating = "SELECT * FROM series_rating WHERE series_id = '$seriesID' AND user_id = '$uID'";
                                $gsr_rtn = mysqli_query($dbconn, $get_sRating);
                                if($gsr_rtn->num_rows == 0){
                        ?>
                        <div class="mb-3">
                            <?php include 'series_rating.php'; ?>
                        </div>
                        <?php
                                }else{
                        ?>
                        <div class="mb-3">
                            <div class="py-4 bg-success rounded text-center">
                                <h5 class="">Already rated this series.</h5>
                                <a class="text-dark" href="#">See reviews</a>
                            </div>
                        </div>
                        <?php
                                }
                            }  
                        ?>
                    </div>
                </div>
            </div>
            <div class="row p-4 mb-5">
                <div class="border-bottom border-2 border-danger"><h4>Description</h4></div>
                <div class="border-bottom border-2 border-danger py-3 mb-5">
                    <span>
                        <?php 
                            if($seriesDetail['description'])
                                echo $seriesDetail['description'];
                            else
                                echo "No description for this series.";
                        ?>
                    </span>
                </div>
                <div>
                    <h4 class="mb-4">Chapters</h4>
                    <div class="container">
                        <div class="row">
                            <?php
                                $getChaps = "SELECT * FROM chapter WHERE series_id = '$seriesID' AND (status != 'private' AND status != 'draft') ORDER BY chap_no DESC";
                                $gc_rtn = mysqli_query($dbconn, $getChaps);
                                while($chapInfo = mysqli_fetch_assoc($gc_rtn)){
                                    if($chapInfo['status'] == "locked"){
                                        $chID = $chapInfo['chap_id'];
                                        if(!hasBoughtEA($chID,$uID)){
                            ?>
                            <div class="col-6">
                                <div class="rounded bg-dark-subtle py-2 ps-3 mb-3 ch-box">
                                    <a class="text-dark text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#<?php echo $chID; ?>"><h5 class="text-dark mb-0"><?php echo $chapInfo['chap_no']; ?></h5></a>
                                    <i class="bi bi-lock-fill lock_ic fs-5"></i>
                                </div>
                                <div class="modal fade" id="<?php echo $chID; ?>">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">The chaper is locked!</h3>
                                            </div>
                                            <div class="modal-body">
                                                <?php include 'ea_purchase.php'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                        }else{
                            ?>
                            <div class="col-6">
                                <div class="rounded bg-dark-subtle py-2 ps-3 mb-3 ch-box">
                                    <a class="text-dark text-decoration-none"  href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapInfo['chap_no']; ?>"><h5 class="text-dark mb-0"><?php echo $chapInfo['chap_no']; ?></h5></a>
                                    <i class="bi bi-unlock-fill lock_ic fs-5"></i>
                                </div>
                            </div>
                            <?php
                                        }
                                    }else{        
                            ?>
                            <div class="col-6">
                                <div class="rounded bg-dark-subtle py-2 ps-3 mb-3">
                                    <a class="text-dark text-decoration-none"  href="chapter.php?sid=<?php echo $seriesID; ?>&chap=<?php echo $chapInfo['chap_no']; ?>"><h5 class="text-dark mb-0"><?php echo $chapInfo['chap_no']; ?></h5></a>
                                </div>
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
		}
	?>
    <footer>
		<div class="container-fluid bg-body-tertiary pt-4">
			<?php include 'footer.php'; ?>
		</div>
	</footer>
    <?php 
        if(isset($_REQUEST['bookmark'])){
            $sname = $seriesDetail['series_name'];
            $fet_saved = "SELECT * FROM library WHERE user_id = '$uID'";
            $fs_rtn = mysqli_query($dbconn, $fet_saved);
            $libData = mysqli_fetch_assoc($fs_rtn);
            if($libData['series_names'] == "")
                $savedSeries = array();
            else
                $savedSeries = json_decode($libData['series_names'],true);
            $savedSeries[] = $sname;
            $serNames = json_encode($savedSeries);
            $upd_lib = "UPDATE library SET series_names = '$serNames' WHERE user_id = '$uID'";
            $upd_rtn = mysqli_query($dbconn, $upd_lib);
            if($upd_rtn)
                echo "<script>location.assign('series.php?sid=$seriesID');</script>";
            else
                echo mysqli_error($dbconn);
        }

        if(isset($_REQUEST['rmvBookmark'])){
            $sname = $seriesDetail['series_name'];
            $fet_saved = "SELECT * FROM library WHERE user_id = '$uID'";
            $fs_rtn = mysqli_query($dbconn, $fet_saved);
            $libData = mysqli_fetch_assoc($fs_rtn);
            $savedSeries = json_decode($libData['series_names'],true);
            $rmvedSeries = array();
            foreach($savedSeries as $ss){
                if($ss !== $sname)
                    $rmvedSeries[] = $ss;
            }
            $serNames = json_encode($rmvedSeries);
            $upd_lib = "UPDATE library SET series_names = '$serNames' WHERE user_id = '$uID'";
            $upd_rtn = mysqli_query($dbconn, $upd_lib);
            if($upd_rtn)
                echo "<script>location.assign('series.php?sid=$seriesID');</script>";
            else
                echo mysqli_error($dbconn);
        }
    ?>
</body>
</html>