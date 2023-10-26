<?php
    require '../dbconfig.php';
    include_once '../controller.php';
    date_default_timezone_set("Asia/Yangon");

    $year = date('Y');
    $month = date('m');

    if(isset($_REQUEST['showReport'])){
        $year = $_REQUEST['year'];
        $month = $_REQUEST['month'];
    }

    $readersM = getUserCount($year, $month, 'reader');
    $creatorsM = getUserCount($year, $month, 'creator');
    $totalUserM = getUserCount($year, $month, 'all');
    if($totalUserM != 0){
        $mReaderPer = ($readersM / $totalUserM) * 100;
        $mCreatePer = ($creatorsM / $totalUserM) * 100;
        $noUser = 0;
    }else{
        $mReaderPer = 0;
        $mCreatePer = 0;
        $noUser = 100;
    }
    $piePoints = array( 
        array("label"=>"Reader", "y"=>$mReaderPer),
        array("label"=>"Creator", "y"=>$mCreatePer),
        array("label"=>"no user", "y"=>$noUser)
    );
    $test = array();
    for($m = 0; $m < 12; $m++){
        $mon = $m + 1;
        $dumb = strtotime("$year-$mon-01");
        $monName = date('F', $dumb);
        $test["$m"]["y"] = getUserCount($year, $mon, 'all');
        $test["$m"]["label"] = $monName;
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<script type="text/javascript" src="../bs5.3/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script>
		window.onload = function() {
        var pieChart = new CanvasJS.Chart("pieChartBox", {
            animationEnabled: true,
            title: {
                text: "Creator/Reader Ratio"
            },
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($piePoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        pieChart.render();

        var lineChart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "User population over the year"
            },
            axisX: {
              labelAngle: -90,
              interval: 1
            },
            axisY: {
                title: "Number account created"
            },
            data: [{
                type: "line",
                dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
            }]
        });
        lineChart.render();
        }
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="row min-vh-100">
			<div class="col-2 bg-light pe-0">
				<?php include 'sidebar.php'; ?>
			</div>
			<div class="col-10 bg-secondary-subtle ps-0">
				<div class="container p-5">
					<div class="row px-4 mb-3">
                        <div class="col-12 p-1">
                            <form method="post">
                                <div class="d-flex justify-content-end align-items-center bg-light rounded-3 p-3">
                                    <div class="d-inline-block me-auto">
                                        <h4>User Population Report (<?php echo $year;?>, <?php echo ($month == 0) ? "All months" : date('F',strtotime("$year-$month-01"));?>)</h4>
                                    </div>
                                    <div class="d-inline-block w-10 mx-1">
                                        <select class="form-select" name="year" id="year">
                                            <?php
                                                $curYear = date('Y');
                                                $curMonth = date('m');
                                            ?>
                                            <option value="<?php echo $curYear; ?>">current year</option>
                                            <?php
                                                for($y = $curYear - 1; $y >= 2020; $y--){
                                            ?>
                                            <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="d-inline-block w-10 mx-1">
                                        <select class="form-select" name="month" id="month">
                                            <option value="<?php echo $curMonth; ?>">current month</option>
                                            <option value="0">all month</option>
                                            <?php
                                                for($x = 1; $x <= 12; $x++){
                                                    $demo = strtotime("$curYear-$x-01");
                                                    $monthName = date('F', $demo);
                                            ?>
                                            <option value="<?php echo $x; ?>"><?php echo $monthName; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-success mx-1" type="submit" name="showReport" id="showReport">Show</button>
                                </div>
                            </form>
                        </div>
						<div class="col-8 p-1">
                            <div class="bg-light rounded-3 overflow-hidden p-3">
                                <div class="mb-3" id="chartContainer" style="height: 450px; width: 100%;"></div>
                                <div class="d-flex justify-content-center p-3">
                                    <div class="d-inline-block"><h3>Total - <?php echo getUserCount($year,0,'all'); ?></h3></div>
                                    <div class="d-inline-block mx-5"><h3>Readers - <?php echo getUserCount($year,0,'reader'); ?></h3></div>
                                    <div class="d-inline-block"><h3>Creators - <?php echo getUserCount($year,0,'creator'); ?></h3></div>
                                </div>
                            </div>
						</div>
                        <div class="col-4 p-1">
                            <div class="bg-light rounded-3 overflow-hidden p-3">
                                <div id="pieChartBox" style="height: 375px; width: 100%;"></div>
                                <div class="bg-white p-3 text-center"><h4><?php echo ($month == 0) ? "All months" : date('F',strtotime("$year-$month-01")); ?></h4></div>
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div class="d-inline-block"><h3>Total - <?php echo getUserCount($year,$month,'all'); ?></h3></div>
                                    <div class="d-inline-block"><h5>Readers - <?php echo getUserCount($year,$month,'reader'); ?></h5><h5>Creators - <?php echo getUserCount($year,$month,'creator'); ?></h5></div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>