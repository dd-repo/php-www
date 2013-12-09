<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box rightcol\">
		<div class=\"left\">
			<div class=\"container\">
				<h2>{$lang['title']}</h2>
				<form action=\"/panel/user/add_redirection_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"{$_GET['domain']}\" />
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />					
					<fieldset>
						<label>{$lang['mail']}</label>
						<input type=\"text\" name=\"redirection\" />
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['add']}\" />
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
