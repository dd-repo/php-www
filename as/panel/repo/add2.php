<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

$content = "
	<div class=\"box rightcol\">
		<div class=\"left\">
			<div class=\"container\">
				<h2>{$lang['title']}</h2>
				<p class=\"large\">{$lang['intro']}</p>
				<form action=\"/panel/repo/add_action\" method=\"post\">
					<input type=\"hidden\" name=\"type\" value=\"{$_GET['type']}\" />
					
					<fieldset>
						<label for=\"name\">{$lang['domain']}</label>
						<select name=\"domain\">
							<option value=\"anotherservice.net\">anotherservice.net</option>";
foreach( $domains as $d )
	$content .= "			<option value=\"{$d['hostname']}\">{$d['hostname']}</option>";

$content .= "
						</select>
					</fieldset>
					<fieldset>
						<label for=\"desc\">{$lang['desc']}</label>
						<input type=\"text\" name=\"desc\" />
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
				<a class=\"btn\" href=\"https://projets.anotherservice.com/projects/as-panel/wiki\">{$lang['go']}</a>
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>