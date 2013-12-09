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
					<th>{$lang['app']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$apps = api::send('self/app/list');

if( count($apps) > 0 )
{
	foreach($apps as $a)
	{
		$content .= "
				<tr>
					<td>{$a['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/repo/permit_action?id={$_GET['id']}&member={$a['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
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