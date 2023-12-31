<?php
    require '../dbconfig.php';
    include_once '../controller.php';
    date_default_timezone_set("Asia/Yangon");
    session_start();

    $year = date('Y');

    if(isset($_REQUEST['showReport'])){
        $year = $_REQUEST['year'];
    }

    $coinSalePoints = array();
    $coinWdwPoints = array();
    for($m = 0; $m < 12; $m++){
        $mon = $m + 1;
        $mName = date('F', strtotime("$year-$mon-01"));
        $coinSalePoints["$m"]['label'] = $mName;
        $coinSalePoints["$m"]['y'] = getTotalCoins($year,$mon,"sold");
        $coinWdwPoints["$m"]['label'] = $mName;
        $coinWdwPoints["$m"]['y'] = getTotalCoins($year,$mon,"wdw");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>REPORTS - coin sale/withdraw</title>
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
                text: "Monthly report of coin sale/withdraw"
            },
            axisX:{
                valueFormatString: "MMM",
                interval: 1,
                labelAngle: -45
            },
            axisY:{
                title: "Number of Coins",
                includeZero: true
            },
            legend:{
                cursor: "pointer",
                verticalAlign: "center",
                horizontalAlign: "right",
                itemclick: toggleDataSeries
            },
            data: [{
                type: "column",
                name: "Coin Sale",
                indexLabel: "{y}",
                showInLegend: true,
                dataPoints: <?php echo json_encode($coinSalePoints, JSON_NUMERIC_CHECK); ?>
            },{
                type: "column",
                name: "Coin Withdraw",
                indexLabel: "{y}",
                showInLegend: true,
                dataPoints: <?php echo json_encode($coinWdwPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }
        
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
                                        <h4>Coin Sale/Withdraw Report (<?php echo $year;?>)</h4>
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
                                <div class="d-inline-block"><h3>Total coin sold - <?php echo getTotalCoins($year,0,"sold"); ?></h3></div>
                                <div class="d-inline-block"><h3>Total coin withdraw - <?php echo getTotalCoins($year,0,"wdw");?></h3></div>
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