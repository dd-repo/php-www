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
				<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<table>
				<tr>
					<th style=\"text-align: center; width: 40px;\">#</th>
					<th>{$lang['email']}</th>
					<th>{$lang['firstname']}</th>
					<th>{$lang['lastname']}</th>
					<th>{$lang['size']}</th>
					<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
				</tr>
";

$users = api::send('self/account/list', array('domain'=>$domain['hostname']));

if( count($users) > 0 )
{
	foreach($users as $u)
	{
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/users/config?domain={$domain['hostname']}&id={$u['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/user.png\" /></a></td>
					<td>{$u['mail']}</td>
					<td>{$u['firstname']}</td>
					<td>{$u['lastname']}</td>
					<td><span class=\"large\">{$u['size']}Mo</span></td>
					<td style=\"width: 100px; text-align: center;\">
						<a href=\"/panel/users/config?domain={$domain['hostname']}&id={$u['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>
						<a href=\"#\" onclick=\"$('#user').val('{$u['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
					</td>
				</tr>
		";
	}
}
	$content .= "
			</table>
			<br /><br />
			<div class=\"left\" style=\"width: 700px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['groups']} {$domain['hostname']}</h1>
			</div>
			<div class=\"right\" style=\"width: 300px;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#newgroup').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add_group']}</span>
				</a>
			</div>
			<div class=\"clear\"></div><br />
			<table>
				<tr>
					<th style=\"text-align: center; width: 40px;\">#</th>
					<th>{$lang['name']}</th>
					<th>{$lang['firstname']}</th>
					<th>{$lang['lastname']}</th>
					<th>{$lang['size']}</th>
					<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
				</tr>
";

$groups = api::send('self/team/list', array('domain'=>$domain['hostname']));

if( count($groups) > 0 )
{
	foreach($groups as $g)
	{
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/groups/config?domain={$domain['hostname']}&id={$g['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/group.png\" /></a></td>
					<td>{$g['name']}</td>
					<td>{$g['firstname']}</td>
					<td>{$g['lastname']}</td>
					<td><span class=\"large\">{$g['size']}Mo</span></td>
					<td style=\"width: 100px; text-align: center;\">
						<a href=\"/panel/groups/config?domain={$domain['hostname']}&id={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>
						<a href=\"#\" onclick=\"$('#group').val('{$g['id']}'); $('#deletegroup').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
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
			<form action=\"/panel/users/add_action\" method=\"post\" class=\"center\">
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
	<div id=\"newgroup\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['newgroup']}</h3>
		<p style=\"text-align: center;\">{$lang['newgroup_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/groups/add_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['mail']}\" name=\"mail\" onfocus=\"this.value = this.value=='{$lang['mail']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['mail']}' : this.value; this.value=='{$lang['mail']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['group_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['firstname']}\" name=\"firstname\" onfocus=\"this.value = this.value=='{$lang['firstname']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['firstname']}' : this.value; this.value=='{$lang['firstname']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['group_firstname_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['lastname']}\" name=\"lastname\" onfocus=\"this.value = this.value=='{$lang['lastname']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['lastname']}' : this.value; this.value=='{$lang['lastname']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['group_lastname_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['group_password_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/users/del_action?domain={$domain['hostname']}\" method=\"post\" class=\"center\">
				<input id=\"user\" type=\"hidden\" value=\"\" name=\"user\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"deletegroup\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['deletegroup']}</h3>
		<p style=\"text-align: center;\">{$lang['deletegroup_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/groups/del_action?domain={$domain['hostname']}\" method=\"post\" class=\"center\">
				<input id=\"group\" type=\"hidden\" value=\"\" name=\"group\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['deletegroup_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('new', 550);
		newFlexibleDialog('newgroup', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('deletegroup', 550);
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
