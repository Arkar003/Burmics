<?php
     
     $dataPoints = array(
    	array("x" => 946665000000, "y" => 3289000),
    	array("x" => 978287400000, "y" => 3830000),
    	array("x" => 1009823400000, "y" => 2009000),
    	array("x" => 1041359400000, "y" => 2840000),
    	array("x" => 1072895400000, "y" => 2396000),
    	array("x" => 1104517800000, "y" => 1613000),
    	array("x" => 1136053800000, "y" => 1821000),
    	array("x" => 1167589800000, "y" => 2000000),
    	array("x" => 1199125800000, "y" => 1397000),
    	array("x" => 1230748200000, "y" => 2506000),
    	array("x" => 1262284200000, "y" => 6704000),
    	array("x" => 1293820200000, "y" => 5704000),
    	array("x" => 1325356200000, "y" => 4009000),
    	array("x" => 1356978600000, "y" => 3026000),
    	array("x" => 1388514600000, "y" => 2394000),
    	array("x" => 1420050600000, "y" => 1872000),
    	array("x" => 1451586600000, "y" => 2140000)
     );
     
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <script>
    window.onload = function () {
     
    var chart = new CanvasJS.Chart("chartContainer", {
    	animationEnabled: true,
    	title:{
    		text: "Company Revenue by Month"
    	},
    	axisY: {
    		title: "Revenue in USD",
    		valueFormatString: "#0,,.",
    		suffix: "mn",
    		prefix: "$"
    	},
    	data: [{
    		type: "spline",
    		markerSize: 5,
    		xValueFormatString: "MMMM",
    		yValueFormatString: "$#,##0.##",
    		xValueType: "dateTime",
    		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    	}]
    });
     
    chart.render();
     
    }
    </script>
    </head>
    <body>
    
    </body>
    </html>
    
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
</head>
<body>
	<div class="container-fluid">
		<div class="row min-vh-100">
			<div class="col-2 bg-light pe-0">
				<?php include 'sidebar.php'; ?>
			</div>
			<div class="col-10 bg-secondary-subtle ps-0">
				<div class="container">
					<div class="row p-3">
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-coins fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>Total Coin sold</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-coins fs-1"></i></div>
									<div class="col-9 px-0 text-end">
										<h5>Coin Withdraw</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-cart-shopping fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>Package Purc</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="container bg-light rounded pb-2">
								<div class="row p-3 pb-1 align-items-center">
									<div class="col-3"><i class="fa-solid fa-user-plus fs-1"></i></div>
									<div class="col-9 pe-0 text-end">
										<h5>New users</h5>
										<h4>1000</h4>
									</div>
									<div class="col-12 border-bottom border-2"></div>
								</div>
								<div class="row px-3">
									<div class="col-12 ps-0 text-secondary">Yesterday - 1200 coins</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row px-4">
						<div class="col-12 bg-light rounded">
							<h1>Income chart</h1>
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>


$dataPoints = array(
 	array("x" => 1451586600000 , "y" => array(30.840000, 27.480000)),
	array("x" => 1454265000000 , "y" => array(29.610001, 27.100000)),
	array("x" => 1456770600000 , "y" => array(32.049999, 29.309999)),
	array("x" => 1459449000000 , "y" => array(32.020000, 30.309999)),
	array("x" => 1462041000000 , "y" => array(30.990000, 29.059999)),
	array("x" => 1464719400000 , "y" => array(31.500000, 29.170000)),
	array("x" => 1467311400000 , "y" => array(33.000000, 31.080000)),
	array("x" => 1469989800000 , "y" => array(31.570000, 31.000000)),
	array("x" => 1472668200000 , "y" => array(31.450001, 29.400000)),
	array("x" => 1475260200000 , "y" => array(29.750000, 28.330000)),
	array("x" => 1477938600000 , "y" => array(31.490000, 28.190001)),
	array("x" => 1480530600000 , "y" => array(32.380001, 30.620001))
 );