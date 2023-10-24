<?php
    $dataPoints = array( 
        array("label"=>"Reader", "y"=>65),
        array("label"=>"Creator", "y"=>35)
    )
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
 
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Monthly new account created report"
            },
            subtitles: [{
                text: "October 2023"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
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
						<div class="col-12 bg-light rounded p-5">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
						</div>
					</div>
                    <div class="row px-4">
                        <div class="col-4 ps-0">
                            <div class="bg-light rounded p-3">
                                <h4 class="text-center">This year</h4>
                                <p>Total user - 15400</p>
                                <p>reader - 11200</p>
                                <p>creator - 4200</p>
                            </div>
                        </div>
                        <div class="col-4">
                        <div class="bg-light rounded p-3">
                                <h4 class="text-center">This month</h4>
                                <p>Total user - 9800</p>
                                <p>reader - 6750</p>
                                <p>creator - 2050</p>
                            </div>
                        </div>
                        <div class="col-4 pe-0">
                        <div class="bg-light rounded p-3">
                                <h4 class="text-center">Today</h4>
                                <p>Total user - 30</p>
                                <p>reader - 27</p>
                                <p>creator - 3</p>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>