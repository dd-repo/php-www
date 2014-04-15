<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('limit' => 10, 'order'=>'user_date', 'order_type'=>'DESC'));
$overquotas = api::send('quota/nearlimit', array('quota'=>'DISK'));

require_once 'as/status/vendor/autoload.php';

$client = new Redmine\Client('https://projets.anotherservice.com', $GLOBALS['CONFIG']['REDMINE_TOKEN']);
$issues = $client->api('issue')->all(array('project_id' => 'support', 'limit' => 5,  'sort' => 'updated_on:desc' ));
$issues = $issues['issues'];

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
			<div style=\"width: 350px; float: left;\">
				<h3 class=\"colored\">{$lang['search']}</h3>
				<form action=\"/admin/search_action\" method=\"post\">
					<fieldset>
						<input class=\"auto\" style=\"width: 300px;\" type=\"text\" name=\"name\" value=\"{$lang['name']}\" onfocus=\"this.value = this.value=='{$lang['name']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['name']}' : this.value; this.value=='{$lang['name']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					</fieldset>
					<fieldset>
						<input class=\"auto\" style=\"width: 300px;\" type=\"text\" name=\"email\" value=\"{$lang['email']}\" onfocus=\"this.value = this.value=='{$lang['email']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['email']}' : this.value; this.value=='{$lang['email']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					</fieldset>
					<fieldset>
						<input class=\"auto\" style=\"width: 300px;\" type=\"text\" name=\"domain\" value=\"{$lang['domain']}\" onfocus=\"this.value = this.value=='{$lang['domain']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['domain']}' : this.value; this.value=='{$lang['domain']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['go']}\" />
					</fieldset>					
				</form>
			</div>
			<div style=\"width: 700px; float: right;\">
				<h3 class=\"colored\">{$lang['support']}</h3>
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th style=\"width: 200px;\">{$lang['client']}</th>
						<th>{$lang['subject']}</th>
						<th style=\"width: 90px;\">{$lang['date']}</th>						
					</tr>
";

foreach( $issues as $i )
{
	$content .= "
					<tr>
						<td style=\"text-align: center;\"><a href=\"https://support.anotherservice.com/issues/{$i['id']}\"><img style=\"width: 25px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" /></a></td>
						<td>{$i['project']['name']}</td>
						<td>{$i['subject']}</td>
						<td>".date('Y-m-d', strtotime($i['updated_on']))."</td>
					</tr>
	";
}

$content .= "
				</table>
				<br />
			</div>
			<div class=\"clear\"></div>
			<br />
			<div style=\"width: 350px; float: left;\">
				<h3 class=\"colored\">{$lang['overquota']}</h3>
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['username']}</th>
						<th>{$lang['disk']}</th>
						<th>{$lang['max']}</th>
					</tr>
";

$i = 0;
foreach( $overquotas as $o )
{
	$content .= "
					<tr>
						<td style=\"width: 40px; text-align: center;\"><a href=\"/admin/users/detail?id={$o['id']}\"><img style=\"width: 30px; height: 30px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$o['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$o['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a></td>
						<td><a href=\"/admin/users/detail?id={$o['id']}\">{$o['name']}</a></td>
						<td>{$o['quotas']['used']}</td>
						<td>{$o['quotas']['max']}</td>
					</tr>
	";
	$i++;
	
	if( $i > 9 )
		break;
}

$content .= "
				</table>
			</div>
			<div style=\"width: 700px; float: right;\">
				<h3 class=\"colored\">{$lang['last']}</h3>
				<table>
					<tr>
						<th style=\"width: 40px; text-align: center;\">#</th>
						<th>{$lang['username']}</th>
						<th>{$lang['email']}</th>
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
						<td>".date('Y-m-d H:i', $u['date'])."</td>
					</tr>
	";
}

$content .= "
				</table>
			</div>

			<div class=\"clear\"></div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>