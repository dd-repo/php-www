<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !$_SESSION['LOGIN_ACCOUNT']['ID'] || !$_SESSION['LOGIN_ACCOUNT']['DOMAIN']  )
{
	if( !isset($_POST['username']) || !isset($_POST['password']) )
		$template->redirect('/account?e');

	$email = explode('@', $_POST['username']);
	$user = $email[0];
	$domain = $email[1];

	try
	{
		$account = api::send('account/list', array('name'=>$user, 'domain' => $domain), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		$account = $account[0];
	}
	catch( Exception $e )
	{
		$template->redirect('/account?e');
	}

	$handler = @ldap_connect('ldap.anotherservice.com');
	$check = @ldap_bind($handler, $account['dn'], $_POST['password']);

	if( !$check )
		$template->redirect('/account?e');
		
	$_SESSION['LOGIN_ACCOUNT']['ID'] = $account['id'];
	$_SESSION['LOGIN_ACCOUNT']['DOMAIN'] = $domain;
}

if( !$account )
{	
	$account = api::send('account/list', array('id'=>$_SESSION['LOGIN_ACCOUNT']['ID'], 'domain' => $_SESSION['LOGIN_ACCOUNT']['DOMAIN']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$account = $account[0];
}

$content .= "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} :: {$account['mail']}</h2>
			<br />
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<br />
				<form action=\"/account/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"{$_SESSION['LOGIN_ACCOUNT']['DOMAIN']}\" />
					<input type=\"hidden\" name=\"id\" value=\"{$_SESSION['LOGIN_ACCOUNT']['ID']}\" />
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
				<form action=\"/account/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"domain\" value=\"{$_SESSION['LOGIN_ACCOUNT']['DOMAIN']}\" />
					<input type=\"hidden\" name=\"id\" value=\"{$_SESSION['LOGIN_ACCOUNT']['ID']}\" />
					<fieldset>
						<label>{$lang['firstname']}</label>
						<input type=\"text\" name=\"firstname\" value=\"{$account['firstname']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['lastname']}</label>
						<input type=\"text\" name=\"lastname\" value=\"{$account['lastname']}\" />
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
	
	if( !is_array($account['redirection']) && $account['redirection'] )
		$account['redirection'] = array($account['redirection']);
	
	if( $account['redirection'] )
	{
		foreach( $account['redirection'] as $r )
		{
			$content .= "
				<tr>
					<td>{$r}</td>
					<td align=\"center\">
						<a href=\"/account/del_redirection_action?redirection={$r}&domain={$_SESSION['LOGIN_ACCOUNT']['DOMAIN']}&id={$_SESSION['LOGIN_ACCOUNT']['ID']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
		}
	}
	
	$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/account/add_redirection?id={$_SESSION['LOGIN_ACCOUNT']['ID']}&domain={$_SESSION['LOGIN_ACCOUNT']['DOMAIN']}\">{$lang['add_redir']}</a>
			<br /><br />
			<h2>{$lang['alternates']}</h2>
			<table>
				<tr>
					<th>{$lang['email']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";
	
	if( !is_array($account['alternate']) && $account['alternate'] )
		$account['alternate'] = array($account['alternate']);
	
	if( $account['alternate'] )
	{
		foreach( $account['alternate'] as $a )
		{
			$content .= "
				<tr>
					<td>{$a}</td>
					<td align=\"center\">
						<a href=\"/account/del_alternate_action?alternate={$a}&domain={$_SESSION['LOGIN_ACCOUNT']['DOMAIN']}&id={$_SESSION['LOGIN_ACCOUNT']['ID']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
		}
	}
	
	$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/account/add_alternate?id={$_SESSION['LOGIN_ACCOUNT']['ID']}&domain={$_SESSION['LOGIN_ACCOUNT']['DOMAIN']}\">{$lang['add_alt']}</a>
			<br /><br />
			<h2>{$lang['groups']}</h2>
			<table>
				<tr>
					<th>{$lang['group']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";

	if( $account['groups'] )
	{
		foreach( $account['groups'] as $g )
		{
			$content .= "
				<tr>
					<td>{$g['name']}</td>
					<td align=\"center\"></td>
				</tr>";
		}
	}
	
	$content .= "		
			</table>
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
