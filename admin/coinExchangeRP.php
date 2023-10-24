<?php
    $dataPoints1 = array(
        array("label"=> "Jan", "y"=> 36.12),
        array("label"=> "Feb", "y"=> 34.87),
        array("label"=> "Mar", "y"=> 40.30),
        array("label"=> "Apr", "y"=> 35.30),
        array("label"=> "May", "y"=> 39.50),
        array("label"=> "Jun", "y"=> 50.82),
        array("label"=> "Jul", "y"=> 74.70),
        array("label"=> "Aug", "y"=> 87.70),
        array("label"=> "Sep", "y"=> 58.70),
        array("label"=> "Oct", "y"=> 98.70),
        array("label"=> "Nov", "y"=> 83.70),
        array("label"=> "Dec", "y"=> 90.70)
    );
    $dataPoints2 = array(
        array("label"=> "Jan", "y"=> 64.61),
        array("label"=> "Feb", "y"=> 70.55),
        array("label"=> "Mar", "y"=> 72.50),
        array("label"=> "Apr", "y"=> 81.30),
        array("label"=> "May", "y"=> 63.60),
        array("label"=> "Jun", "y"=> 69.38),
        array("label"=> "Jul", "y"=> 98.70),
        array("label"=> "Aug", "y"=> 67.70),
        array("label"=> "Sep", "y"=> 86.70),
        array("label"=> "Oct", "y"=> 79.70),
        array("label"=> "Nov", "y"=> 78.70),
        array("label"=> "Dec", "y"=> 48.70)
    );
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
            theme: "light2",
            title:{
                text: "Monthly rate of coin sale and withdraw"
            },
            axisY:{
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
                yValueFormatString: "$#0.##",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
            },{
                type: "column",
                name: "Coin Withdraw",
                indexLabel: "{y}",
                yValueFormatString: "$#0.##",
                showInLegend: true,
                dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
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
						<div class="col-12 bg-light rounded p-5">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
						</div>
					</div>
                    <div class="row px-4">
                        <div class="col-6 ps-0">
                            <div class="bg-light rounded px-5 py-3">
                                <h5 class="text-center">Total coin sold</h5>
                                <p>This Year - 13500</p>
                                <p>This Month - 7650</p>
                                <p>This Day - 900</p>
                            </div>
                        </div>
                        <div class="col-6 pe-0">
                            <div class="bg-light rounded px-5 py-3">
                                <h5 class="text-center">Total coin withdraw</h5>
                                <p>This Year - 11800</p>
                                <p>This Month - 5950</p>
                                <p>This Day - 130</p>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>