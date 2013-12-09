<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<p class=\"large\">{$lang['intro']}</p>
			<table>
				<tr>
					<th>{$lang['domain']}</th>
					<th>{$lang['arecord']}</th>
					<th>{$lang['users']}</th>
					<th>{$lang['groups']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

if( count($domains) > 0 )
{
	foreach($domains as $d)
	{
		$users = api::send('self/account/list', array('domain'=>$d['hostname'], 'count'=>1));
		$groups = api::send('self/team/list', array('domain'=>$d['hostname'], 'count'=>1));
		
		$content .= "
				<tr>
					<td><a href=\"/panel/user/list?domain={$d['hostname']}\"><strong>{$d['hostname']}</strong></a></td>
					<td><span class=\"lightlarge\">{$d['aRecord']}</span></td>
					<td>{$users['count']} {$lang['user']}</td>
					<td>{$groups['count']} {$lang['group']}</td>
					<td align=\"center\">
		";
		
		if( security::hasGrant('SELF_ACCOUNT_INSERT') )
		{
			$content .= "
									<a href=\"/panel/user/list?domain={$d['hostname']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		$content .= "
								</td>
							</tr>
		";
	}
}
	
$content .= "
						</tbody>
					</table>
				</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
