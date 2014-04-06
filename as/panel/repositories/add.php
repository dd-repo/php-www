<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">";
		
if( count($domains) > 0 )
{
	$content .= "
			<a href=\"#\" onclick=\"$('#type').val('git'); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-git.png\" alt=\"git\"><span class=\"large\">GIT</span><br /><span style=\"color: #000000;\" class=\"small\">Git Repository</span></p>
					<div class=\"overline\">{$lang['access']} SSH</div>
					<br />		
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#type').val('hg'); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-hg.png\" alt=\"hg\"><span class=\"large\">HG</span><br /><span style=\"color: #000000;\" class=\"small\">Mercurial Repository</span></p>
					<div class=\"overline\">{$lang['access']} SSH</div>
					<br />		
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#type').val('svn'); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-svn.png\" alt=\"git\"><span class=\"large\">SVN</span><br /><span style=\"color: #000000;\" class=\"small\">Subversion Repository</span></p>
					<div class=\"overline\">{$lang['access']} SSH</div>
					<br />
				</div>
			</a>
			<div class=\"clear\"></div>
	";
}
else
{
	$content .= "<p>{$lang['no_domain']}</p>";
}

$content .= "
		</div>
	</div>

	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: center;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/repo/add_action\" method=\"post\" class=\"center\">
				<input id=\"type\" type=\"hidden\" name=\"type\" value=\"\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['desc']}\" name=\"desc\" onfocus=\"this.value = this.value=='{$lang['desc']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['desc']}' : this.value; this.value=='{$lang['desc']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['desc_help']}</span>
				</fieldset>
				<fieldset>
					<select name=\"domain\">";
foreach( $domains as $d )
	$content .= "			<option value=\"{$d['hostname']}\">{$d['hostname']}</option>";

$content .= "
					</select>
					<span class=\"help-block\">{$lang['domain_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('new', 550);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>