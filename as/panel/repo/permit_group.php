<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<p class=\"large\">{$lang['intro']}</p>
			<br />
			<table>
				<tr>
					<th>{$lang['group']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$domains = api::send('self/domain/list');

if( count($domains) > 0 )
{
	foreach( $domains as $d )
	{
		$groups = api::send('self/team/list', array('domain'=>$d['hostname']));
	
		if( count($groups) > 0 )
		{
			foreach( $groups as $g )
			{
				$content .= "
				<tr>
					<td>{$g['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/repo/permit_action?id={$_GET['id']}&member={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
					</td>
				</tr>
				";
			}
		}
	}
}
		
$content .= "
			</table>					
		</div>
	</div>		
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>