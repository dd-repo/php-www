<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !is_numeric($_GET['plan']) )
	exit();
	
$_SESSION['ANTISPAM'] = md5(time().'anotherservice');

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<form action=\"/join/pay\" method=\"post\" id=\"valid\" class=\"mainForm\">
				<input type=\"hidden\" name=\"antispam\" value=\"{$_SESSION['ANTISPAM']}\" />
				<input type=\"hidden\" name=\"code\" value=\"{$_GET['code']}\" />
				<input type=\"hidden\" name=\"plan\" value=\"{$_GET['plan']}\" />
				<fieldset>
					<label for=\"offer\">{$lang['offer']}</label>
					<span style=\"font-size: 25px; display: block; padding-top: 7px;\">".$lang['offer_' . $_GET['plan'] . '_title']."</span>
				</fieldset>
				<fieldset>
					<label for=\"username\">{$lang['username']}</label>
					<input type=\"text\" value=\"{$_SESSION['JOIN_USER']}\" name=\"username\" />
					<span class=\"help-block\">{$lang['usertip']}</span>
				</fieldset>
				<fieldset>						
					<label for=\"email\">{$lang['email']}</label>
					<input type=\"text\" value=\"".($_GET['email']?"{$_GET['email']}":"{$_SESSION['JOIN_EMAIL']}")."\" name=\"email\" />
				</fieldset>
				<fieldset>	
					<label for=\"submit\">&nbsp;</label>
					<input type=\"submit\" value=\"{$lang['join']}\" ".($_SESSION['JOIN_STATUS']===0?'disabled':'')." />
				</fieldset>
			</form>
		</div>
	</div>
";

unset($_SESSION['JOIN_USER']);
unset($_SESSION['JOIN_EMAIL']);
unset($_SESSION['JOIN_STATUS']);

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>