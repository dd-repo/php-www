<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<p class=\"large\">{$lang['intro']}</p>
			<form action=\"/panel/app/add_action\" method=\"post\">
				<input type=\"hidden\" name=\"runtime\" value=\"{$_GET['runtime']}\" />
				<input type=\"hidden\" name=\"framework\" value=\"{$_GET['framework']}\" />
				<input type=\"hidden\" name=\"app\" value=\"{$_GET['app']}\" />
				<input type=\"hidden\" name=\"service\" value=\"{$_GET['service']}\" />
				<input type=\"hidden\" name=\"version\" value=\"{$_GET['version']}\" />
				<fieldset>
					<label for=\"name\">{$lang['domain']}</label>
					<select name=\"domain\">
						<option value=\"anotherservice.net\">anotherservice.net</option>";
foreach( $domains as $d )
	$content .= "		<option value=\"{$d['hostname']}\">{$d['hostname']}</option>";

$content .= "
					</select>
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
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>