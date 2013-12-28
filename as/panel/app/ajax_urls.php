<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
$domains = api::send('self/domains/list');

$content = "
			<form action=\"/panel/app/add_url_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<input type=\"hidden\" name=\"branch\" value=\"{$_SESSION['DATA'][$app['id']]['branch']}\" />
				<fieldset>
					<select name=\"url\">";
foreach( $domains as $d )
{
	$content .= "		<optgroup label=\"{$d['hostname']}\">
							<option value=\"{$d['hostname']}\">{$d['hostname']}</option>
	";

	$subdomains = api::send('self/subdomain/list', array('domain' => $d['hostname']));
	foreach( $subdomains as $s )
		$content .= "			<option value=\"{$s['hostname']}\">{$s['hostname']}</option>";
		
	$content .= " 			</optgroup>";
}

$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_url']}</span>
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['add_url']}\" />
				</fieldset>
			</form>
";

echo $content;

?>