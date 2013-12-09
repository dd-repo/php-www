<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$services = api::send('self/service/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} :: <i>{$app['name']}</i></h2>
			<p class=\"large\">{$lang['intro']}</p>
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
						<a href=\"/panel/app/add_service_action?id={$app['id']}&service={$s['name']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/link.png\" alt=\"\" /></a>
					</td>
				</tr>
		";
	}

	$content .= "
				</tr>
			</table>
		</div>
	</div>
	<div class=\"clearfix\"></div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>