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
				<p class=\"large\">{$lang['intro']}</p>
				<form action=\"/panel/service/add_action\" method=\"post\">
					<input type=\"hidden\" name=\"vendor\" value=\"{$_GET['vendor']}\" />
					<input type=\"hidden\" name=\"version\" value=\"{$_GET['version']}\" />
					<fieldset>
						<label for=\"desc\">{$lang['desc']}</label>
						<input type=\"text\" name=\"desc\" />
					</fieldset>
					<fieldset>
						<label for=\"pass\">{$lang['password']}</label>
						<input type=\"password\" name=\"pass\" />
					</fieldset>
					<fieldset>
						<label for=\"submit\">&nbsp;</label>
						<input type=\"submit\" value=\"{$lang['add']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div class=\"right\">
			<div class=\"container\">	
				<h2>{$lang['doc']}</h2>
				<p class=\"large\">{$lang['doc_text']}</p>
				<a class=\"btn\" href=\"https://projets.anotherservice.com/projects/as-panel/wiki/Start_services\">{$lang['go']}</a>
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>