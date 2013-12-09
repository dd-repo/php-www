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
				<form action=\"/account/add_alternate_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"{$_GET['domain']}\" />
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />					
					<fieldset>
						<label>{$lang['mail']}</label>
						<input type=\"text\" name=\"alternate\" /><span class=\"small\">@{$_GET['domain']}</span>
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
