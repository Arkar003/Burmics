<?php
	$year = date('Y');
	$month = date('m');

	$incomePoints = array();
	for($m = 0; $m < 12; $m++){
		$mon = $m + 1;
		$monName = date('F', strtotime("$year-$mon-01"));
		$incomePoints["$m"]["label"] = $monName;
		$incomePoints["$m"]["y"] = getTotalIncome($year,$mon);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        window.onload = function () {
		
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			title:{
				text: "Company Revenue by Month"
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
		
		}
    </script>
</head>
<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>