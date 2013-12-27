<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$user = api::send('user/list', array('id'=>$_GET['id']));
if( count($user) == 0 )
	template::redirect('/admin/user');
$user = $user[0];
$address = json_decode($user['address'], true);

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} : {$user['name']}</h2>
			<br />
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<br />
				<form action=\"/admin/user/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
					<fieldset>
						<label>{$lang['firstname']}</label>
						<input type=\"text\" name=\"firstname\" value=\"{$user['firstname']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['lastname']}</label>
						<input type=\"text\" name=\"lastname\" value=\"{$user['lastname']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['email']}</label>
						<input type=\"text\" name=\"email\" value=\"{$user['email']}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['groups']}</h3>
";

if( security::hasGrant('GROUP_USER_SELECT') )
{
	$usergroups = api::send('group/user/list', array('user'=>$_GET['id']));
	if( security::hasGrant('GROUP_SELECT') )
		$groups = api::send('group/list');
	else
		$groups = $usergroups;

	$content .= "
				<br />
				<form action=\"/admin/user/join_action\" method=\"post\">
					<table>
						<tr>
							<th>{$lang['groupname']}</th>
							<th>{$lang['member']}</th>
						</tr>
	";

	if( security::hasGrant(array('GROUP_USER_INSERT','GROUP_USER_DELETE')) )
		$disabled = '';
	else
		$disabled = 'disabled';

	foreach( $groups as $g )
	{
		$checked = '';
		foreach( $usergroups as $g2 )
		{
			if( $g['id'] == $g2['id'] )
			{
				$checked = 'checked';
				break;
			}
		}

		$content .= "
						<tr>
							<td>{$g['name']}</td>
							<td align=\"center\">
								<input type=\"checkbox\" name=\"group[]\" value=\"{$g['id']}\" {$disabled} {$checked} />
							</td>
						</tr>";
	}

	$content .= "
					</table>
					<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
					<br />
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled}/>
				</form>";
}

$content .= "
			</div>
			<div class=\"clearfix\"></div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['billing']}</h3>
				<br />
				<form action=\"/admin/user/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
					<fieldset>
						<label>{$lang['company']}</label>
						<input type=\"text\" name=\"company\" value=\"{$address['company']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['street']}</label>
						<input type=\"text\" name=\"street\" value=\"{$address['street']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['code']}</label>
						<input type=\"text\" name=\"code\" value=\"{$address['code']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['city']}</label>
						<input type=\"text\" name=\"city\" value=\"{$address['city']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['country']}</label>
						<input type=\"text\" name=\"country\" value=\"{$address['country']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['iban']}</label>
						<input type=\"text\" name=\"iban\" value=\"{$user['iban']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['bic']}</label>
						<input type=\"text\" name=\"bic\" value=\"{$user['bic']}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['quotas']}</h3>
			";

