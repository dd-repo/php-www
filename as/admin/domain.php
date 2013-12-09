<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('domain/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<table>
				<tr>
					<th>{$lang['domain']}</th>
					<th>{$lang['arecord']}</th>
					<th>{$lang['home']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

if( count($domains) > 0 )
{
	foreach($domains as $d)
	{
		$content .= "
				<tr>
					<td><a href=\"/admin/domain/config?id={$d['id']}\"><strong>{$d['hostname']}</strong></a></td>
					<td><span class=\"lightlarge\">{$d['aRecord']}</a></td>
					<td>{$d['homeDirectory']}</td>
					<td align=\"center\">
		";
		
		if( security::hasGrant('SELF_DOMAIN_UPDATE') )
		{
			$content .= "
									<a href=\"/admin/domain/config?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		if( security::hasGrant('SELF_DOMAIN_DELETE') )
		{
			$content .= "
									<a href=\"/admin/domain/del_action?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
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
