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
			$appq['used'] = $q['used'];
			$appq['max'] = $q['max'];
		break;
	}
}

if( security::hasGrant('SELF_APP_SELECT') )
	$apps = api::send('self/app/list');

$mem_left = 260-round($mem['used']*260/$mem['max']);
$disk_left = 260-round($disk['used']*260/$disk['max']);
$services_left = 260-round($services['used']*260/$services['max']);
$apps_left = 260-round($appq['used']*260/$appq['max']);

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"float: left; width: 550px;\">
				<h3>{$lang['memory']}</h3>
				<div class=\"ui-meter-holder\">
					<div class=\"ui-meter\">
						<div class=\"after-fill fill\" style=\"z-index: 9; display: none;\"></div>
						<div class=\"before-fill fill\" style=\"z-index: 10; right: {$mem_left}px;\"></div>
						<div class=\"base-fill fill\" style=\"z-index: 20; display: none;\"></div>
					</div>
				</div>
				<div class=\"details\">
					<span class=\"usage\">{$mem['used']}Mo</span> / <span class=\"limit\">{$mem['max']}Mo</span>
				</div>
				<br /><br />
				<a class=\"btn\" href=\"/panel/plans\">{$lang['more']}</a>
				<div class=\"clearfix\"></div>
			</div>
			<div style=\"float: left; width: 475px;\">
				<h3>{$lang['disk']}</h3>
				<div class=\"ui-meter-holder\">
					<div class=\"ui-meter\">
						<div class=\"after-fill fill\" style=\"z-index: 9; display: none;\"></div>
						<div class=\"before-fill fill\" style=\"z-index: 10; right: {$disk_left}px;\"></div>
						<div class=\"base-fill fill\" style=\"z-index: 20; display: none;\"></div>
					</div>
				</div>
				<div class=\"details\">
					<span class=\"usage\">{$disk['used']}Mo</span> / <span class=\"limit\">{$disk['max']}Mo</span>
				</div>
				<br /><br />
				<a class=\"btn\" href=\"/panel/storage\">{$lang['more_disk']}</a>				
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<h2>{$lang['apps']}</h2>
			<table>
				<tr>
					<th>{$lang['name']}</th>
					<th>{$lang['uid']}</th>
					<th>{$lang['uris']}</th>
					<th>{$lang['memory']}</th>
					<th>{$lang['size']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";
if( count($apps) > 0 )
{
	foreach( $apps as $a )
	{
		$language = explode('-', $a['name']);
		$language = $language[0];

		$running = false;
		$memory = 0;
		$disk = 0;
		$count = 0;
		if( $a['branches'] )
		{
			foreach( $a['branches'] as $key => $value )
			{
				foreach( $value['instances'] as $i )
				{
					if( $i['state'] == 'RUNNING' )
						$running = true;
					$memory = $memory+$i['memory']['quota'];
					$disk = $disk+$i['disk']['quota'];
					
					$count++;
				}
			}
		}
		$memory = $memory;
		$instances = $count;

		$content .= "
					<tr>
						<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" alt=\"\" /><a href=\"/panel/app/show?id={$a['id']}\"><strong>{$a['tag']}</strong></a></td>
						<td>{$a['name']}</td>
						<td>";
		if( $a['branches'] )
		{
			foreach( $a['branches'] as $key => $value )
			{
				if(  $value['urls'] )
				{
					foreach( $value['urls'] as $u )
						$content .= "				<a href=\"http://{$u}\">{$u}</a><br />";
				}
			}
		}
		
		$content .= "
						</td>
						<td><span class=\"lightlarge\">{$memory}Mo</span><br /><span style=\"font-size: 12px;\">{$instances} {$lang['instances']}</span></td>
						<td><span class=\"large\">{$a['size']}Mo</span></td>
						<td align=\"center\">
							<a href=\"/panel/app/show?id={$a['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a href=\"/panel/app/del_action?id={$a['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
		";
	}
}

$content .= "
				</tr>
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/app/add\">{$lang['add']}</a>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>