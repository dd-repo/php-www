<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$subdomain = api::send('self/subdomain/list', array('id'=>$_GET['id'], 'domain'=>$_GET['domain']));
$subdomain = $subdomain[0];

$content .= "
	<div class=\"box rightcol\">
		<div class=\"left\">
			<div class=\"container\">
				<h2>{$lang['title']}</h2>
				<p class=\"large\">{$lang['intro']}</p>
				<form action=\"/panel/domain/config_subdomain_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
					<input type=\"hidden\" name=\"domain\" value=\"{$_GET['domain']}\" />
					<input type=\"hidden\" name=\"domain_id\" value=\"{$_GET['domain_id']}\" />
					<fieldset>
						<label>{$lang['record']}</label>
						<input type=\"text\" name=\"record\" value=\"{$subdomain['aRecord']}{$subdomain['cNAMERecord']}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
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
