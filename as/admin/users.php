<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('order'=>'user_date', 'order_type'=>'DESC'));

$content = "
	<div class=\"admin\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<table>
				<tr>
					<th style=\"width: 40px; text-align: center;\">#</th>
					<th>{$lang['username']}</th>
					<th>{$lang['email']}</th>
					<th>{$lang['ip']}</th>
					<th>{$lang['date']}</th>
				</tr>
";

foreach( $users as $u )
{
	$content .= "
				<tr>
					<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$u['id']}\"><img style=\"width: 30px; height: 30px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$u['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
					<td><a href=\"/admin/users/detail?id={$u['id']}\">{$u['name']}</a></td>
					<td>{$u['email']}</td>
					<td>{$u['ip']}</td>
					<td>".date('Y-m-d H:i', $u['date'])."</td>
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