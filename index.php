<?php

/* 
QSS - Quick Server Supervision
v1.0 - 09/2015

The MIT License (MIT)

Copyright (c) 2015 lordzurp
http://www.zurp.me

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

// Turn off all error reporting
error_reporting(0);

require_once('./xajax_core/xajax.inc.php');

$xajax = new xajax(); // On initialise l'objet xajax.
$xajax->register(XAJAX_FUNCTION, 'test_status');
$xajax->processRequest(); // Fonction qui va se charger de générer le Javascript, à partir des données que l'on a fournies à xAjax.

function test_status() {

$reponse = new xajaxResponse();

	$json_file = file_get_contents('ressources/config.json');
	$config = json_decode($json_file);
	
	foreach ($config->Services as $service) {
		$services_dispo[$service->name] = $service->port ;
	}
	
	$display = '';
	foreach ($config->Servers as $server) {
		$display .= '
			<div class="status">
				<h4><span class="label label-info" data-toggle="tooltip" data-placement="top" title="IP : ' . $server->IP . ' - Timeout : ' . $server->TimeOut . '">' . $server->Name . '</span></h4>';
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
		$result = '<span class="label label-danger" >'.$name.' <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></i></span>';
	elseif ($status > $limit)
		$result = '<span class="label label-warning" data-toggle="tooltip" data-placement="top" title="ping : ' . $status . 'ms">'.$name.' <span class="glyphicon glyphicon-alert" aria-hidden="true"></span></span>';
	else
		$result = '<span class="label label-success" data-toggle="tooltip" data-placement="top" title="ping : ' . $status . 'ms">'.$name.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
	$return = '<span class="label label-info" >'.$name.'  </span>';
	return $result;
}

?>
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
		<link rel="stylesheet" href="https://code.jquery.com/jquery-2.1.4.min.js">
		
		<?php $xajax->printJavascript(); ?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
			});
			// http://cust.er.free.fr/script/date_heure/
			function time() {
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
				setTimeout(refresh, 30000);
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
				setInterval('time()',1000);
			</script>
			<div id="reload" ><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
			<div id="status" ></div>
		</div>
		<div class="navigation"></div>
		
		<script type="text/javascript">
			refresh();
		</script>
		<a href="https://github.com/lordzurp/QSS" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>
		<footer class="footer">
			<div class="container">
				Propulsé par QSS © lordzurp 2015
			</div>
		</footer>
	</body>
</html>