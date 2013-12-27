<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<form action=\"/panel/domain/add_action\" method=\"post\">
				<fieldset>
					<label>{$lang['domain']}</label>
					<input type=\"text\" name=\"domain\" />
					".(isset($_GET['e'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['error']}</span>":"<span class=\"help-block\">{$lang['help_domain']}</span>")."
				</fieldset>
				<fieldset>
					<label></label>
					<input type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
