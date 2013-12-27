<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('domain'=>$_GET['domain']));
$domain = $domain[0];

$me = api::send('self/whoami', array('quota'=>true));
$me = $me[0];

foreach( $me['quotas'] as $q )
{
	switch( $q['name'] )
	{
		case 'MEMORY':
			$mem['used'] = $q['used'];
			$mem['max'] = $q['max'];
		break;
		case 'DISK':
			$disk['used'] = $q['used'];
			$disk['max'] = $q['max'];
		break;
		case 'SERVICES':
			$services['used'] = $q['used'];
			$services['max'] = $q['max'];
		break;
		case 'APPS':
			$appq['used'] = $q['used'];
			$appq['max'] = $q['max'];
		break;
	}
}

$disk_left = 260-round($disk['used']*260/$disk['max']);

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"float: left; width: 500px;\">
				<h3>{$lang['disk']}</h3>
				<div class=\"ui-meter-holder\">
					<div class=\"ui-meter\">
						<div class=\"after-fill fill\" style=\"z-index: 9; display: none;\"></div>
						<div class=\"before-fill fill\" style=\"z-index: 10; right: {$disk_left}px;\"></div>
						<div class=\"base-fill fill\" style=\"z-index: 20; display: none;\"></div>
					</div>
				</div>
				<div class=\"details\">
					<span class=\"usage\">{$disk['used']}Mo</span> / <span class=\"limit\">{$disk['max']}Mo</span>
				</div>
				<div class=\"clearfix\"></div>
			</div>
			<div style=\"padding-top: 14px;\">
				<a class=\"btn\" href=\"/panel/storage\">{$lang['more']}</a>
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<h2>{$lang['users']}</h2>
			<table>
				<tr>
					<th>{$lang['email']}</th>
					<th>{$lang['firstname']}</th>
					<th>{$lang['lastname']}</th>
					<th>{$lang['membership']}</th>
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
					<td>";
		if( count($u['groups']) > 0 )
		{
			$i = 1;
			$count = count($u['groups']);
			foreach($u['groups'] as $g )
			{
				if( $i == $count )
					$content .= "{$g['name']}";
				else
					$content .= "{$g['name']}, ";
				$i++;
			}
		}
	
		$content .= "</td>
					<td><span class=\"large\">{$u['size']}Mo</span></td>
					<td align=\"center\">";
				
		if( security::hasGrant('SELF_ACCOUNT_UPDATE') )
		{
			$content .= "
										<a href=\"/panel/user/config?domain={$domain['hostname']}&id={$u['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
				
		if( security::hasGrant('SELF_ACCOUNT_DELETE') )
		{
			$content .= "
										<a href=\"/panel/user/del_action?id={$u['id']}&domain={$domain['hostname']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
				
		$content .= "
					</td>
				</tr>
		";
	}
}
		
$content .= "
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/user/add?domain={$domain['hostname']}\">{$lang['add']}</a>
			<br /><br />
			<h2>{$lang['groups']}</h2>
			<table>
				<tr>
					<th>{$lang['email']}</th>
					<th>{$lang['firstname']}</th>
					<th>{$lang['lastname']}</th>
					<th>{$lang['membership']}</th>
					<th>{$lang['size']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

$groups = api::send('self/team/list', array('domain'=>$domain['hostname']));

if( count($groups) > 0 )
{
	foreach($groups as $g)
	{
		$content .= "
				<tr>
					<td>{$g['mail']}</td>
					<td>{$g['firstname']}</td>
					<td>{$g['lastname']}</td>
					<td>";
		if( count($g['groups']) > 0 )
		{
			$i = 1;
			$count = count($g['groups']);
			foreach($g['groups'] as $gg )
			{
				if( $i == $count )
					$content .= "{$gg['name']}";
				else
					$content .= "{$gg['name']}, ";
				$i++;
			}
		}
	
		$content .= "</td>
					<td><span class=\"large\">{$g['size']}Mo</span></td>
					<td align=\"center\">";
				
		if( security::hasGrant('SELF_ACCOUNT_UPDATE') )
		{
			$content .= "
										<a href=\"/panel/group/config?domain={$domain['hostname']}&id={$g['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		if( security::hasGrant('SELF_ACCOUNT_DELETE') )
		{
			$content .= "
										<a href=\"/panel/group/del_action?id={$g['id']}&domain={$domain['hostname']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
					</td>
				</tr>
		";
	}
}
		
$content .= "
			</table><br />
			<a class=\"btn\" href=\"/panel/group/add?domain={$domain['hostname']}\">{$lang['add_group']}</a>
			<br /><br />						
		</div>
	</div>		
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
