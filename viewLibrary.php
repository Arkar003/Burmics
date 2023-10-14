<?php 
    require 'dbconfig.php';
	include 'controller.php';
    session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
		<?php include 'nav.php'; ?>
	</header>
    <section class="bg-success-subtle pt-5">
        <div class="container">
            <div class="row">
                <?php
                    $uID = $_SESSION['uid'];
                    $get_lib = "SELECT * FROM library WHERE user_id = '$uID'";
                    $gl_rtn = mysqli_query($dbconn,$get_lib);
                    $library = mysqli_fetch_assoc($gl_rtn);
                    if($library['series_names'] == ""){
                ?>
                <div class="col-12"><h3>You haven't saved any series at all.  That's why there's nothing to show.</h3></div>
                <?php
                    }else{
                        $savedSeries = json_decode($library['series_names'],true);
                        foreach($savedSeries as $sname){
                            $get_series = "SELECT * FROM series WHERE series_name = '$sname'";
                            $gs_rtn = mysqli_query($dbconn, $get_series);
                            $sDetail = mysqli_fetch_assoc($gs_rtn);
                            $sID = $sDetail['series_id'];
                ?>
                <div class="col-3 mb-4">
                    <div class="mb-5">
                        <div class="series-cv rounded mx-auto mb-2">
                            <a href="series.php?sid=<?php echo $sID; ?>" title="<?php echo $sDetail['series_name']; ?>">
								<img src="data/cv/<?php echo $sDetail['cover_img']; ?>" alt="<?php echo $sDetail['series_name']; ?>">
							</a>
                        </div>
                        <div class="series-title mx-4 mb-2">
                            <h4 class="text-light mb-0"><?php echo $sDetail['series_name']; ?></h4>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
        
    </section>
    
</body>
</html>