<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

unset($_SESSION['LOGIN_ACCOUN']['ID']);
	
$content = "
	<div class=\"box rightcol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
				<div class=\"subhead\">{$lang['subtitle']}</div>
			</div>
		</div>
		<div class=\"left\">
			<div class=\"container\">
				<form action=\"/account/config\" method=\"post\">
					<fieldset>
						<label for=\"username\">{$lang['username']}</label>
						<input type=\"text\" name=\"username\"/>
					</fieldset>
					<fieldset>
						<label for=\"password\">{$lang['password']}</label>
						<input type=\"password\" name=\"password\" />
					</fieldset>						
					<fieldset>
						<label for=\"submit\">&nbsp;</label>
						<input type=\"submit\" value=\"{$lang['login']}\" />
					</fieldset>													
				</form>
			</div>
		</div>
		<div class=\"right\">
			<div class=\"container\">
				
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";


/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>