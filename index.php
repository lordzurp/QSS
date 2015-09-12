<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" >
		<meta name="description" content="QSS, a small script for webservices supervision.">
		<meta name="keywords" content="webservices supervision monitoring">
		<meta name="author" content="lordzurp">
		
		<title>Zurp is alive</title>
		
		<!-- Favicons -->
		<link rel="icon" type="image/png" sizes="32x32" href="ressources/favicon.32.png" />
		<link rel="icon" type="image/png" sizes="128x128" href="ressources/favicon.128.png" />
		
		<!-- Main stylesheet -->
		<link rel="stylesheet" href="ressources/style.css" />
		
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
			});
			// http://cust.er.free.fr/script/date_heure/
			function time() {
				var date = new Date();
				if ( date.getHours() <= 9 ) {var heure = '0'+date.getHours();} else {var heure = date.getHours();}
				if ( date.getMinutes() <= 9 ) {var minutes = '0'+date.getMinutes();} else {var minutes = date.getMinutes();}
				text = '<h4>'+heure+':'+minutes+'</h4>';
				document.getElementById('time').innerHTML = text;
			}
			function refresh()
			{
				time();
				show();
				$( "#status" ).load( "check.php" , hide() );
				setTimeout(refresh, 30000);
			}
			function show() { document.getElementById('reload').style.visibility='visible'; }
			function hide() { document.getElementById('reload').style.visibility='hidden'; }
		</script>
	</head>
	
	<body>
		<div class="navigation"></div>
		<div class="check">
			<div id="time" ></div>
			<div id="reload" ><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
			<div id="status" ></div>
		</div>
		<div class="navigation"></div>

		<script type="text/javascript">
			refresh();
		</script>
		
		<footer class="footer">
			<div class="container">
				Propulsé par QSS © lordzurp 2015
			</div>
		</footer>
		
	</body>
</html>