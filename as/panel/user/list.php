<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('domain'=>$_GET['domain']));
$domain = $domain[0];

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 700px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']} {$domain['hostname']}</h1>
			</div>
			<div class=\"right\" style=\"width: 300px;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 220px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<table>
				<tr>
					<th>{$lang['email']}</th>
					<th>{$lang['firstname']}</th>
					<th>{$lang['lastname']}</th>
					<th>{$lang['size']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$users = api::send('self/account/list', array('domain'=>$domain['hostname']));

if( count($users) > 0 )
{
	foreach($users as $u)
	{
		$content .= "
				<tr>
					<td>{$u['mail']}</td>
					<td>{$u['firstname']}</td>
					<td>{$u['lastname']}</td>
					<td><span class=\"large\">{$u['size']}Mo</span></td>
					<td style=\"width: 70px; text-align: center;\">
						<a href=\"/panel/user/config?domain={$domain['hostname']}&id={$u['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
						<a href=\"/panel/user/del_action?id={$u['id']}&domain={$domain['hostname']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>
		";
	}
}
	$content .= "
			</table>
		</div>		
	</div>
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: center;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/user/add_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['mail']}\" name=\"mail\" onfocus=\"this.value = this.value=='{$lang['mail']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['mail']}' : this.value; this.value=='{$lang['mail']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">".str_replace('{DOMAIN}', $domain['hostname'], $lang['mail_help'])."</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['firstname']}\" name=\"firstname\" onfocus=\"this.value = this.value=='{$lang['firstname']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['firstname']}' : this.value; this.value=='{$lang['firstname']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['firstname_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['lastname']}\" name=\"lastname\" onfocus=\"this.value = this.value=='{$lang['lastname']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['lastname']}' : this.value; this.value=='{$lang['lastname']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['lastname_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['password_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newDialog('new', 550, 530);
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
