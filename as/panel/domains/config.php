<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('id'=>$_GET['id']));
$domain = $domain[0];

if( is_array($domain['aRecord']) )
{
	$i = 1;
	$count = count($domain['aRecord']);
	foreach( $domain['aRecord'] as $a )
	{
			$arecord .= $a;
			if( $i != $count )
				$arecord .= ',';
			
		$i++;
	}
}
else
	$arecord = $domain['aRecord'];

$subdomains = api::send('self/subdomain/list', array('domain'=>$domain['hostname']));
$aliases = api::send('self/alias/list', array('source'=>$domain['hostname']));

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"width: 500px; padding-top: 5px;\"\">
						<h1 class=\"dark\">{$lang['title']} {$domain['hostname']}</h1>
					</div>
					<div class=\"right\">

					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
					<div style=\"float: left; width: 300px;\">
						<h2 style=\"padding-top: 10px;\" class=\"dark\">{$lang['dns']}</h2>
						<form style=\"margin-top: 23px;\" action=\"/panel/domains/config_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$domain['id']}\" />
							<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
							<fieldset>
								<input style=\"width: 250px;\" type=\"text\" value=\"".str_replace('10 ', '', $domain['mxRecord'][0])."\" name=\"mx1\" />
								<span class=\"help-block\">{$lang['mx1']}</span>
							</fieldset>
							<fieldset>
								<input style=\"width: 250px;\" type=\"text\" value=\"".str_replace('20 ', '', $domain['mxRecord'][1])."\" name=\"mx2\" />
								<span class=\"help-block\">{$lang['mx2']}</span>
							</fieldset>
							<fieldset>
								<input style=\"width: 250px;\" type=\"text\" value=\"{$arecord}\" name=\"domain_arecord\" />
								<span class=\"help-block\">{$domain['hostname']}</span>
							</fieldset>
							<fieldset>
								<input type=\"checkbox\" value=\"1\" name=\"domain_mailer\" ".($domain['mailHost']?"checked":"")." /> {$lang['mailer']}
							</fieldset>
							<fieldset>				
								<input type=\"submit\" value=\"{$lang['update']}\" />
							</fieldset>
						</form>					
					</div>
					<div style=\"float: right; width: 700px;\">
						<div style=\"float: left; width: 250px;\">
							<h2 style=\"padding-top: 10px;\" class=\"dark\">{$lang['aliases']}</h2>
						</div>
						<div style=\"float: right; width: 300px;\">
							<a class=\"button classic\" href=\"#\" onclick=\"$('#newalias').dialog('open'); return false;\" style=\"width: 200px; height: 22px; float: right;\">
								<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
								<span style=\"display: block; padding-top: 3px;\">{$lang['add_alias']}</span>
							</a>						
						</div>
						<div class=\"clear\"></div>
						<br />
						<table>
							<tr>
								<th>{$lang['domain']}</th>
								<th>{$lang['record']}</th>
								<th>{$lang['type']}</th>
								<th>{$lang['actions']}</th>
							</tr>";

if( count($aliases) > 0 )
{
	foreach( $aliases as $a )
	{
		$arecord = "";
		if( is_array($a['aRecord']) )
		{
			$i = 1;
			$max = count($a['aRecord']);
			foreach( $a['aRecord'] as $r )
			{
				if( $i == $max )
					$arecord .= "{$r}";
				else
					$arecord .= "{$r}<br />";
				
				$i++;
			}
		}
		else
			$arecord = $a['aRecord'];
			
		$content .= "
							<tr>
								<td>{$a['hostname']}</td>
								<td>{$arecord}</td>
								<td>{$a['type']}</td>
								<td><a href=\"/panel/domains/del_alias_action?id={$a['id']}&source={$domain['hostname']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></td>
							</tr>
				";
	}
}				

$content .= "
						</table>
					</div>
					<div class=\"clear\"></div>
					<br />
					<div class=\"left\">
						<h2 style=\"padding-top: 10px;\" class=\"dark\">{$lang['list']}</h2>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open'); return false;\" style=\"width: 200px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
						</a>
					</div>
					<div class=\"clear\"></div><br />
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
							<td>{$s['hostname']}</td>
							<td>{$s['aRecord']}{$s['cNAMERecord']}</td>
							<td style=\"width: 70px;\">
								<a href=\"#\" onclick=\"$('#record').val('{$s['aRecord']}{$s['cNAMERecord']}'); $('#subdomainid').val('{$s['id']}'); $('#config').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
								<a href=\"/panel/domain/del_subdomain_action?domain={$domain['hostname']}&id={$s['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>
			";
	}
}

$content .= "
					</table>
				</div>
			</div>
			<div id=\"new\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new']}</h3>
				<p style=\"text-align: center;\">{$lang['new_text']}</p>
				<div class=\"form-small\">
					<form action=\"/panel/domains/add_subdomain_action\" method=\"post\" class=\"center\">
						<input type=\"hidden\" name=\"id\" value=\"{$domain['id']}\" />
						<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" value=\"{$lang['subdomain']}\" name=\"subdomain\" onfocus=\"this.value = this.value=='{$lang['subdomain']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['subdomain']}' : this.value; this.value=='{$lang['subdomain']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
							<span class=\"help-block\">".str_replace('{DOMAIN}', $domain['hostname'], $lang['tipsubdomain'])."</span>
						</fieldset>
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['create']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<div id=\"newalias\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['newalias']}</h3>
				<p style=\"text-align: center;\">{$lang['newalias_text']}</p>
				<div class=\"form-small\">
					<form action=\"/panel/domains/add_alias_action\" method=\"post\" class=\"center\">
						<input type=\"hidden\" name=\"id\" value=\"{$domain['id']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" value=\"{$lang['alias']}\" name=\"domain\" onfocus=\"this.value = this.value=='{$lang['alias']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['alias']}' : this.value; this.value=='{$lang['alias']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
							<span class=\"help-block\">{$lang['tipalias']}</span>
						</fieldset>
						<fieldset>
							<select name=\"type\">
								<option value=\"permanent\">Permanente</option>
								<option value=\"transparent\">Transparente</option>
							</select>
							<span class=\"help-block\">{$lang['type']}</span>
						</fieldset>
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['create']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<div id=\"config\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['config']}</h3>
				<p style=\"text-align: center;\">{$lang['config_text']}</p>
				<div class=\"form-small\">
					<form action=\"/panel/domains/config_subdomain_action\" method=\"post\" class=\"center\">
						<input id=\"subdomainid\" type=\"hidden\" name=\"id\" value=\"\" />
						<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
						<input type=\"hidden\" name=\"domain_id\" value=\"{$domain['id']}\" />
						<fieldset>
							<input id=\"record\" type=\"text\" value=\"\" name=\"record\" />
							<span class=\"help-block\">{$lang['tiprecord']}</span>
						</fieldset>
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['update']}\" />
						</fieldset>
					</form>
				</div>
			<script>
				newDialog('new', 550, 280);
				newDialog('newalias', 550, 340);
				newDialog('config', 550, 290);
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
