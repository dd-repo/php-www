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

$services_left = 260-round($serv['used']*260/$serv['max']);

$services = api::send('self/service/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"float: left; width: 500px;\">
				<h3>{$lang['services']}</h3>
				<div class=\"ui-meter-holder\">
					<div class=\"ui-meter\">
						<div class=\"after-fill fill\" style=\"z-index: 9; display: none;\"></div>
						<div class=\"before-fill fill\" style=\"z-index: 10; right: {$services_left}px;\"></div>
						<div class=\"base-fill fill\" style=\"z-index: 20; display: none;\"></div>
					</div>
				</div>
				<div class=\"details\">
					<span class=\"usage\">{$serv['used']}</span> / <span class=\"limit\">{$serv['max']}</span>
				</div>
				<div class=\"clearfix\"></div>
			</div>
			<div style=\"padding-top: 14px;\">
				<a class=\"btn\" href=\"/panel/plans\">{$lang['more']}</a>
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<h2>{$lang['list']}</h2>
			<br />
			<table>
				<tr>
					<th>{$lang['name']}</th>
					<th>{$lang['desc']}</th>
					<th>{$lang['vendor']}</th>
					<th>{$lang['version']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

foreach( $services as $s )
{
	$content .= "
				<tr>
					<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$s['vendor']}.png\" alt=\"\" /><strong>{$s['name']}</strong></td>
					<td>{$s['description']}</td>
					<td>{$s['vendor']}</td>
					<td>{$s['version']}</td>
					<td align=\"center\">
		";
		
		if( security::hasGrant('SELF_SERVICE_DELETE') )
		{
			$content .= "
									<a href=\"/panel/service/del_action?name={$s['name']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
								</td>
							</tr>
		";
}

$content .= "
				</tr>
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/service/add\">{$lang['add']}</a> <a class=\"btn\" href=\"https://projets.anotherservice.com/projects/as-panel/wiki/Start_services\">{$lang['doc']}</a>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
