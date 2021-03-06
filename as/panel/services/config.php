<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$service = api::send('self/service/list', array('service'=>$_GET['service']));
$service = $service[0];

$percent = round($service['stats'][$service['host']]*100/6000);

if( $percent > 100 )
	$percent = 100;

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px; width: 700px;\">
				<h1 class=\"dark\">{$lang['service']} {$service['name']}</h1>
			</div>
			<div class=\"right\" style=\"width: 400px;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['delete']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<div style=\"width: 500px; float: left;\">
				<h3 class=\"colored\">{$lang['change_pass']}</h3>
				<form action=\"/panel/services/password_action\" method=\"post\">
					<input type=\"hidden\" name=\"service\" value=\"".security::encode($_GET['service'])."\" />
					<fieldset>
						<input type=\"password\" name=\"pass\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password']}</span>
					</fieldset>
					<fieldset>
						<input type=\"password\" name=\"confirm\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['password2']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 420px; float: right;\">
				<h3 class=\"colored\">{$lang['change_info']}</h3>
				<form action=\"/panel/services/config_action\" method=\"post\">
					<input type=\"hidden\" name=\"service\" value=\"".security::encode($_GET['service'])."\" />
					<fieldset>
						<input type=\"text\" name=\"description\" value=\"{$service['description']}\" style=\"width: 400px;\" />
						<span class=\"help-block\">{$lang['description_help']}</span>
					</fieldset>
					<fieldset>
						<select disabled name=\"\" style=\"width: 415px;\">
							<option value=\"\" ".($service['vendor']=='mysql'?"selected":"")." >MySQL</option>
							<option value=\"\" ".($service['vendor']=='pgsql'?"selected":"")." >PostgreSQL</option>
							<option value=\"\" ".($service['vendor']=='mongodb'?"selected":"")." >MongoDB</option>
						</select>
						<span class=\"help-block\">{$lang['type_help']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<h2 class=\"dark\">{$lang['connection']}</h2>
			<table>
				<tr>
					<th style=\"text-align: center; width: 40px;\">#</th>
					<th>{$lang['server']}</th>
					<th>{$lang['username']}</th>
					<th>{$lang['base']}</th>
					<th style=\"width: 260px;\">{$lang['app']}</th>
					<th style=\"width: 50px;  text-align: center;\">{$lang['actions']}</th>
				</tr>
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/server.png\" /></td>
					<td>{$service['host']}</td>
					<td>{$service['name']}</td>
					<td>{$service['name']}-master</td>
";
$language = explode('-', $service['app_name']);
$language = $language[0];

$content .= "
					<td>".($service['app']==0?"{$lang['noapp']}":"<a href=\"/panel/apps/show?id={$service['app']}\"><img style=\"float: left; margin-right: 10px; width: 50px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" /></a> <span style=\"display: block; padding-top: 15px;\">{$service['app_tag']}</a></td>")."
					<td style=\"width: 50px; text-align: center;\">
						<a href=\"#\" title=\"\" onclick=\"$('#branch').val('master'); $('#download').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/download2.png\" alt=\"\" /></a>
					</td>
				</tr>
";

if( count($service['branches']) > 0  )
{
	foreach( $service['branches'] as $b )
	{
		$language = explode('-', $b['app_name']);
		$language = $language[0];
		
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/server.png\" /></td>
					<td>{$service['host']}</td>
					<td>{$service['name']}</td>
					<td>{$service['name']}-{$b['branch_name']}</td>					
					<td><a href=\"/panel/apps/show?id={$b['app_id']}&branch={$b['branch_name']}\"><img style=\"float: left; margin-right: 10px; width: 50px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" /></a> <span style=\"display: block; padding-top: 15px;\">{$b['app_tag']}</a></td>
					<td style=\"width: 50px; text-align: center;\">
						<a href=\"#\" title=\"\" onclick=\"$('#branch').val('{$b['branch_name']}'); $('#download').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/download2.png\" alt=\"\" /></a>
					</td>
				</tr>
		";
	}
}
$content .= "
			</table>
			<br /><br />
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/services/del_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" value=\"{$service['name']}\" name=\"service\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"download\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['backup']}</h3>
		<p style=\"text-align: center;\">{$lang['backup_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/backups/add_action\" method=\"get\" class=\"center\">
				<input id=\"branch\" type=\"hidden\" value=\"\" name=\"branch\" />
				<input type=\"hidden\" value=\"{$service['name']}\" name=\"service\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['backup_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('download', 550);
		newFlexibleDialog('delete', 550);
	</script>	
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
