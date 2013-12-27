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
			<form action=\"/recovery_action\" method=\"post\" id=\"valid\" class=\"mainForm\">
				<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
				<fieldset>
					<label for=\"username\">{$lang['username']}</label>
					<input type=\"text\" value=\"{$_SESSION['JOIN_USER']}\" name=\"username\" />
					<span class=\"help-block\">{$lang['usertip']}</span>
				</fieldset>
				<fieldset>	
					<label for=\"submit\">&nbsp;</label>
					<input type=\"submit\" value=\"{$lang['recover']}\" />
				</fieldset>
			</form>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>