<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$quotas =  api::send('self/quota/user/list');

if( security::hasGrant('SELF_APP_SELECT') )
	$apps = api::send('self/app/list', array());

foreach( $quotas as $q )
{
	if( $q['name'] == 'MEMORY' )
		$quota = $q;
}

$percent = $quota['used']*100/$quota['max'];

$quota['max'] = round($quota['max']/1024, 2) . " {$lang['gb']}";

if( $quota['used'] >= 1024 )
	$quota['used'] = round($quota['used']/1024, 2) . " {$lang['gb']}";
else
	$quota['used'] = "{$quota['used']} {$lang['mb']}";
		
$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px;\">
				<img style=\"width: 60px; height: 60px; float: left; margin: 5px 10px 0px 0px; display: block;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" />
				<h1 class=\"dark title\">".security::get('USER')."</h1>
				<h2 class=\"dark title\">".($userinfo['firstname']?"{$userinfo['firstname']} {$userinfo['lastname']}":"{$lang['nolastname']}")."</h2>
			</div>
			<div class=\"right\" style=\"width: 450px;\">
				<span style=\"block; float: left; padding-top: 7px; font-size: 18px; color: #878787;\">{$lang['memory2']}</span>
				<div style=\"float: right;\">
					<div class=\"fillgraph\" style=\"margin-top: 10px;\">
						<small style=\"width: {$percent}%;\"></small>
					</div>
					<span class=\"quota\"><span style='font-weight: bold;'>{$quota['used']}</span> {$lang['of']} {$quota['max']}. <a href=\"/panel/plans\">{$lang['request']}</a>.</span>
				</div>
			</div>
			<div class=\"clear\"></div>
		</div>
		<br />
		<div class=\"apps\">
			<div class=\"appscontent\">
				<div class=\"app newapp\" id=\"newapp\">
					<div id=\"addapp\">
						<a href=\"#\" onclick=\"showForm(); return false;\" class=\"button classic\" style=\"margin: 0 auto; margin-top: 97px; padding: 10px 0 0 0; height: 40px; width: 50px; text-align: center;\">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white-big.png\" />
						</a>
					</div>
					<div id=\"formapp\" style=\"display: none; position: relative; padding: 30px 10px 10px 10px;\">
						<a href=\"#\" style=\"display: block; position: absolute; top: 5px; left: 5px;\" onclick=\"showNew(); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/arrowLeft.png\" alt=\"\" /></a>
						<div class=\"form-small\">		
							<form action=\"/panel/app/add\" method=\"post\" class=\"center\">
								<fieldset>
									<input class=\"auto\" type=\"text\" value=\"{$lang['name']}\" name=\"tag\" onfocus=\"this.value = this.value=='{$lang['name']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['name']}' : this.value; this.value=='{$lang['name']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
									<span class=\"help-block\">{$lang['tipapp']}</span>
								</fieldset>
								<fieldset>
									<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
									<span class=\"help-block\">{$lang['tippassword']}</span>
								</fieldset>
								<fieldset>	
									<input autofocus type=\"submit\" value=\"{$lang['create']}\" style=\"width: 120px;\" />
								</fieldset>
							</form>
						</div>
					</div>
				</div>
";

if( count($apps) == 0 )
{
	$content .= "<div class=\"new\">
					<div class=\"bullet\"></div>
					<div class=\"text\">
						<span class=\"title\">{$lang['welcome']}</span>
						{$lang['welcome_text']}
					</div>
				</div>
	";
}
else
{
	$count = count($apps);
	$i = 1;
	
	foreach( $apps as $a )
	{
		$language = explode('-', $a['name']);
		$language = $language[0];

		$running = false;
		$memory = 0;
		$disk = 0;
		$count = 0;
		if( $a['branches'] )
		{
			foreach( $a['branches'] as $key => $value )
			{
				foreach( $value['instances'] as $i )
				{
					if( $i['state'] == 'RUNNING' )
						$running = true;
					$memory = $memory+$i['memory']['quota'];
					$disk = $disk+$i['disk']['quota'];
					
					$count++;
				}
			}
		}
		$memory = $memory;
		$instances = $count;
		
		$urls = '';
		if( $a['branches'] )
		{
			foreach( $a['branches'] as $key => $value )
			{
				if( $value['urls'] )
					$urls = $value['urls'][0];
			}
		}
		
		if( $i == $count )
			$last = "style=\"margin-right: 0;\"";
			
		$i++;
		
		$content .= "
				<div class=\"app\" {$last} onclick=\"window.location.href='/panel/app/show?id={$a['id']}'; return false;\">
					<div class=\"normal\">
						<span style=\"color: #2475ae; font-size: 12px; display: block; position: absolute; left: 10px; top: 10px;\">{$a['name']}</span>
						<span style=\"color: #2475ae; font-size: 12px; display: block; position: absolute; right: 10px; top: 10px;\">{$lang['size']} {$a['size']} {$lang['mb']}</span>
						<div style=\"vertical-align: middle; display: table-cell; height: 250px; margin: 0 auto; width: 250px; text-align: center;\">
							<div style=\"display: inline-block;\">
								<span style=\"font-size: 25px; text-align: center; display: block; margin: 0 auto;\">{$a['tag']}</a><br />
								<span style=\"color: #a3a3a3; font-size: 15px; text-align: center; display: block; margin: 0 auto;\">{$urls}</a>
								<br />
								<img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" alt=\"\" />
							</div>
						</div>						
						<span style=\"color: #38b700; font-size: 12px; display: block; position: absolute; left: 10px; bottom: 10px;\">{$lang['cpu']} {$instances} {$lang['cores']}</span>
						<span style=\"color: #38b700; font-size: 12px; display: block; position: absolute; right: 10px; bottom: 10px;\">{$lang['memory']} {$memory} {$lang['mb']}</span>
					</div>
				</div>
		";
	}
}

$content .= "
			<div class=\"clear\"></div>
			</div>
		</div>	
	</div>
	<script>
		function showForm()
		{
			var options = {};
			$(\"#addapp\").css(\"display\", \"none\");
			$(\"#formapp\").show(\"fade\", options, 200);
			$(\"#newapp\").css(\"background-color\", \"#ffffff\");
			
		}
		function showNew()
		{
			var options = {};
			$(\"#formapp\").css(\"display\", \"none\");
			$(\"#addapp\").show(\"fade\", options, 200);
			$(\"#newapp\").css(\"background\", \"rgba(0, 0, 0, 0.05)\");
		}
	</script>";


/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>