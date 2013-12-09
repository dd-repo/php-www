<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['title']}</h5></div>
				<form action=\"/panel/db/config_action\" method=\"post\" class=\"mainForm\">
					<input type=\"hidden\" name=\"database\" value=\"{$_GET['database']}\" />
					<fieldset>
						<div class=\"widget first\">
							<div class=\"head\"><h5 class=\"iList\">{$lang['subtitle']} {$_GET['database']}</h5></div>
							<div class=\"rowElem\"><label>{$lang['password']}</label><div class=\"formRight\"><input type=\"password\" name=\"password\" /></div><div class=\"fix\"></div></div>
							<input type=\"submit\" value=\"{$lang['update']}\" class=\"greyishBtn submitForm\" />
							<div class=\"fix\"></div>
						</div>
					</fieldset>
				</form>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
