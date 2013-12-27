<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$_SESSION['ANTISPAM'] = md5(time().'olympe');

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<form action=\"/change_password_action\" method=\"post\">
				<input type=\"hidden\" name=\"user\" value=\"".security::encode($_GET['user'])."\" />
				<input type=\"hidden\" name=\"token\" value=\"".security::encode($_GET['token'])."\" />
				<fieldset>
					<label>{$lang['password']}</label>
					<input type=\"password\" name=\"pass\" />
				</fieldset>
				<fieldset>
					<label>{$lang['password2']}</label>
					<input type=\"password\" name=\"confirm\" />
				</fieldset>
				<fieldset>
					<label></label>
					<input type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>