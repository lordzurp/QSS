<?php

/* 
QSS - Quick Server Supervision
v1.0 - 09/2015
v1.2 - 11-2017 - merge json config files

The MIT License (MIT)

Copyright (c) 2015 lordzurp
http://www.zurp.me/demo/

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
	
	$return = '<a href="http://' . $ip . ':' . $port . '" target="_blank" >
					<span class="label label-' . $result . '" data-toggle="tooltip" data-placement="bottom" title="' . $tooltip . '">
					'.$name.'
					<span class="glyphicon ' . $icon . '" aria-hidden="true"></span>
					</span>
				</a>&nbsp;';
	return $return;
}

$json_file = file_get_contents('ressources/config.json');
$config = json_decode($json_file);

foreach ($config->Services_list as $service) {
	$service_port[$service->name] = $service->port ;
}

$display = '
';

foreach ($config->Surveys_list as $survey) {
	$display .= '				
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">' . $survey->title . '</h3>
			</div>
			<div class="panel-body check">
	';
	
	foreach ($survey->list as $server) {
		$display .= '
			<div id="' . $server->name . '" class="status bs-callout bs-callout-primary">
				<h4>
					<a href="http://' . $server->address . '" target="_blank" ></a>
					&nbsp;
					<span data-toggle="tooltip" data-placement="right" title="' . $server->address . '" >' . $server->name . '</span>
				</h4>';
		foreach ($server->services as $service) {
			$display .= '
				' . pingDomain($service,$server->address,$service_port[$service], $server->timeout);
		}
		$display .= '
			</div>
	';
	}

	$display .= '
		</div>
	</div>
	';
}

echo $display;
?>