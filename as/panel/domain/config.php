<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('id'=>$_GET['id']));
$domain = $domain[0];

if( is_array($domain['aRecord']) )
        $domain['aRecord'] = $domain['aRecord'][0];

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} :: <i>{$domain['hostname']}</i></h2>
			<p class=\"large\">{$lang['intro']}</p>
			<br />
			<div style=\"float: left;\">
				<h3>{$lang['config']}</h3>
				<br />
	";

if( security::hasGrant('SELF_DOMAIN_UPDATE') )
	$disabled = '';
else
	$disabled = 'disabled';

$content .= "
				<form action=\"/panel/domain/config_action\" method=\"post\" class=\"mainForm\">
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
					<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
					<fieldset>
						<label>{$lang['mx1']}</label>
						<input type=\"text\" value=\"".str_replace('10 ', '', $domain['mxRecord'][0])."\" name=\"mx1\" {$disabled} />
					</fieldset>
					<fieldset>
						<label>{$lang['mx2']}</label>
						<input type=\"text\" value=\"".str_replace('20 ', '', $domain['mxRecord'][1])."\" name=\"mx2\" {$disabled} />
					</fieldset>
					<fieldset>
						<label>{$lang['arecord']}</label>
						<input type=\"text\" value=\"{$domain['aRecord']}\" name=\"domain_arecord\" {$disabled} />
					</fieldset>
					<fieldset>
						<label>{$lang['mailer']}</label>
						<input type=\"checkbox\" value=\"yes\" name=\"mailer\" {$disabled} ".($domain['mailHost']?"checked":"")." />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
					</fieldset>
				</form>
			</div>
			<div style=\"float: left; margin-left: 50px;\">
				<h3>{$lang['aliases']}</h3>
				<br />
				<table>
					<tr>
						<th>{$lang['domain']}</th>
						<th>{$lang['record2']}</th>
						<th>{$lang['type']}</th>
						<th>{$lang['actions']}</th>
					</tr>
";

$aliases = api::send('self/alias/list', array('source'=>$domain['hostname']));

	if( count($aliases) > 0 )
	{
		foreach( $aliases as $a )
		{
				$content .= "
					<tr>
						<td>{$a['hostname']}</td>
						<td>{$a['aRecord']}{$a['cNAMERecord']}</td>
						<td>{$a['type']}</td>
						<td><a href=\"/panel/domain/del_alias_action?id={$a['id']}&source={$domain['hostname']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></td>
					</tr>
				";
		}
	}
	
$content .= "
				</table>
				<br />
				<a class=\"btn\" href=\"/panel/domain/add_alias?domain={$domain['id']}\">{$lang['add_alias']}</a>			
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<h3>{$lang['subdomains']}</h3>
			<br />
";
	
if( security::hasGrant('SELF_SUBDOMAIN_SELECT') )
{
	$subdomains = api::send('self/subdomain/list', array('domain'=>$domain['hostname']));

	$content .= "
			<table>
				<tr>
					<th>{$lang['address']}</th>
					<th>{$lang['record']}</th>
					<th>{$lang['actions']}</th>
				</tr>
	";
	
	if( count($subdomains) > 0 )
	{
		foreach( $subdomains as $s )
		{
			$content .= "
				<tr>
					<td><a href=\"http://{$s['hostname']}\"><strong>{$s['hostname']}</strong></a></td>
					<td>{$s['aRecord']}{$s['cNAMERecord']}</td>
					<td align=\"center\">";

			if( security::hasGrant('SELF_SUBDOMAIN_UPDATE') )
			{
				$content .= "
						<a href=\"/panel/domain/config_subdomain?domain_id={$domain['id']}&domain={$domain['hostname']}&id={$s['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
			}
		
			if( security::hasGrant('SELF_SUBDOMAIN_DELETE') )
			{
				$content .= "
						<a href=\"/panel/domain/del_subdomain_action?id={$s['id']}&domain={$domain['hostname']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
			}
		
			$content .= "
					</td>
				</tr>";
		}
	}
}

	$content .= "
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/domain/add_subdomain?id={$domain['id']}\">{$lang['add']}</a>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
