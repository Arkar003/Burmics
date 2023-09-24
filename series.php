<?php
    require 'dbconfig.php';
    include 'controller.php';
    session_start();
    if(isset($_GET['sname']))
        $seriesName = $_GET['sname'];
    else
        $seriesName = "none";

    $getSDetail = "SELECT * FROM series WHERE series_name = '$seriesName'";
    $gsd_rtn = mysqli_query($dbconn, $getSDetail);
    $seriesDetail = mysqli_fetch_assoc($gsd_rtn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BURMICS - <?php echo $seriesName; ?></title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
		<?php include 'nav.php'; ?>
	</header>
    <section>
        <div class="container pt-2 pb-5">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-dark text-decoration-none" href="home.php">Home</a></li>
                    <li class="breadcrumb-item"><?php echo $seriesName; ?></li>
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
                            <div class="bg-danger rounded d-inline-block p-2">views : 0</div>
                            <div class="bg-danger rounded d-inline-block p-2">Rating : 0</div>
                        </div>
                        <div class="fs-4 mb-3">Author : <?php echo $seriesDetail['author']; ?></div>
                        <div class="fs-4 mb-3">Artist(s) : <?php echo $seriesDetail['artist']; ?></div>
                        <div class="fs-4 mb-3">Genres : <?php echo $seriesDetail['genre_1']; ?>, <?php echo $seriesDetail['genre_2']; ?>, <?php echo $seriesDetail['genre_3']; ?></div>                            <div class="fs-4 mb-3">Age restriction : <?php echo $seriesDetail['age_restrict']; ?></div>
                        <div class="fs-4 mb-3">Release date : <?php echo $seriesDetail['create_date']; ?></div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="p-3">
                       <div class="mb-3 fs-4">
                            Publish By <?php echo getUserName(getUserId($seriesDetail['creator_id'])); ?>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-danger w-100">Add to Library</button>
                        </div>
                        <div class="mb-3">
                            <h4>Rate the series</h4>
                        </div>
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
                                $seriesID = $seriesDetail['series_id'];
                                $getChaps = "SELECT chap_no FROM chapter WHERE series_id = '$seriesID' ORDER BY chap_no DESC";
                                $gc_rtn = mysqli_query($dbconn, $getChaps);
                                while($chapInfo = mysqli_fetch_assoc($gc_rtn)){
                            ?>
                            <div class="col-6">
                                <div class="rounded bg-dark-subtle py-2 ps-3 mb-3">
                                    <a class="text-dark text-decoration-none" href="chapter.php?sname=<?php echo $seriesName; ?>&chap=<?php echo $chapInfo['chap_no']; ?>"><h5 class="text-dark mb-0"><?php echo $chapInfo['chap_no']; ?></h5></a>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>