<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$group = api::send('self/team/list', array('id'=>$_GET['id'], 'domain' => $_GET['domain']));
$group = $group[0];

$content .= "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} :: {$group['mail']}</h2>
			<br />
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<br />
				<form action=\"/panel/group/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"{$_GET['domain']}\" />
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
					<fieldset>
						<label>{$lang['password']}</label>
						<input type=\"password\" name=\"password\" />
					</fieldset>
					<fieldset>
						<label>{$lang['password2']}</label>
						<input type=\"password\" name=\"confirm\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<br />
				<form action=\"/panel/group/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"{$_GET['domain']}\" />
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
					<fieldset>
						<label>{$lang['firstname']}</label>
						<input type=\"text\" name=\"firstname\" value=\"{$group['firstname']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['lastname']}</label>
						<input type=\"text\" name=\"lastname\" value=\"{$group['lastname']}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div class=\"clearfix\"></div>
			<h2>{$lang['redirections']}</h2>
			<table>
				<tr>
					<th>{$lang['email']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";
	
	if( !is_array($group['redirection']) && $group['redirection'] )
		$group['redirection'] = array($group['redirection']);
	
	if( $group['redirection'] )
	{
		foreach( $group['redirection'] as $r )
		{
			$content .= "
				<tr>
					<td>{$r}</td>
					<td align=\"center\">
						<a href=\"/panel/group/del_redirection_action?redirection={$r}&domain={$_GET['domain']}&id={$_GET['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
		}
	}
	
	$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/group/add_redirection?id={$_GET['id']}&domain={$_GET['domain']}\">{$lang['add_redir']}</a>
			<br /><br />
			<h2>{$lang['alternates']}</h2>
			<table>
				<tr>
					<th>{$lang['email']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";
	
	if( !is_array($group['alternate']) && $group['alternate'] )
		$group['alternate'] = array($group['alternate']);
	
	if( $group['alternate'] )
	{
		foreach( $group['alternate'] as $a )
		{
			$content .= "
				<tr>
					<td>{$a}</td>
					<td align=\"center\">
						<a href=\"/panel/group/del_alternate_action?alternate={$a}&domain={$_GET['domain']}&id={$_GET['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
		}
	}
	
	$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/group/add_alternate?id={$_GET['id']}&domain={$_GET['domain']}\">{$lang['add_alt']}</a>
			<br /><br />
			<h2>{$lang['groups']}</h2>
			<table>
				<tr>
					<th>{$lang['group']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";

	if( $group['groups'] )
	{
		foreach( $group['groups'] as $gg )
		{
			$content .= "
				<tr>
					<td>{$gg['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/group/unjoin_action?group={$gg['id']}&domain={$_GET['domain']}&id={$_GET['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
		}
	}
	
	$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/group/join?id={$_GET['id']}&domain={$_GET['domain']}\">{$lang['join']}</a>
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
