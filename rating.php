<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series Ratings</title>
    <link rel="stylesheet" type="text/css" href="bs5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- <script type="text/javascript" src="bs5.3/js/bootstrap.bundle.min.js"></script> -->
</head>
<body>
    <div class="rate-container bg-secondary-subtle py-3 rounded">
        <form method="post">
            <div class="star-widget">
                <input type="radio" name="ratings" id="star5" value="5">
                <label for="star5" class="fas fa-star fs-1 mb-3"></label>
                <input type="radio" name="ratings" id="star4" value="4">
                <label for="star4" class="fas fa-star fs-1 mb-3"></label>
                <input type="radio" name="ratings" id="star3" value="3">
                <label for="star3" class="fas fa-star fs-1 mb-3"></label>
                <input type="radio" name="ratings" id="star2" value="2">
                <label for="star2" class="fas fa-star fs-1 mb-3"></label>
                <input type="radio" name="ratings" id="star1" value="1">
                <label for="star1" class="fas fa-star fs-1 mb-3"></label>
            </div>
            <div class="">
                <div class="textarea mb-5">
                    <textarea class="form-control" rows="4" placeholder="Comment here..." name="review"></textarea>
                </div>
                <div class="rate_btn text-center">
                    <button class="btn btn-success px-3" type="submit" name="rate">Rate</button>
                </div>
            </div>
        </form>
        <?php
            require 'dbconfig.php';
            include_once 'controller.php';

            if(isset($_REQUEST['rate'])){
                if(!isset($_REQUEST['ratings']) || $_REQUEST['review'] == ""){
                    echo "<script>alert('U need to rate and give feedback');</script>";
                }else{
                    $rating = $_REQUEST['ratings'];
                    $rv = $_REQUEST['review'];
                    $uID = $_SESSION['uid'];
                    $check_rate = "SELECT * FROM rating WHERE user_id = '$uID'";
                    $cr_rtn = mysqli_query($dbconn,$check_rate);
                    if($cr_rtn->num_rows == 0){
                        $get_lastid = "SELECT * FROM rating ORDER BY rating_id DESC LIMIT 1";
                        $glid_rtn = mysqli_query($dbconn, $get_lastid);
                        if($glid_rtn->num_rows == 0)
                            $rID = "R0000001";
                        else{
                            $rDetail = mysqli_fetch_assoc($glid_rtn);
                            $rID = ++$rDetail['rating_id'];
                        }
                        $add_rating = "INSERT INTO rating VALUES ('$rID','$uID','$rating','$rv')";
                        $ar_rtn = mysqli_query($dbconn, $add_rating);
                        if($ar_rtn)
                            echo "<script>alert('Thank you for rating us.  Enjoy our BURMICS.');</script>";
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