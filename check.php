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
	
	if ($status == '-1') {
		$result = 'danger';
		$icon = 'glyphicon-remove';
		$tooltip='offline';
	}
	elseif ($status > $limit) {
		$result = 'warning';
		$icon = 'glyphicon-alert';
		$tooltip='ping : ' . $status . 'ms';
	}
	else {
		$result = 'success';
		$icon = 'glyphicon-ok';
		$tooltip='ping : ' . $status . 'ms';
	}
	
	$return = '<span class="label label-' . $result . '" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '">'.$name.' <span class="glyphicon ' . $icon . '" aria-hidden="true"></span></span>';
	return $return;
}

$json_file = file_get_contents('ressources/config.json');
$config = json_decode($json_file);

foreach ($config->Services as $service) {
	$services_dispo[$service->name] = $service->port ;
}

$display = '';
foreach ($config->Servers as $server) {
	$display .= '
		<div class="status">
			<h4><span class="label label-info" data-toggle="tooltip" data-placement="top" title="' . $server->address . '">' . $server->name . '</span></h4>';
	foreach ($server->services as $service) {
		$display .= '
				' . pingDomain($service,$server->address,$services_dispo[$service], $server->timeout);
	}
	$display .= '
		</div>
';
}
echo $display;

?>