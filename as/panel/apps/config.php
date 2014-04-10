<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 700px;\">
				<h1 class=\"dark\">{$lang['title']} {$app['name']}</h1>
			</div>
			<div class=\"right\" style=\"width: 300px;\">
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<div style=\"float: left; width: 530px;\">
				<h3 class=\"colored\">{$lang['change_desc']}</h3>
				<form action=\"/panel/apps/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
					<fieldset>
						<input type=\"text\" name=\"tag\" value=\"{$app['tag']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['help_desc']}</span>
					</fieldset>
					<fieldset>
						<input type=\"text\" name=\"access\" value=\"ssh://git.as/~".security::get('USER')."/{$app['name']}.git\" style=\"width: 400px;\" disabled />
						<span class=\"help-block\">{$lang['help_access']}</span>
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
						<th>{$lang['actions']}</th>
					</tr>
";

if( $app['apps'] )
{
	foreach( $app['apps'] as $a )
	{
		$language = explode('-', $a['name']);
		$language = $language[0];
		
		$content .= "
					<tr>
						<td><img style=\"float: left; margin-right: 10px; width: 50px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" /> <span style=\"display: block; padding-top: 15px;\">{$a['name']}</a></td>
						<td align=\"center\">
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
						<th>{$lang['actions']}</th>
					</tr>
";

if( $app['users'] )
{
	foreach( $app['users'] as $u )
	{
		$content .= "
					<tr>
						<td>{$u['name']}</td>
						<td align=\"center\">
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
						<th>{$lang['actions']}</th>
					</tr>
";

if( $app['groups'] )
{
	foreach( $app['groups'] as $g )
	{
		$content .= "
					<tr>
						<td>{$g['name']}</td>
						<td align=\"center\">
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
			<table>
				<tr>
					<th>{$lang['app']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$apps = api::send('self/app/list');

if( count($apps) > 0 )
{
	foreach($apps as $a)
	{
		$content .= "
				<tr>
					<td>{$a['tag']} ({$a['name']})</td>
					<td align=\"center\">
						<a href=\"/panel/apps/permit_action?id={$_GET['id']}&member={$a['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
					</td>
				</tr>
		";
	}
}
		
$content .= "
			</table>
	</div>
	<div id=\"newuser\" class=\"floatingdialog\" style=\"padding: 30px;\">
		<h3 class=\"center\">{$lang['add_users']}</h3>
		<p style=\"text-align: center;\">{$lang['add_users_text']}</p>
		<table>
			<tr>
				<th>{$lang['user']}</th>
				<th>{$lang['actions']}</th>
			</tr>
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
			<tr>
				<td>{$u['name']}</td>
				<td style=\"width: 35px; text-align: center;\">
					<a href=\"/panel/apps/permit_action?id={$_GET['id']}&member={$u['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
				</td>
			</tr>
				";
			}
		}
	}
}
		
$content .= "
		</table>
	</div>
	<div id=\"newgroup\" class=\"floatingdialog\" style=\"padding: 30px;\">
		<h3 class=\"center\">{$lang['add_groups']}</h3>
		<p style=\"text-align: center;\">{$lang['add_groups_text']}</p>
		<br />
		<table>
			<tr>
				<th>{$lang['group']}</th>
				<th>{$lang['actions']}</th>
			</tr>
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
			<tr>
				<td>{$g['name']}</td>
				<td align=\"center\">
					<a href=\"/panel/apps/permit_action?id={$_GET['id']}&member={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
				</td>
			</tr>
				";
			}
		}
	}
}
		
$content .= "
		</table>
	</div>
	<script>
		newDialog('newapp', 550, 500);
		newDialog('newuser', 550, 500);
		newDialog('newgroup', 550, 500);
	</script>
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
