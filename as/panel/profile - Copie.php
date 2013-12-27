<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content .= "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"width: 48%; float: left;\">";
			
if( security::hasGrant('SELF_SELECT') )
{
	$userinfo = api::send('self/whoami');
	$userinfo = $userinfo[0];
	
	if( security::hasGrant('SELF_UPDATE') )
		$disabled = '';
	else
		$disabled = 'disabled';

	if( security::hasGrant('SELF_UPDATE') )
	{
		$content .= "
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<br />
				<form action=\"/panel/profile/action_update\" method=\"post\">
					<fieldset>
						<label>{$lang['password']}</label>
						<input type=\"password\" name=\"pass\" />
					</fieldset>
					<fieldset>
						<label>{$lang['password2']}</label>
						<input type=\"password\" name=\"confirm\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>";
	}
	
	$content .= "
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<br />
				<form action=\"/panel/profile/action_update\" method=\"post\">
					<fieldset>
						<label>{$lang['firstname']}</label>
						<input type=\"text\" name=\"firstname\" value=\"{$userinfo['firstname']}\" {$disabled} />
					</fieldset>
					<fieldset>
						<label>{$lang['lastname']}</label>
						<input type=\"text\" name=\"lastname\" value=\"{$userinfo['lastname']}\" {$disabled} />
					</fieldset>
					<fieldset>
						<label>{$lang['email']}</label>
						<input type=\"text\" name=\"email\" value=\"{$userinfo['email']}\" {$disabled} />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
					</fieldset>
				</form>
			";
}

$content .= "
			</div>
			<br />
			<h2>{$lang['bills']}</h2>
			<br />
			<table>
				<tr>
					<th>{$lang['id']}</th>
					<th>{$lang['date']}</th>
					<th>{$lang['total']}</th>
					<th>{$lang['status']}</th>
				</tr>
";

if( count($bills) > 0 )
{
	foreach( $bills as $b )
	{
		$content .= "
				<tr>
					<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$s['vendor']}.png\" alt=\"\" /><strong>{$s['name']}</strong></td>
					<td>{$s['vendor']}</td>
					<td>{$s['version']}</td>
					<td align=\"center\">
		";
		
		if( security::hasGrant('SELF_SERVICE_DELETE') )
		{
			$content .= "
									<a href=\"/panel/service/del_action?name={$s['name']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
								</td>
							</tr>
		";
	}
}

$content .= "
				</tr>
			</table>
			<div class=\"clearfix\"></div>
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
