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
			$serv['used'] = $q['used'];
			$serv['max'] = $q['max'];
		break;
		case 'APPS':
			$appq['used'] = $q['used'];
			$appq['max'] = $q['max'];
		break;
	}
}

if( $mem['max'] == 0 )
	template::redirect('/panel/plans');

$services_left = 260-round($serv['used']*260/$serv['max']);

$services = api::send('self/service/list');

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"/panel/services/add\" style=\"width: 200px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
";

if( count($services) == 0 )
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['noservice']}</span><br /><br />
					<a class=\"button classic\" href=\"/doc/services\" style=\"width: 140px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>";";
	";
}

$j = 1;
foreach( $services as $s )
{
	$content .= "
			<div class=\"service ".($j==1?"first":"")."\" onclick=\"window.location.href='/panel/services/config?service={$s['name']}'; return false;\">
				<img style=\"float: left; margin: 10px 15px 0 0;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$s['vendor']}.png\" />
				<span class=\"name\" style=\"margin: 5px 0 0px 0; display: block;\">{$s['description']}</span><br />
				<span class=\"subname\">{$s['name']}</span>
			</div>
	";
	
	$j++;
	
	if( $j == 4 )
		$j = 1;
}

if( count($services) > 0 )
{
	$content .= "
					<div class=\"clear\"></div><br />
					<a class=\"button classic\" href=\"https://pma.anotherservice.com\" style=\"width: 140px; float: left;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['pma']}</span>
					</a>
					<a class=\"button classic\" href=\"https://ppa.anotherservice.com\" style=\"width: 180px; float: left; margin-left: 20px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['ppa']}</span>
					</a>
	";
}
	
$content .= "
		<div class=\"clear\"></div><br /><br />
		</div>		
	</div>
";


/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>