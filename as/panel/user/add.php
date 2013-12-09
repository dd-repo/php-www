<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('domain'=>$_GET['domain']));
$domain = $domain[0];

$content = "
	<div class=\"box rightcol\">
		<div class=\"left\">
			<div class=\"container\">
				<h2>{$lang['title']} :: <i>{$domain['hostname']}</i></h2>
				<p class=\"large\">{$lang['intro']}</p>
				<form action=\"/panel/user/add_action\" method=\"post\" class=\"mainForm\">
					<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
					<fieldset>
						<label>{$lang['mail']}</label>
						<input type=\"text\" name=\"mail\" /><span class=\"small\">@{$domain['hostname']}</span>
					</fieldset>
					<fieldset>
						<label>{$lang['firstname']}</label>
						<input type=\"text\" name=\"firstname\" />
					</fieldset>
					<fieldset>
						<label>{$lang['lastname']}</label>
						<input type=\"text\" name=\"lastname\" />
					<fieldset>
					<fieldset>
						<label>{$lang['password']}</label>
						<input type=\"password\" name=\"password\" />
					<fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['create']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div class=\"right\">
			<div class=\"container\">
				<h2>{$lang['doc']}</h2>
				<p class=\"large\">{$lang['doc_text']}</p>
				<a class=\"btn\" href=\"https://projets.anotherservice.com/projects/as-panel/wiki/Comptes_mails_et_agendas\">{$lang['go']}</a>
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
