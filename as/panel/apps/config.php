<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$permissions = array();

if( count($app['permissions']) > 0 )
{
	foreach( $app['permissions'] as $p )
		$permissions[$p['permission_object']] = $p['permission_right'];
}

if( is_array($app['email']) )
{
	$i = 1;
	$count = count($app['email']);
	foreach( $app['email'] as $e )
	{
			$email .= $e;
			if( $i != $count )
				$email .= ',';
			
		$i++;
	}
}
else
	$email = $app['email'];
	
$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px; width: 700px;\">
				<h1 class=\"dark\">{$lang['title']} {$app['name']}</h1>
			</div>
			<div class=\"right\" style=\"text-align: right; float: right;\">
				<a class=\"action push\" href=\"#\" onclick=\"$('#push').dialog('open'); return false;\">
					{$lang['push']}
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<div style=\"float: left; width: 530px;\">
				<h3 class=\"colored\">{$lang['change_desc']}</h3>
				<form action=\"/panel/apps/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
					<fieldset>
						<input type=\"text\" name=\"desc\" value=\"{$app['tag']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['help_desc']}</span>
					</fieldset>
					<fieldset>
						<input type=\"text\" name=\"email\" value=\"{$email}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['help_mail']}</span>
					</fieldset>
					<fieldset>	
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"float: right; width: 530px;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h3 class=\"colored\">{$lang['apps']}</h3>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#newapp').dialog('open');\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['permit_app']}</span>
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th>{$lang['app']}</th>
						<th>{$lang['permissions']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
";

if( $app['apps'] )
{
	foreach( $app['apps'] as $a )
	{
		$language = explode('-', $a['name']);
		$language = $language[0];
		
		if( !$permissions[$a['id']] )
			$permissions[$a['id']] = 'rwx';
		
		$content .= "
					<tr>
						<td><img style=\"float: left; margin-right: 10px; width: 50px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" /> <span style=\"display: block; padding-top: 15px;\">{$a['name']}</a></td>
						<td>".$lang['perm_' . $permissions[$a['id']]]."</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"/panel/apps/deny_action?id={$_GET['id']}&member={$a['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>";
	}
}
	
$content .= "		
				</table>
			</div>
			<div class=\"clear\"></div><br /><br />
			<div style=\"float: left; width: 530px;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h3 class=\"colored\">{$lang['users']}</h3>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#newuser').dialog('open');\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['permit_user']}</span>
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th>{$lang['user']}</th>
						<th>{$lang['permissions']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
";

if( $app['users'] )
{
	foreach( $app['users'] as $u )
	{
		if( !$permissions[$u['id']] )
			$permissions[$u['id']] = 'rwx';
			
		$content .= "
					<tr>
						<td>{$u['name']}</td>
						<td>".$lang['perm_' . $permissions[$u['id']]]."</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"/panel/apps/deny_action?id={$_GET['id']}&member={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>";
	}
}
	
$content .= "		
				</table>
			</div>
			<div style=\"float: right; width: 530px;\">
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h3 class=\"colored\">{$lang['groups']}</h3>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#newgroup').dialog('open');\" style=\"wwidth: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['permit_group']}</span>
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th>{$lang['group']}</th>
						<th>{$lang['permissions']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
";

if( $app['groups'] )
{
	foreach( $app['groups'] as $g )
	{
		if( !$permissions[$g['id']] )
			$permissions[$g['id']] = 'rwx';
			
		$content .= "
					<tr>
						<td>{$g['name']}</td>
						<td>".$lang['perm_' . $permissions[$g['id']]]."</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"/panel/apps/deny_action?id={$_GET['id']}&member={$g['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>";
	}
}
	
$content .= "		
				</table>
			</div>
			<div class=\"clear\"></div><br />
		</div>
	</div>
	
	<div id=\"newapp\" class=\"floatingdialog\" style=\"padding: 30px;\">
		<h3 class=\"center\">{$lang['add_apps']}</h3>
		<p style=\"text-align: center;\">{$lang['add_apps_text']}</p>
		<div class=\"form-small\">
			<form action=\"/panel/apps/permit_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"".security::encode($_GET['id'])."\" />
				<fieldset>
					<select name=\"member\">
";
$apps = api::send('self/app/list');

if( count($apps) > 0 )
{
	foreach($apps as $a)
	{
		$content .= "
						<option value=\"{$a['id']}\">{$a['tag']} ({$a['name']})</option>";
	}
}

$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_app']}</span>
				</fieldset>
				<fieldset>
					<select name=\"permission\">
						<option value=\"rx\">{$lang['readonly']}</option>
						<option value=\"rwx\">{$lang['readwrite']}</option>
					</select>
					<span class=\"help-block\">{$lang['help_permission']}</span>
				</fieldset>	
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['grant']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"newuser\" class=\"floatingdialog\" style=\"padding: 30px;\">
		<h3 class=\"center\">{$lang['add_users']}</h3>
		<p style=\"text-align: center;\">{$lang['add_users_text']}</p>
		<div class=\"form-small\">
			<form action=\"/panel/apps/permit_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"".security::encode($_GET['id'])."\" />
				<fieldset>
					<select name=\"member\">
";
$domains = api::send('self/domain/list');

if( count($domains) > 0 )
{
	foreach( $domains as $d )
	{
		$users = api::send('self/account/list', array('domain'=>$d['hostname']));
	
		if( count($users) > 0 )
		{
			foreach( $users as $u )
			{
				$content .= "
						<option value=\"{$u['id']}\">{$u['mail']}</option>";
			}
		}
	}
}

$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_user']}</span>
				</fieldset>
				<fieldset>
					<select name=\"permission\">
						<option value=\"rx\">{$lang['readonly']}</option>
						<option value=\"rwx\">{$lang['readwrite']}</option>
					</select>
					<span class=\"help-block\">{$lang['help_permission']}</span>
				</fieldset>	
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['grant']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"newgroup\" class=\"floatingdialog\" style=\"padding: 30px;\">
		<h3 class=\"center\">{$lang['add_groups']}</h3>
		<p style=\"text-align: center;\">{$lang['add_groups_text']}</p>
		<br />
		<div class=\"form-small\">
			<form action=\"/panel/apps/permit_action\" method=\"get\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"".security::encode($_GET['id'])."\" />
				<fieldset>
					<select name=\"member\">
";
$domains = api::send('self/domain/list');

if( count($domains) > 0 )
{
	foreach( $domains as $d )
	{
		$groups = api::send('self/team/list', array('domain'=>$d['hostname']));
	
		if( count($groups) > 0 )
		{
			foreach( $groups as $g )
			{
				$content .= "
						<option value=\"{$g['id']}\">{$g['mail']}</option>";
			}
		}
	}
}

$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_group']}</span>
				</fieldset>
				<fieldset>
					<select name=\"permission\">
						<option value=\"rx\">{$lang['readonly']}</option>
						<option value=\"rwx\">{$lang['readwrite']}</option>
					</select>
					<span class=\"help-block\">{$lang['help_permission']}</span>
				</fieldset>	
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['grant']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"push\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['push_title']}</h3>
		<p style=\"text-align: center;\">{$lang['push_text']}</p>
		<br />
		<h2 class=\"dark\" style=\"text-align: center;\">{$lang['access']}</h2>
		<table>
			<tr>
				<th>{$lang['type']}</th>
				<th>{$lang['infos']}</th>
				<th>{$lang['user']}</th>
				<th>{$lang['port']}</th>
			</tr>
			<tr>
				<td><span class=\"large\">SSH</span></td>
				<td>ssh://git.as/~".security::get('USER')."/{$app['name']}.git</td>
				<td>".security::get('USER')."</td>
				<td>22</td>
			</tr>
		</table>
		<br />
		<h2 class=\"dark\" style=\"text-align: center;\">{$lang['paths']}</h2>
		<table>
			<tr>
				<th>{$lang['type']}</th>
				<th>{$lang['folder']}</th>
			</tr>
			<tr>
				<td>{$lang['git']}</td>
				<td colspan=\"2\">{$app['homeDirectory']}</td>
			</tr>
		</table>
		<br />
	</div>
	<script>
		newFlexibleDialog('newapp', 550);
		newFlexibleDialog('newuser', 550);
		newFlexibleDialog('newgroup', 550);
		newFlexibleDialog('push', 900);
	</script>
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>