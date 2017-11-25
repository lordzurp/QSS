<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" >
		<meta name="description" content="QSS, a small script for webservices supervision.">
		<meta name="keywords" content="webservices supervision monitoring">
		<meta name="author" content="lordzurp">
		
		<title>Is it alive ?</title>
		
		<!-- Favicons -->
		<link rel="icon" type="image/png" sizes="32x32" href="ressources/favicon.32.png" />
		<link rel="icon" type="image/png" sizes="128x128" href="ressources/favicon.128.png" />
		
		<!-- Main stylesheet -->
		<link rel="stylesheet" href="ressources/style.css" />
		
		<!-- jQuery -->
		<script src="dist/js/jquery-2.2.4.min.js"></script>
		
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" id="theme_stylesheet" href="dist/css/bootstrap.min.css">
		<script src="dist/js/bootstrap.min.js"></script>
			
		<script type="text/javascript">
			function refresh()
			{
				document.getElementById('reload').style.visibility='visible';
				$( "#status" ).load( "check.php" , function() { 
					document.getElementById('reload').style.visibility='hidden';
					$('[data-toggle="tooltip"]').tooltip(); 
				});
			}
		</script>
	</head>
	
	<body>
	<div class="container">
	
		<div class="jumbotron">
			<h1>Quick Server Supervision</h1>
			<p>Script de surveillance de services web</p>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Full report</h3>
			</div>
			<div class="panel-body check">
					<div id="reload"><h4><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></h4></div>
					<div id="status" ></div>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">1 bloc</h3>
			</div>
			<div class="panel-body check">
					<div id="reload_one"><h4><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></h4></div>
					<div id="status_one" ></div>
			</div>
		</div>
		
		<script type="text/javascript">
			refresh();
			setInterval(function () {refresh()}, 10000);
			refresh_one();
			setInterval(function () {refresh_one()}, 10000);
		</script>
	</div>
	</body>
</html>