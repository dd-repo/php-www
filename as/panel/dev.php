<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$repos = api::send('self/repo/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<table>
				<tr>
					<th>{$lang['name']}</th>
					<th>{$lang['desc']}</th>
					<th>{$lang['dir']}</th>
					<th>{$lang['size']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

foreach( $repos as $r )
{
	$content .= "
				<tr>
					<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-{$r['type']}.png\" alt=\"\" /><strong>{$r['name']}</strong></td>
					<td>{$r['description']}</td>
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
			<a class=\"btn\" href=\"/panel/repo/add\">{$lang['add']}</a> <a class=\"btn\" href=\"https://projets.anotherservice.com/projects/as-panel/wiki/Start_repositories\">{$lang['doc']}</a>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
