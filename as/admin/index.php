<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('from'=>strtotime('-1 week'), 'order'=>'user_date', 'order_type'=>'DESC'));

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['search']}</h3>
				<br />
				<form action=\"/admin/search_action\" method=\"post\">
					<fieldset>
						<label>{$lang['name']}</label>
						<input type=\"text\" name=\"name\" />
					</fieldset>
					<fieldset>
						<label>{$lang['domain']}</label>
						<input type=\"text\" name=\"domain\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['go']}\" />
					</fieldset>					
				</form>
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['last']}</h3>
				<br />
				<table>
					<tr>
						<th>{$lang['username']}</th>
						<th>{$lang['email']}</th>
						<th>{$lang['date']}</th>
					</tr>
";

foreach( $users as $u )
{
	$content .= "
					<tr>
						<td><a href=\"/admin/user/detail?id={$u['id']}\">{$u['name']}</a></td>
						<td>{$u['email']}</td>
						<td>".date('Y-m-d H:i', $u['date'])."</td>
					</tr>
	";
}

$content .= "
				</table>
			</div>
			<div class=\"clearfix\"></div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>