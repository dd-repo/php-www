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
					<th>{$lang['user']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$domains = api::send('self/domain/list');

if( count($domains) > 0 )
{
	foreach( $domains as $d )
	{
		$users = api::send('self/account/list', array('domain'=>$d['hostname']));
	
		if( count($users) > 0 )
		{
			foreach( $users as $u )
			{
				$content .= "
				<tr>
					<td>{$u['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/repo/permit_action?id={$_GET['id']}&member={$u['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
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