<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series Ratings</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="rate-container bg-secondary-subtle py-3 rounded">
        <h4 class="text-center">Rate the series</h4>
        <form action="#" method="post">
            <div class="star-widget">
                <input type="radio" name="series_rating" id="star5" value="5">
                <label for="star5" class="fas fa-star mb-3"></label>
                <input type="radio" name="series_rating" id="star4" value="4">
                <label for="star4" class="fas fa-star mb-3"></label>
                <input type="radio" name="series_rating" id="star3" value="3">
                <label for="star3" class="fas fa-star mb-3"></label>
                <input type="radio" name="series_rating" id="star2" value="2">
                <label for="star2" class="fas fa-star mb-3"></label>
                <input type="radio" name="series_rating" id="star1" value="1">
                <label for="star1" class="fas fa-star mb-3"></label>
            </div>
            <div class="feedback-box">
                <div class="textarea mb-3">
                    <textarea class="form-control" rows="3" placeholder="Write your feedback here..." name="sfeedback"></textarea>
                </div>
                <div class="rate_btn text-center">
                    <button class="btn btn-success px-3" type="submit" name="rate_series">Rate</button>
                </div>
            </div>
        </form>
        <?php
            require 'dbconfig.php';
            include_once 'controller.php';

            if(isset($_REQUEST['rate_series'])){
                if(!isset($_REQUEST['series_rating']) || $_REQUEST['sfeedback'] == ""){
                    echo "<script>alert('U need to rate and give feedback');</script>";
                }else{
                    $rating = $_REQUEST['series_rating'];
                    $fb = $_REQUEST['sfeedback'];
                    $sID = $seriesID;
                    $check_rate = "SELECT * FROM series_rating WHERE series_id = '$sID' AND user_id = '$uID'";
                    $cr_rtn = mysqli_query($dbconn,$check_rate);
                    if($cr_rtn->num_rows == 0){
                        $get_lastid = "SELECT * FROM series_rating ORDER BY rate_id DESC LIMIT 1";
                        $glid_rtn = mysqli_query($dbconn, $get_lastid);
                        if($glid_rtn->num_rows == 0)
                            $rID = "SR000001";
                        else{
                            $rDetail = mysqli_fetch_assoc($glid_rtn);
                            $rID = ++$rDetail['rate_id'];
                        }
                        $add_rating = "INSERT INTO series_rating VALUES ('$rID','$uID','$sID','$rating','$fb')";
                        $ar_rtn = mysqli_query($dbconn, $add_rating);
                        if($ar_rtn)
                            echo "<script>alert('Rating the series success.');
                                          location.assign('series.php?sid=$sID');</script>";
                        else
                            echo mysqli_error($dbconn);
                    }else
                        echo "<script>alert('you have already give rating and feedback for this.');</script>";
                }
                
            }
        ?>
    </div>
</body>
</html>