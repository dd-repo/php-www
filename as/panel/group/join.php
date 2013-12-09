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
					<th>{$lang['email']}</th>
					<th>{$lang['firstname']}</th>
					<th>{$lang['lastname']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$groups = api::send('self/team/list', array('domain'=>$_GET['domain']));

if( count($groups) > 0 )
{
	foreach($groups as $g)
	{
		$content .= "
				<tr>
					<td>{$g['mail']}</td>
					<td>{$g['firstname']}</td>
					<td>{$g['lastname']}</td>
					<td align=\"center\">
						<a href=\"/panel/group/join_action?id={$_GET['id']}&domain={$_GET['domain']}&gid={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
					</td>
				</tr>
		";
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
