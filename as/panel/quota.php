<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$me = api::send('self/whoami', array('quota'=>true));
$me = $me[0];

foreach( $me['quotas'] as $q )
{
	switch( $q['name'] )
	{
		case 'MEMORY':
			$mem['used'] = $q['used'];
			$mem['max'] = $q['max'];
		break;
		case 'DISK':
			$disk['used'] = $q['used'];
			$disk['max'] = $q['max'];
		break;
		case 'SERVICES':
			$services['used'] = $q['used'];
			$services['max'] = $q['max'];
		break;
		case 'APPS':
			$apps['used'] = $q['used'];
			$apps['max'] = $q['max'];
		break;
	}
}

$percent_memory = $mem['used']*100/$mem['max'];
$percent_disk = $disk['used']*100/$disk['max'];
$percent_services = $services['used']*100/$services['max'];
$percent_apps = $apps['used']*100/$apps['max'];

$disk['max'] = round($disk['max']/1024, 2) . " {$lang['gb']}";
if( $disk['used'] >= 1024 )
	$disk['used'] = round($disk['used']/1024, 2) . " {$lang['gb']}";
else
	$disk['used'] = "{$disk['used']} {$lang['gb']}";
$mem['max'] = round($mem['max']/1024, 2) . " {$lang['gb']}";
if( $mem['used'] >= 1024 )
	$mem['used'] = round($mem['used']/1024, 2) . " {$lang['gb']}";
else
	$mem['used'] = "{$mem['used']} {$lang['gb']}";
	
$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div class=\"right\">
					<a class=\"button classic\" href=\"/panel/plans\" style=\"width: 200px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['more']}</span>
					</a>		
				</div>
			</div>
			<div class=\"clear\"></div><br /><br />
			<div class=\"container\">
				<div style=\"float: left; width: 500px;\">
					<span style=\"block; float: left; padding-top: 7px; font-size: 18px; color: #878787;\">{$lang['memory']}</span>
					<div style=\"float: right;\">
						<div class=\"fillgraph\" style=\"margin-top: 10px;\">
							<small style=\"width: {$percent_memory}%;\"></small>
						</div>
						<span class=\"quota\"><span style='font-weight: bold;'>{$mem['used']}</span> {$lang['of']} {$mem['max']}.</span>
					</div>
					<div class=\"clear\"></div><br />
					<span style=\"block; float: left; padding-top: 7px; font-size: 18px; color: #878787;\">{$lang['disk']}</span>
					<div style=\"float: right;\">
						<div class=\"fillgraph\" style=\"margin-top: 10px;\">
							<small style=\"width: {$percent_disk}%;\"></small>
						</div>
						<span class=\"quota\"><span style='font-weight: bold;'>{$disk['used']}</span> {$lang['of']} {$disk['max']}.</span>
					</div>
				</div>
				<div style=\"float: right; width: 500px;\">
					<span style=\"block; float: left; padding-top: 7px; font-size: 18px; color: #878787;\">{$lang['services']}</span>
					<div style=\"float: right;\">
						<div class=\"fillgraph\" style=\"margin-top: 10px;\">
							<small style=\"width: {$percent_services}%;\"></small>
						</div>
						<span class=\"quota\"><span style='font-weight: bold;'>{$services['used']}</span> {$lang['of']} {$services['max']}.</span>
					</div>
					<div class=\"clear\"></div><br />
					<span style=\"block; float: left; padding-top: 7px; font-size: 18px; color: #878787;\">{$lang['apps']}</span>
					<div style=\"float: right;\">
						<div class=\"fillgraph\" style=\"margin-top: 10px;\">
							<small style=\"width: {$percent_apps}%;\"></small>
						</div>
						<span class=\"quota\"><span style='font-weight: bold;'>{$apps['used']}</span> {$lang['of']} {$apps['max']}.</span>
					</div>
				</div>
			</div>
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