if( security::hasGrant('QUOTA_USER_SELECT') )
{
	$userquotas = api::send('quota/user/list', array('user'=>$_GET['id']));
	if( security::hasGrant('QUOTA_SELECT') )
		$quotas = api::send('quota/list');
	else
		$quotas = $userquotas;

	$content .= "
				<br />
				<table>
					<tr>
						<th>{$lang['quotaname']}</th>
						<th>{$lang['quotavalue']}</th>
						<th>{$lang['actions']}</th>
					</tr>
	";
	
	$disabled = array('add'=>'', 'del'=>'', 'set'=>'');
	if( !security::hasGrant('QUOTA_USER_INSERT') )
		$disabled['add'] = 'disabled';
	if( security::hasGrant('QUOTA_USER_DELETE') )
		$disabled['del'] = 'disabled';
	if( security::hasGrant('QUOTA_USER_UPDATE') )
		$disabled['set'] = 'disabled';

	foreach( $quotas as $q )
	{
		$current = null;
		foreach( $userquotas as $uq )
		{
			if( $uq['id'] == $q['id'] )
			{
				$current = $uq;
				break;
			}
		}

		$content .= "
					<tr>
						<td>{$q['name']}</td>
						<td>".($current==null?0:$current['used'])." / ".($current==null?0:$current['max'])."</td>
						<td align=\"center\">";
		
		if( $current == null )
		{
			$content .= "
							<a href=\"/admin/user/add_quota?id={$_GET['id']}&qid={$q['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		else
		{
			$content .= "
							<a href=\"/admin/user/set_quota?id={$_GET['id']}&qid={$q['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		$content .= "
						</td>
					</tr>";
	}
	
	$content .= "
				</table>
	";
}

$content .= "
			</div>
			<div class=\"clearfix\"></div>
			<h3 class=\"colored\">{$lang['tokens']}</h3>
";

if( security::hasGrant('TOKEN_SELECT') )
{
	$tokens = api::send('token/list', array('user'=>$_GET['id']));
	
	$content .= "
				<br />
				<table>
					<tr>
						<th>{$lang['tokenname']}</th>
						<th>{$lang['tokenvalue']}</th>
						<th>{$lang['actions']}</th>
					</tr>	
	";

	foreach( $tokens as $t )
	{
		$content .= "
					<tr>
						<td>{$t['name']}</td>
						<td>{$t['token']}</td>
						<td align=\"center\">";
		
		if( security::hasGrant('TOKEN_UPDATE') )
		{
			$content .= "
							<a href=\"/admin/token/detail?user={$_GET['id']}&token={$t['token']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		if( security::hasGrant('TOKEN_DELETE') )
		{
			$content .= "
							<a href=\"/admin/token/del_action?user={$_GET['id']}&token={$t['token']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
						</td>
					</tr>";
	}

	$content .= "
				</table>
	";
}

if( security::hasGrant('TOKEN_INSERT') )
{
	$content .= "
				<br />
				<a class=\"btn\" href=\"/admin/user/promote_action?user={$_GET['id']}\">{$lang['promote']}</a>
	";
}

$content .= "
			<br /><br />
			<h3 class=\"colored\">{$lang['apps']}</h3>			
";

if( security::hasGrant('APP_SELECT') )
{
	$apps = api::send('app/list', array('user'=>$_GET['id']));
	
	$content .= "
				<br />
				<table>
					<tr>
						<th>{$lang['app']}</th>
						<th>{$lang['uris']}</th>
						<th>{$lang['memory']}</th>
						<th>{$lang['size']}</th>
						<th style=\"width: 80px;\">{$lang['status']}</th>
						<th>{$lang['actions']}</th>
					</tr>
	";
	
	foreach( $apps as $a )
	{
		$language = explode('-', $a['name']);
		$language = $language[0];

		$running = false;
		$memory = 0;
		$disk = 0;
		foreach( $a['branches'] as $key => $value )
		{
			foreach( $value['instances'] as $i )
			{
				if( $i['state'] == 'RUNNING' )
					$running = true;
				$memory = $memory+$i['memory']['quota'];
				$disk = $disk+$i['disk']['quota'];
			}
			$instances = count($value['instances'])+$instances;
			$memory = round($memory/1024/1024)+$memory;
		}
		
		$content .= "
					<tr>
						<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" alt=\"\" /><a href=\"/panel/app/show?id={$a['id']}\"><strong>{$a['name']}</strong></a></td>
						<td>";
	if( $a['branches']['urls'] )
	{
		foreach( $a['branches']['urls'] as $url )
			$content .= "				<a href=\"http://{$url}\">{$url}</a><br />";
	}
		
		$content .= "
						</td>
						<td><span class=\"lightlarge\">{$memory}Mo</span><br /><i>{$instances} {$lang['instances']}</i></td>
						<td><span class=\"large\">{$a['size']}Mo</span></td>
						<td>".($running?"<div class=\"state running\"><div class=\"state-content\">{$lang['running']}</div></div>":"<div class=\"state stopped\"><div class=\"state-content\">{$lang['stopped']}")."</div></div></td>					
						<td align=\"center\">";
		
		if( security::hasGrant('APP_UPDATE') )
		{
			$content .= "
							<a href=\"/admin/app/config?id={$a['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		if( security::hasGrant('APP_DELETE') )
		{
			$content .= "
							<a href=\"/admin/app/del_action?id={$a['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
						</td>
					</tr>";
	}

	$content .= "
				</table>
	";
}

$content .= "
			<br />
			<h3 class=\"colored\">{$lang['domains']}</h3>";
				
if( security::hasGrant('DOMAIN_SELECT') )
{
	$domains = api::send('domain/list', array('user'=>$_GET['id']));
	
	$content .= "
			<br />
			<table>
				<tr>
					<th>{$lang['domain']}</th>
					<th>{$lang['arecord']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";

	foreach( $domains as $d )
	{
		$content .= "
				<tr>
					<td>{$d['hostname']}</td>
					<td>{$d['aRecord']}</td>
					<td align=\"center\">";
		
		if( security::hasGrant('DOMAIN_UPDATE') )
		{
			$content .= "
						<a href=\"/admin/domain/config?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		if( security::hasGrant('DOMAIN_DELETE') )
		{
			$content .= "
						<a href=\"/admin/domain/del_action?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
					</td>						
				</tr>";
	}

	$content .= "			
			</table>
	";
}

$content .= "
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>