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
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"float: left; width: 500px;\">
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
				<div class=\"clearfix\"></div>
			</div>
			<div style=\"padding-top: 14px;\">
				<a class=\"btn\" href=\"/panel/storage\">{$lang['more']}</a>
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<h2>{$lang['list']}</h2>
			<table>
				<tr>
					<th>{$lang['name']}</th>
					<th>{$lang['uid']}</th>
					<th>{$lang['dir']}</th>
					<th>{$lang['size']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

foreach( $repos as $r )
{
	$content .= "
				<tr>
					<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-{$r['type']}.png\" alt=\"\" /><strong>{$r['description']}</strong></td>
					<td>{$r['name']}</td>
					<td>{$r['dir']}</td>
					<td><span class=\"large\">{$r['size']}Mo</span></td>
					<td align=\"center\">
		";
	
		if( security::hasGrant('SELF_SERVICE_UPDATE') )
		{
			$content .= "
									<a href=\"/panel/repo/config?id={$r['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
			
		if( security::hasGrant('SELF_SERVICE_DELETE') )
		{
			$content .= "
									<a href=\"/panel/repo/del_action?id={$r['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
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
			<a class=\"btn\" href=\"/panel/repo/add\">{$lang['add']}</a> <a class=\"btn\" href=\"/doc/repos\">{$lang['doc']}</a>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
