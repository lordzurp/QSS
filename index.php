<?php

// lordzurp
// 09-2015
// v1.0

// Turn off all error reporting
error_reporting(0);

require_once('./xajax_core/xajax.inc.php');

$xajax = new xajax(); // On initialise l'objet xajax.
$xajax->register(XAJAX_FUNCTION, 'test_status');
$xajax->processRequest(); // Fonction qui va se charger de générer le Javascript, à partir des données que l'on a fournies à xAjax.

function test_status() {

$reponse = new xajaxResponse();

	$json_file = file_get_contents('config.json');
	$config = json_decode($json_file);
	
	foreach ($config->Services as $service) {
		$services_dispo[$service->name] = $service->port ;
	}
	
	$display = '';
	foreach ($config->Servers as $server) {
		$display .= '
			<div class="status">
				<h4><span class="label label-info" >' . $server->Name . '</span></h4>';
		foreach ($server->Services as $service) {
			$display .= '
					' . pingDomain($service,$server->IP,$services_dispo[$service], $server->TimeOut);
		}
		$display .= '
			</div>
	';
	}
	$reponse->assign('status', 'innerHTML', $display);
	$reponse->script("hide();");// ON CACHE LE MESSAGE DE CHARGEMENT.
//		return $display;
	
	return $reponse;
}

function pingDomain($name,$ip,$port,$limit=10) {
// http://tournasdimitrios1.wordpress.com/2010/10/15/check-your-server-status-a-basic-ping-with-php/
	$starttime	= microtime(true);
	$file		= fsockopen ($ip, $port, $errno, $errstr, 10);
	$stoptime	= microtime(true);
	$status		= 0;
	
	if (!$file) $status = -1;  // Site is down
	else {
		fclose($file);
		$status = ($stoptime - $starttime) * 1000;
		$status = floor($status);
	}
	if ($status == '-1')
		$result = '<span class="label label-danger" >'.$name.' <i class="fa fa-times-circle"></i></span>';
	elseif ($status > $limit)
		$result = '<span class="label label-warning" data-toggle="tooltip" data-placement="top" title="ping : ' . $status . 'ms">'.$name.' <i class="fa fa-exclamation-triangle"></i></span>';
	else
		$result = '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="ping : ' . $status . 'ms">'.$name.' <i class="fa fa-check-circle"></i></span>';
	$return = '<span class="label label-info" >'.$name.'  </span>';
	return $result;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Zurp is alive</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="icon" type="image/png" sizes="32x32" href="ressources/favicon.32.png" />
		<link rel="icon" type="image/png" sizes="128x128" href="ressources/favicon.128.png" />
		<link rel="stylesheet" href="https://code.jquery.com/jquery-2.1.4.min.js">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
			<link rel="stylesheet" href="ressources/style.css" type="text/css" />
		
		<?php $xajax->printJavascript(); /* Fonction qui affiche le javascript de la page. */	?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
			});
			// Script créé par le webmaster de http://cust.er.free.fr
			function rafraichir() {
				var date = new Date();
				if ( date.getHours() <= 9 ) {var heure = '0'+date.getHours();} else {var heure = date.getHours();}
				if ( date.getMinutes() <= 9 ) {var minutes = '0'+date.getMinutes();} else {var minutes = date.getMinutes();}
				if ( date.getSeconds() <= 9 ) {var secondes = '0'+date.getSeconds();} else {var secondes = date.getSeconds();}
				text = '<h4>'+heure+':'+minutes+':'+secondes+'</h4>';
				document.getElementById('time').innerHTML = text;
			}
			function refresh()
			{
				show();
				xajax_test_status();
				setTimeout(refresh, 500000);
			}
			function show() { document.getElementById('reload').style.visibility='visible'; }
			function hide() { document.getElementById('reload').style.visibility='hidden'; }
		</script>
	
	</head>
	<body>
		<div class="navigation"></div>
		<div class="check">
			<script type="text/javascript">
				document.write('<div id="time" ></div>');
				setInterval('rafraichir()',1000);
			</script>
			<div id="reload" ><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
			<div id="status" ></div>
		</div>
		<div class="navigation"></div>
		<script type="text/javascript">
			refresh();
		</script>
	
	</body>
</html>