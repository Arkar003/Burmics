<?php
     $dataPoints = array(
        array("x" => 1451586600000, "y" => 3289000),
        array("x" => 1454265000000, "y" => 3830000),
        array("x" => 1456770600000, "y" => 2009000),
        array("x" => 1459449000000, "y" => 2840000),
        array("x" => 1462041000000, "y" => 2396000),
        array("x" => 1464719400000, "y" => 1613000),
        array("x" => 1467311400000, "y" => 1821000),
        array("x" => 1469989800000, "y" => 2000000),
        array("x" => 1472668200000, "y" => 1397000),
        array("x" => 1475260200000, "y" => 2506000),
        array("x" => 1477938600000, "y" => 6704000),
        array("x" => 1480530600000, "y" => 5704000)
     );
    
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
				title: "Revenue in USD",
				valueFormatString: "#0,,.",
				suffix: "mn",
				prefix: "$"
			},
			data: [{
				type: "spline",
				// markerSize: 5,
				xValueFormatString: "MMMM",
				yValueFormatString: "$#,##0.##",
				xValueType: "dateTime",
				dataPoints: <?php echo json_encode($dataPoints); ?>
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