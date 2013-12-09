<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$_SESSION['ANTISPAM'] = md5(time().'busit');
	
$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<form action=\"/login_action\" method=\"post\">
				<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
				<fieldset>
					<label for=\"username\">{$lang['username']}</label>";
					
if( isset($_SESSION['LOGIN_USER']) )
{
	$content .= "
					<input type=\"hidden\" value=\"{$_SESSION['LOGIN_USER']}\" name=\"username\" />
					<input type=\"text\" value=\"{$_SESSION['LOGIN_USER']}\" name=\"x\" disabled />
	";
	unset($_SESSION['LOGIN_USER']);
}
else
{
	$content .= "
					<input type=\"text\" value=\"{$_SESSION['LOGIN_USER']}\" name=\"username\" />
								";
}

$content .= "
				</fieldset>
				<fieldset>
						";

if( isset($_SESSION['LOGIN_TOKENS']) )
{
	$options = "<option value=\"\">{$lang['token_choose']}</option>";
	foreach($_SESSION['LOGIN_TOKENS'] as $t)
	{
		$options .= "<option value=\"{$t['token']}\">";
		if( $t['name'] != null && strlen($t['name']) > 0 )
			$options .= $t['name'];
		else
			$options .= substr($t['token'], 0, 10).'...';
	}
	$content .= "
					<label for=\"token\">{$lang['token']}</label>
					<select name=\"password\">{$options}</select>";
	unset($_SESSION['LOGIN_TOKENS']);
}
else
{
	$content .= "
					<label for=\"password\">{$lang['password']}</label>
					<input type=\"password\" name=\"password\" />";
}

$content .= "
					".(isset($_GET['e'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['auth']}</span>":"<span class=\"help-block\">{$lang['register']}</span>")."
				</fieldset>						
				<fieldset>
					<label for=\"submit\">&nbsp;</label>
					<input type=\"submit\" value=\"{$lang['login']}\" />
				</fieldset>													
			</form>
		</div>
	</div>
";


/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>