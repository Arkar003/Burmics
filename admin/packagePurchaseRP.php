<?php
    require '../dbconfig.php';
    include_once '../controller.php';
    date_default_timezone_set("Asia/Yangon");
    session_start();

    $year = date('Y');
    if(isset($_REQUEST['showReport'])){
        $year = $_REQUEST['year'];
    }

    $pack1Points = array();
    $pack2Points = array();
    $pack3Points = array();
    for($m = 0; $m < 12; $m++){
        $mon = $m + 1;
        $monName = date('F',strtotime("$year-$mon-01"));
        $pack1Points["$m"]["label"] = $monName;
        $pack1Points["$m"]["y"] = getPackPurcCounts($year,$mon,"PAC00001");
        $pack2Points["$m"]["label"] = $monName;
        $pack2Points["$m"]["y"] = getPackPurcCounts($year,$mon,"PAC00002");
        $pack3Points["$m"]["label"] = $monName;
        $pack3Points["$m"]["y"] = getPackPurcCounts($year,$mon,"PAC00003");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>REPORTS - Package Purchase</title>
	<link rel="stylesheet" type="text/css" href="../bs5.3/css/bootstrap.min.css">
	<script type="text/javascript" src="../bs5.3/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../bs5.3/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script>
		window.onload = function () {
 
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Package Purchase Report"
                },
                axisY:{
                    title: "Number of purchasement",
                    titleFontColor: "#6D78AD",
                    gridColor: "#6D78AD",
                    includeZero: true
                },
                legend: {
                    cursor: "pointer",
                    fontSize: 16
                },
                data: [{
                    type: "line",
                    markerSize: 0,
                    showInLegend: true,
                    name: "1 Day Pack",
                    dataPoints: <?php echo json_encode($pack1Points, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "line",
                    markerSize: 0,
                    showInLegend: true,
                    name: "3 Days Pack",
                    dataPoints: <?php echo json_encode($pack2Points, JSON_NUMERIC_CHECK); ?>
                },
                {
                    type: "line",
                    markerSize: 0,
                    showInLegend: true,
                    name: "7 Days Pack",
                    dataPoints: <?php echo json_encode($pack3Points, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
            
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
                        <div class="col-12 bg-light rounded p-3 mb-3">
                            <form method="post">
                                <div class="d-flex justify-content-end align-items-center">
                                    <div class="d-inline-block me-auto">
                                        <h4>Package Purchase Report (<?php echo $year;?>)</h4>
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
                                    <button class="btn btn-success mx-1" type="submit" name="showReport" id="showReport">Show</button>
                                </div>
                            </form>
                        </div>
						<div class="col-12 bg-light rounded p-3">
                            <div class="mb-3" id="chartContainer" style="height: 450px; width: 100%;"></div>
                            <div class="d-flex justify-content-around">
                                <div class="d-inline-block"><h3>Total 1 Day Pack - <?php echo getPackPurcCounts($year,0,"PAC00001"); ?></h3></div>
                                <div class="d-inline-block"><h3>Total 3 Days Pack - <?php echo getPackPurcCounts($year,0,"PAC00002");?></h3></div>
                                <div class="d-inline-block"><h3>Total 7 Days Pack - <?php echo getPackPurcCounts($year,0,"PAC00003");?></h3></div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</html>