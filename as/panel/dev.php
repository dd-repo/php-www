<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$repos = api::send('self/repo/list');

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
			$appq['used'] = $q['used'];
			$appq['max'] = $q['max'];
		break;
	}
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"/panel/repo/add\" style=\"width: 200px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">";

if( count($repos) == 0 )
	$content .= "<p>{$lang['no_repo']}</pa>";

$j = 1;
foreach( $repos as $r )
{
	$content .= "
			<div class=\"service ".($j==1?"first":"")."\" onclick=\"window.location.href='/panel/repo/config?id={$r['id']}'; return false;\">
				<img style=\"float: left; margin: 10px 15px 0 0;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-{$r['type']}.png\" />
				<span class=\"name\" style=\"margin: 5px 0 0px 0; display: block;\">{$r['description']}</span><br />
				<span class=\"subname\">{$r['name']}</span>
			</div>
	";
	
	$j++;
	
	if( $j == 4 )
		$j = 1;
}

	$content .= "
		</div>		
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
