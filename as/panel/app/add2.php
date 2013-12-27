<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

if( count($domains) > 0 )
{
	$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<form action=\"/panel/app/add_action\" method=\"post\">
				<input type=\"hidden\" name=\"runtime\" value=\"".security::encode($_GET['runtime'])."\" />
				<fieldset>
					<label for=\"name\">{$lang['domain']}</label>
					<select name=\"domain\">";
					
	foreach( $domains as $d )
		$content .= "		<option value=\"{$d['hostname']}\">{$d['hostname']}</option>";

	$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_domain']}</span>
				</fieldset>
				<fieldset>
					<label for=\"pass\">{$lang['password']}</label>
					<input type=\"password\" name=\"pass\" />
					<span class=\"help-block\">{$lang['help_password']}</span>
				</fieldset>
				<fieldset>
					<label for=\"tag\">{$lang['tag']}</label>
					<input type=\"text\" name=\"tag\" />
					<span class=\"help-block\">{$lang['help_tag']}</span>
				</fieldset>	
";

if( isset($_GET['standalone']) )
{
	$content .= "
				<fieldset>
					<label for=\"binary\">{$lang['binary']} ".security::encode($_GET['runtime'])."</label>
					<input type=\"text\" name=\"binary\" />
					<span class=\"help-block\">{$lang['help_binary']}</span>
				</fieldset>	
	";

}

$content .= "
				<fieldset>
					<label for=\"submit\">&nbsp;</label>
					<input type=\"submit\" value=\"{$lang['add']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	";
}
else
{
	$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<p class=\"large\">{$lang['no_domain']}</p><br />
			<a class=\"btn\" href=\"/panel/domain/add\">{$lang['add_domain']}</a>
		</div>
	</div>
	";
}

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>