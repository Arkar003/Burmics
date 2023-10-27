<?php
	require '../dbconfig.php';
	include_once '../controller.php';
	date_default_timezone_set("Asia/Yangon");
	session_start();

	$year = date('Y');
	$month = date('m');

	$year = date('Y');
    if(isset($_REQUEST['showReport'])){
        $year = $_REQUEST['year'];
    }

	$incomePoints = array();
	for($m = 0; $m < 12; $m++){
		$mon = $m + 1;
		$monName = date('F', strtotime("$year-$mon-01"));
		$incomePoints["$m"]["label"] = $monName;
		$incomePoints["$m"]["y"] = getTotalIncome($year,$mon);
	}

	$barPoints = array();

	$barPoints[0]["label"] = "Coin Exchange Income";
	$barPoints[0]["y"] = getCEIncome($year, 0);
	$barPoints[1]["label"] = "Package sale Income";
	$barPoints[1]["y"] = getPackIncome($year, $month,'all');
	$barPoints[2]["label"] = "Donation";
	$barPoints[2]["y"] = getDonationIncome($year, $month);
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
        window.onload = function () {
		
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			title:{
				text: "Monthly Total income"
			},
			axisX: {
				valueFormatString: "MMM",
				intervalType: "month",
				interval: 1
			},
			axisY: {
				title: "Income in MMK",
				valueFormatString: "#,###,###"
			},
			data: [{
				type: "spline",
				markerSize: 0,
				yValueFormatString: "#,##0.##",
				dataPoints: <?php echo json_encode($incomePoints); ?>
			}]
		});
		
		chart.render();

		var barChart = new CanvasJS.Chart("barChartBox", {
			animationEnabled: true,
			title:{
				text: "Total income of the year"
			},
			axisY: {
				title: "Income in MMK",
				includeZero: true,
			},
			data: [{
				type: "bar",
				yValueFormatString: "#,###,###",
				indexLabel: "{y} MMK",
				indexLabelPlacement: "inside",
				indexLabelFontWeight: "bolder",
				indexLabelFontColor: "white",
				dataPoints: <?php echo json_encode($barPoints, JSON_NUMERIC_CHECK); ?>
			}]
		});
		barChart.render();
		
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
					<div class="row px-3 mb-3">
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-coins fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>Total Coin sold</h5>
										<h4><?php echo getTotalCoins(date('Y'), date('m'), 'sold')?></h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-6 ps-0"><a class="text-secondary text-decoration-none" href="coinExchangeRP.php">View details</a></div>
									<div class="col-6 pe-0 text-end"><?php echo date('F') ?></div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-coins fs-1"></i></div>
									<div class="col-9 px-0 text-end">
										<h5>Coin Withdraw</h5>
										<h4><?php echo getTotalCoins(date('Y'), date('m'), 'wdw')?></h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-6 ps-0"><a class="text-secondary text-decoration-none" href="coinExchangeRP.php">View details</a></div>
									<div class="col-6 pe-0 text-end"><?php echo date('F') ?></div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-cart-shopping fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>Package Purc</h5>
										<h4><?php echo getPackPurcCounts(date('Y'), date('m'), 'all')?></h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-6 ps-0"><a class="text-secondary text-decoration-none" href="package.php">View details</a></div>
									<div class="col-6 pe-0 text-end"><?php echo date('F') ?></div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-user-plus fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>New users</h5>
										<h4><?php echo getUserCount(date('Y'), date('m'), 'all') ?></h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-6 ps-0"><a class="text-secondary text-decoration-none" href="newUserAccRP.php">View details</a></div>
									<div class="col-6 pe-0 text-end"><?php echo date('F') ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row px-4 mb-3">
						<div class="col-12 bg-light rounded p-2 px-3 mb-1">
                            <form method="post">
                                <div class="d-flex justify-content-end align-items-center">
                                    <div class="d-inline-block me-auto">
                                        <h4>Income Report (<?php echo $year;?>)</h4>
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
							<div id="chartContainer" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
					<div class="row px-4">
						<div class="col-12 bg-light rounded p-3">
							<div id="barChartBox" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>