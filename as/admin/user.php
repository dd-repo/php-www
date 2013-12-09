<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('order'=>'user_date', 'order_type'=>'DESC'));

$content = "
		<div class=\"box nocol\">
			<div class=\"container\">
				<h2>{$lang['title']}</h2>
				<br />
				<table>
					<tr>
						<th>{$lang['name']}</th>
						<th>{$lang['email']}</th>
						<th>{$lang['date']}</th>
						<th>{$lang['ip']}</th>
						<th>{$lang['actions']}</th>
					</tr>";

foreach( $users as $u )
{
	$content .= "
					<tr>
						<td>{$u['name']}</td>
						<td>{$u['email']}</td>
						<td>".date('Y-m-d', $u['date'])."</td>
						<td>{$u['ip']}</td>
						<td>
							<a href=\"/admin/user/detail?id={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a href=\"/admin/user/del_action?id={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
	";
}

$content .= "
				</table>
			</div>
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>