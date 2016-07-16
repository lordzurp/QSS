<!DOCTYPE html>
<html lang="en">
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
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		
		<script type="text/javascript">
			function refresh()
			{
				document.getElementById('reload').style.visibility='visible';
				$( "#status" ).load( "check.php" , function() { document.getElementById('reload').style.visibility='hidden'; $('[data-toggle="tooltip"]').tooltip(); });
			}
			function refresh_one()
			{
				document.getElementById('reload_one').style.visibility='visible';
				$( "#status_one" ).load( "check.php #GitHub" , function() { document.getElementById('reload_one').style.visibility='hidden'; $('[data-toggle="tooltip"]').tooltip(); });
			}
		</script>
	</head>
	
	<body>
		
	<!-- bandeau GitHub -->
	<a href="https://github.com/lordzurp/QSS" target="_blank">
		<img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png">
	</a>

	<div class="container">
	
		<div class="jumbotron">
			<h1>Quick Server Supervision</h1>
			<p>Petit script de surveillance de services web</p>
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