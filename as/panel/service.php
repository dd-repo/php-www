<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

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
			$serv['used'] = $q['used'];
			$serv['max'] = $q['max'];
		break;
		case 'APPS':
			$appq['used'] = $q['used'];
			$appq['max'] = $q['max'];
		break;
	}
}

$services_left = 260-round($serv['used']*260/$serv['max']);

$services = api::send('self/service/list');

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"/panel/service/add\" style=\"width: 200px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
";

if( count($services) == 0 )
	$content .= "<p>{$lang['no_service']}</pa>";

$j = 1;
foreach( $services as $s )
{
	$content .= "
			<div class=\"service ".($j==1?"first":"")."\" onclick=\"$('#service').val('{$s['name']}'); $('#service2').val('{$s['name']}'); $('#desc').val('{$s['description']}'); $('#config').dialog('open'); return false;\">
				<img style=\"float: left; margin: 10px 15px 0 0;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$s['vendor']}.png\" />
				<span class=\"name\" style=\"margin-top: 25px;\">{$s['description']}</span><br />
				<span class=\"subname\">{$s['name']}</span>
			</div>
	";
	
	$j++;
	
	if( $j == 4 )
		$j = 1;
}

	$content .= "
		</div>		
	</div>
	<div id=\"config\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['config']}</h3>
		<p style=\"text-align: center;\">{$lang['config_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/service/config_action\" method=\"post\" class=\"center\">
				<input id=\"service\" type=\"hidden\" name=\"service\" value=\"\" />
				<fieldset>
					<input id=\"desc\" type=\"text\" value=\"\" name=\"desc\" />
					<span class=\"help-block\">{$lang['desc_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" value=\"\" name=\"password\" />
					<span class=\"help-block\">{$lang['password_help']}</span>
				</fieldset>
				<fieldset>	
					<input  type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
			<form action=\"/panel/service/del_action\" method=\"post\" class=\"center\">
				<input id=\"service2\" type=\"hidden\" name=\"service\" value=\"\" />
				<fieldset>	
					<input type=\"submit\" value=\"{$lang['delete']}\"/>
				</fieldset>
			</form>
		</div>
	</div>	
	<script>
		newDialog('config', 550, 440);
	</script>
";


/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>