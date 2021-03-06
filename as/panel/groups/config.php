<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$team = api::send('self/team/list', array('id'=>$_GET['id'], 'domain' => $_GET['domain']));
$team = $team[0];

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px; width: 600px;\">
				<h1 class=\"dark\">{$lang['group']} {$team['name']}</h1>
			</div>
			<div class=\"right\" style=\"width: 400px;\">
				<a class=\"button classic\" href=\"/panel/users/list?domain=".security::encode($_GET['domain'])."\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['back']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<div style=\"width: 500px; float: left;\">
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<form action=\"/panel/groups/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"".security::encode($_GET['domain'])."\" />
					<input type=\"hidden\" name=\"id\" value=\"".security::encode($_GET['id'])."\" />
					<fieldset>
						<input type=\"password\" name=\"password\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password']}</span>
					</fieldset>
					<fieldset>
						<input type=\"password\" name=\"confirm\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password2']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 420px; float: right;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<form action=\"/panel/groups/config_action\" method=\"post\">
					<fieldset>
						<input type=\"text\" name=\"firstname\" value=\"{$team['firstname']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['firstname']}</span>
					</fieldset>
					<fieldset>
						<input type=\"text\" name=\"lastname\" value=\"{$team['lastname']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['lastname']}</span>
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
	</div>
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
