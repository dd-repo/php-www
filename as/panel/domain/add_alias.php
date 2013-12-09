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
			<p class=\"large\">{$lang['intro']}</p>
			<form action=\"/panel/domain/add_alias_action\" method=\"post\">
				<input type=\"hidden\" name=\"id\" value=\"{$_GET['domain']}\" />
				<fieldset>
					<label>{$lang['domain']}</label>
					<input type=\"text\" name=\"domain\" />
					".(isset($_GET['e'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['error']}</span>":"")."
				</fieldset>
				<fieldset>
					<label>{$lang['type']}</label>
					<select name=\"type\">
						<option value=\"permanent\">Permanente</option>
						<option value=\"transparent\">Transparente</option>
					</select>
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
