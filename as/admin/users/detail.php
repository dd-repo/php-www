<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( strlen($_GET['id']) < 1 )
	template::redirect('/admin');

$user = api::send('user/list', array('id'=>$_GET['id']));

if( count($user) == 0 )
	template::redirect('/admin');
$user = $user[0];

$content = "
		<div class=\"admin\">
			<div class=\"top\">
				<div class=\"left\" style=\"width: 700px; padding-top: 5px;\">
					<h1 class=\"dark\">{$lang['title']} : {$user['name']}</h1>
				</div>
				<div class=\"right\" style=\"width: 300px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#user').val('{$user['id']}'); $('#delete').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
						<span style=\"display: block; padding-top: 3px;\">{$lang['delete']}</span>
					</a>
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"width: 700px; float: left;\">
					<h2 class=\"dark\" id=\"sites\">{$lang['apps']}</h2>
					<table>
						<tr>
							<th style=\"width: 60px; text-align: center;\">{$lang['id']}</th>
							<th>{$lang['url']}</th>
							<th>{$lang['size']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";

if( security::hasGrant('APP_SELECT') )
{
	$apps = api::send('app/list', array('user'=>$_GET['id']));
	
	foreach( $apps as $a )
	{		
		$content .= "
						<tr>
							<td style=\"width: 60px; text-align: center;\">{$a['id']}</td>
							<td>{$a['name']}</td>
							<td>{$a['size']} {$lang['mb']}</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"/admin/apps/del_action?user={$_GET['id']}&app={$a['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
	}
}

$content .= "
					</table>
					<br /><br />
					<h2 class=\"dark\" id=\"domains\">{$lang['domains']}</h2>
					<table>
						<tr>
							<th style=\"width: 60px; text-align: center;\">{$lang['id']}</th>
							<th>{$lang['domain']}</th>
							<th>{$lang['arecord']}</th>
							<th>{$lang['target']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('DOMAIN_SELECT') )
{
	$domains = api::send('domain/list', array('user'=>$_GET['id']));
	
	foreach( $domains as $d )
	{		
		$arecord = "";
		if( is_array($d['aRecord']) )
		{
			$i = 1;
			$max = count($d['aRecord']);
			foreach( $d['aRecord'] as $a )
			{
				if( $i == $max )
					$arecord .= "{$a}";
				else
					$arecord .= "{$a}, ";
					
				$i++;
			}
		}
		else
			$arecord = $d['aRecord'];
			
		$content .= "
						<tr>
							<td style=\"width: 60px; text-align: center;\">{$d['id']}</td>
							<td>{$d['hostname']}</td>
							<td>{$arecord}</td>
							<td>".($d['destination']?"{$d['destination']}":"{$d['homeDirectory']}")."</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"/admin/domains/del_action?user={$_GET['id']}&domain={$d['hostname']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
	}
}

$content .= "
					</table>
					<br /><br />
					<h2 class=\"dark\" id=\"domains\">{$lang['accounts']}</h2>
					<table>
						<tr>
							<th style=\"width: 60px; text-align: center;\">{$lang['id']}</th>
							<th>{$lang['name']}</th>
							<th>{$lang['size']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('ACCOUNT_SELECT') )
{
	foreach( $domains as $d )
	{		
		$accounts = api::send('account/list', array('user'=> $user['id'], 'domain'=>$d['hostname']));
	
		foreach( $accounts as $a )
		{
			$content .= "
						<tr>
							<td style=\"width: 60px; text-align: center;\">{$a['id']}</td>
							<td>{$a['mail']}</td>
							<td>{$a['size']} {$lang['mb']}</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"/admin/account/del_action?user={$_GET['id']}&domain={$d['hostname']}&account={$a['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
		}
	}
}

$content .= "
					</table>
					<br /><br />		
					<h2 class=\"dark\" id=\"databases\">{$lang['services']}</h2>
					<table>
						<tr>
							<th>{$lang['type']}</th>
							<th>{$lang['service']}</th>
							<th>{$lang['size']}</th>
							<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";
		
if( security::hasGrant('SERVICE_SELECT') )
{
	$services = api::send('service/list', array('user'=>$_GET['id']));
	
	foreach( $services as $s )
	{		
		$content .= "
						<tr>
							<td>{$s['vendor']}</td>
							<td>{$s['name']}-master</td>
							<td>{$s['size']} {$lang['mb']}</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"/admin/services/del_action?user={$_GET['id']}&service={$s['name']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>";
		if( count($s['branches']) > 0 )
		{
			foreach( $s['branches'] as $b )
			{
				$content .= "
						<tr>
							<td>{$s['vendor']}</td>
							<td>{$s['name']}-{$b['branch_name']}</td>
							<td>{$b['size']} {$lang['mb']}</td>
							<td style=\"width: 50px; text-align: center;\">
								<a href=\"/admin/services/del_action?user={$_GET['id']}&service={$s['name']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>						
						
				";
			}
		}
	}
}

$content .= "
					</table>
					<br /><br />					
					<div style=\"float: left; width: 300px; padding-top: 5px;\">
						<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"tokens\">{$lang['tokens']}</h2>
					</div>
					<div style=\"float: right; width: 200px;\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#user3').val('{$user['id']}'); $('#newtoken').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
						</a>
					</div>
					<div class=\"clear\"></div>
					<br />
					<table>
						<tr>
							<th>{$lang['tokenname']}</th>
							<th>{$lang['tokenvalue']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>
	";

if( security::hasGrant('TOKEN_SELECT') )
{
	$tokens = api::send('token/list', array('user'=>$_GET['id']));
	
	foreach( $tokens as $t )
	{
		$content .= "
					<tr>
						<td>{$t['name']}</td>
						<td>{$t['token']}</td>
						<td style=\"width: 100px; text-align: center;\">
		";
		
		if( security::hasGrant('TOKEN_UPDATE') )
		{
			$content .= "
							<a href=\"/admin/tokens/detail?user={$_GET['id']}&token={$t['token']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"{$lang['update']}\" /></a>";
		}
		
		if( security::hasGrant('TOKEN_DELETE') )
		{
			$content .= "
							<a href=\"/admin/tokens/del_action?user={$_GET['id']}&token={$t['token']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"{$lang['delete']}\" /></a>";
		}
		
		$content .= "
						</td>
					</tr>";
	}

	$content .= "
				</table>";
}

$content .= "<br /><br />";

if( security::hasGrant('QUOTA_USER_SELECT') )
{
	$userquotas = api::send('quota/user/list', array('user'=>$_GET['id']));

	$content .= "
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h2 class=\"dark\" style=\"padding-top: 7px;\" id=\"tokens\">{$lang['quotas']} (".date($lang['dateformat'], $user['last']).")</h2>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"/admin/quotas/refresh_action?id={$user['id']}\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/refresh-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th style=\"width: 100px;\">{$lang['quotaname']}</th>
						<th>{$lang['quotavalue']}</th>
						<th style=\"width: 50px; text-align: center;\">{$lang['actions']}</th>
					</tr>
						";
	
	$disabled = array('add'=>'', 'del'=>'', 'set'=>'');
	if( !security::hasGrant('QUOTA_USER_INSERT') )
		$disabled['add'] = 'disabled';
	if( security::hasGrant('QUOTA_USER_DELETE') )
		$disabled['del'] = 'disabled';
	if( security::hasGrant('QUOTA_USER_UPDATE') )
		$disabled['set'] = 'disabled';

	foreach( $userquotas as $u )
	{
		if( $u['max'] != 0 )
			$percent = $u['used']*100/$u['max'];
		
		if( $percent > 100 )
			$percent = 100;
			
		$content .= "
					<tr>
						<td>{$u['name']}</td>
						<td style=\"width: 300px;\">
							<div class=\"fillgraph\" style=\"margin-top: 10px;\">
								<small style=\"width: {$percent}%;\"></small>
							</div>
							<span class=\"quota\"><span style='font-weight: bold;'>{$u['used']}</span> {$lang['of']} {$u['max']}</span>
						</td>
						<td style=\"width: 50px; text-align: center;\">
							<a href=\"#\" onclick=\"$('#user2').val('{$user['id']}'); $('#quota').val('{$u['name']}'); $('#max').val('{$u['max']}'); $('#quotachange').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"{$lang['update']}\" /></a>
						</td>
					</tr>
		";
	}
	
	$content .= "
				</table>
				<br />
	";
}

$content .= "
			</div>
			<div style=\"width: 350px; float: right;\">
			";


if( security::hasGrant('USER_SELECT') )
{
	$content .= "			
				<h2 class=\"dark\">{$lang['infos']}</h2>
				<form action=\"/admin/users/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$user['id']}\" />
					<fieldset>
						<input style=\"width: 300px;\" type=\"password\" name=\"pass\" />
						<span class=\"help-block\">{$lang['pass_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"password\" name=\"confirm\" />
						<span class=\"help-block\">{$lang['confirm_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"date\" value=\"".date($lang['dateformat'], $user['date'])."\" disabled />
						<span class=\"help-block\">{$lang['date_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"email\" value=\"{$user['email']}\" />
						<span class=\"help-block\">{$lang['email_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"firstname\" value=\"{$user['firstname']}\" />
						<span class=\"help-block\">{$lang['firstname_help']}</span>
					</fieldset>
					<fieldset>
						<input style=\"width: 300px;\" type=\"text\" name=\"lastname\" value=\"{$user['lastname']}\" />
						<span class=\"help-block\">{$lang['lastname_help']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>";
}

$content .= "
				<br />
";

if( security::hasGrant('GROUP_USER_SELECT') )
{
	$usergroups = api::send('group/user/list', array('user'=>$_GET['id']));
	if( security::hasGrant('GROUP_SELECT') )
		$groups = api::send('group/list');
	else
		$groups = $usergroups;

	$content .= "
					<h2 class=\"dark\">{$lang['groups']}</h2>
					<form action=\"/admin/users/join_action\" method=\"post\">
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
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
				</form>";
}

$content .= "
			</div>
			<div class=\"clear\"></div><br /><br />
			<h2 class=\"dark\">{$lang['sizes']}</h2>
			<table>
				<tr>
					<th style=\"text-align: center; width: 40px;\">#</th>
					<th>{$lang['name']}</th>
					<th>{$lang['type']}</th>
					<th>{$lang['path']}</th>
					<th>{$lang['size']}</th>
				</tr>
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/ftp.png\" /></td>
					<td>{$lang['cloud']}</td>
					<td>{$lang['cloud_type']}</td>
					<td>/dns/in/olympe/Users/{$user['name']}</td>
					<td><span style=\"font-weight: bold;\">{$user['size']} {$lang['mb']}</span></td>
				</tr>
";

foreach( $apps as $a )
{
	$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/app.png\" /></td>
					<td>{$a['name']}</td>
					<td>{$lang['app']}</td>
					<td>{$a['homeDirectory']}</td>
					<td><span style=\"font-weight: bold;\">{$a['size']} {$lang['mb']}</span></td>
				</tr>
	";
}

foreach( $services as $s )
{
	$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/service.png\" /></td>
					<td>{$s['name']}</td>
					<td>{$lang['service2']} {$s['type']}</td>
					<td>/services/{$s['name']}-master</td>
					<td><span style=\"font-weight: bold;\">{$s['size']} {$lang['mb']}</span></td>
				</tr>
	";
	if( count($s['branches']) > 0 )
	{
		foreach( $s['branches'] as $b )
		{
			$content .= "
					<tr>
						<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/service.png\" /></td>
						<td>{$s['description']}</td>
						<td>{$lang['service']} {$s['vendor']}</td>
						<td>/services/{$s['name']}-{$b['branch_name']}</td>
						<td><span style=\"font-weight: bold;\">{$b['size']} {$lang['mb']}</span></td>
					</tr>						
					
			";
		}
	}
}

foreach( $domains as $d )
{
	$users = api::send('account/list', array('user'=> $user['id'], 'domain'=>$d['hostname']));
	
	foreach( $users as $u )
	{
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/user.png\" /></td>
					<td>{$u['mail']}</td>
					<td>{$lang['account']}</td>
					<td>{$u['homeDirectory']}</td>
					<td><span style=\"font-weight: bold;\">{$u['size']} {$lang['mb']}</span></td>
				</tr>
		";
	}
}

$content .= "
			</table>
			<br /><br />
			<div class=\"comments\">
				<h1 class=\"dark thin\">{$lang['comments']}</h1>
				<br />
				<div id=\"disqus_thread\"></div>
				<script type=\"text/javascript\">
					/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
					var disqus_developer = 0; // developer mode
					var disqus_shortname = 'anotherserviceadmin'; // required: replace example with your forum shortname
					var disqus_identifier = 'User - {$user['name']}';
					var disqus_url = 'https://www.anotherservice.com/admin/users/detail?id={$user['id']}';
					/* * * DON'T EDIT BELOW THIS LINE * * */
					(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = 'https://' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();
				</script>
			</div>
		</div>
		<div id=\"quotachange\" class=\"floatingdialog\">
			<br />
			<h3 class=\"center\">{$lang['quota']}</h3>
			<p style=\"text-align: center;\">{$lang['quota_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/users/set_quota_action\" method=\"post\" class=\"center\">
					<input id=\"user2\" type=\"hidden\" value=\"\" name=\"user\" />
					<input id=\"quota\" type=\"hidden\" value=\"\" name=\"quota\" />
					<fieldset>
						<input id=\"max\" type=\"text\" name=\"max\" value=\"\" />
						<span class=\"help-block\">{$lang['max_help']}</span>
					</fieldset>
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"delete\" class=\"floatingdialog\">
			<h3 class=\"center\">{$lang['delete']}</h3>
			<p style=\"text-align: center;\">{$lang['delete_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/users/del_action\" method=\"post\" class=\"center\">
					<input id=\"user\" type=\"hidden\" value=\"\" name=\"user\" />
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['delete_now']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div id=\"newtoken\" class=\"floatingdialog\">
			<br />
			<h3 class=\"center\">{$lang['newtoken']}</h3>
			<p style=\"text-align: center;\">{$lang['newtoken_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/admin/tokens/add_action\" method=\"post\" class=\"center\">
					<input id=\"user3\" type=\"hidden\" value=\"\" name=\"user\" />
					<fieldset>
						<input type=\"text\" name=\"name\" />
						<span class=\"help-block\">{$lang['tokenname_help']}</span>
					</fieldset>
					<fieldset>
						<select name=\"type\">
							<option value=\"user\">{$lang['user']}</option>
							<option value=\"admin\">{$lang['admin']}</option>
							<option value=\"blank\">{$lang['blank']}</option>
						</select>
						<span class=\"help-block\">{$lang['tokentype_help']}</span>
					</fieldset>
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['create']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<script>
			newFlexibleDialog('delete', 550);
			newFlexibleDialog('quotachange', 550);
			newFlexibleDialog('newtoken', 550);
		</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>