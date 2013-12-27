<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

if( !$_GET['branch'] && !$_SESSION['DATA'][$app['id']]['branch'] )
	$_SESSION['DATA'][$app['id']]['branch'] = 'master';
else if( $_GET['branch'] )
	$_SESSION['DATA'][$app['id']]['branch'] = $_GET['branch'];

$running = false;
$memory = 0;
$memoryu = 0;
$instances = 0;
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	if( $i['status'] == 'run' )
		$running = true;
	$memory = $memory+$i['memory']['quota'];
	$memoryu = $memoryu+$i['memory']['usage'];
	$instances++;
}

$expl = explode('-', $app['name']);
$language = $expl[0];

	
$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px;\">
				<img style=\"display: block; float: left; margin-right: 20px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" alt=\"\" />
				<div style=\"float: left;\">
					<span style=\"font-size: 25px; display: block; margin-bottom: 4px;\">{$app['tag']}</span>
					<span style=\"font-size: 15px; color: #878787; display: block; margin-bottom: 10px;\">{$app['name']}</span>
";

foreach( $app['branches'] as $key => $value )
	$content .= "<a href=\"/panel/app/show?id={$app['id']}&branch={$key}\" class=\"branch ".($key==$_SESSION['DATA'][$app['id']]['branch']?"active":"")."\">{$key}</a>";

$content .= "
					<a href=\"#\" class=\"branch\">+</a>
				</div>
			</div>
			<div class=\"right\" style=\"width: 600px; float: right; text-align: right;\">
				<a class=\"action settings big\" href=\"#\" onclick=\"$('#settings').dialog('open'); return false;\">
					{$lang['settings']}
				</a>
				<a class=\"action push big\" href=\"#\">
					{$lang['push']}
				</a>
				<a class=\"action delete big\" href=\"#\">
					{$lang['delete']}
				</a>					
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
		<div class=\"container\">
			<div style=\"float: left; width: 500px;\">
				<div style=\"float: left; width: 200px; padding-top: 8px;\">
					<h2 class=\"dark\">{$lang['infos']}</h2>
				</div>
				<div style=\"float: right; width: 300px;\">
					
				</div>
				<div class=\"clear\"></div><br />
				<table>
					<tr>
						<th>{$lang['info']}</th>
						<th>{$lang['data']}</th>
						<th>{$lang['actions']}</th>
					</tr>
					<tr>
						<td>{$lang['memory']}</td>
						<td><span class=\"large\">{$memoryu}Mo</span> / {$memory}Mo</td>
						<td align=\"center\">
							<a href=\"/panel/app/memory_less_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/less.png\" alt=\"\" /></a>
							<a href=\"/panel/app/memory_plus_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/add.png\" alt=\"\" /></a>
						</td>
					</tr>
					<tr>
						<td>{$lang['number']}</td>
						<td><span class=\"large\">{$instances}</span> {$lang['instances']}</td>
						<td align=\"center\">
							<a href=\"/panel/app/instance_less_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/less.png\" alt=\"\" /></a>
							<a href=\"/panel/app/instance_plus_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/add.png\" alt=\"\" /></a>
						</td>
					</tr>
					<tr>
						<td>{$lang['disk_persistant']}</td>
						<td><span class=\"large\">{$app['size']}Mo</span></td>
						<td align=\"center\">
						</td>
					</tr>
				</table>
			</div>
			<div style=\"float: right; width: 500px;\">
				<div style=\"float: left; width: 400px; padding-top: 8px;\">
					<h2 class=\"dark\">{$lang['uris']}</h2>
				</div>
				<div style=\"float: right; width: 100px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div><br />
				<table>
					<tr>
						<th>{$lang['url']}</th>
						<th>{$lang['actions']}</th>
					</tr>
		";
				
if( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['urls'] )
{
	foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['urls'] as $u )
	{		
		$content .= "
					<tr>
						<td><a href=\"http://{$u}\">{$u}</a></td>
						<td align=\"center\">
							<a href=\"/panel/app/del_url_action?id={$app['id']}&url={$u}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
		";
	}
}
		
$content .= "
				</table>
			</div>
			<div class=\"clear\"></div><br />
			<br />
			<div style=\"float: left; width: 500px; padding-top: 8px;\">
				<h2 class=\"dark\">{$lang['branchinstances']}</h2>
			</div>
			<div style=\"float: right; width: 300px;\">
				
			</div>
			<div class=\"clear\"></div>
			<table>
				<tr>
					<th>{$lang['id']}</th>
					<th>{$lang['host']}</th>
					<th>{$lang['port']}</th>
					<th>{$lang['cpu']}</th>
					<th>{$lang['memory']}</th>
					<th>{$lang['uptime']}</th>
					<th >{$lang['status']}</th>
				</tr>
";
$j = 0;
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	if( $i['status'] == 'run' )
		$running = true;
	else
		$running = false;
		
	$info = secondsToTime($i['uptime']);
	
	$content .= "
				<tr>
					<td><span class=\"large\">{$app['name']}-".security::encode($_SESSION['DATA'][$app['id']]['branch'])."-{$j}</span></td>
					<td>{$i['host']}</td>
					<td>{$i['port']}</td>
					<td>{$i['cpu']['usage']}% / {$i['cpu']['quota']} core</td>
					<td>{$i['memory']['usage']}Mo / {$i['memory']['quota']}Mo</td>
					<td>{$info['d']} {$lang['days']} {$info['h']} {$lang['hours']} {$info['m']} {$lang['minutes']} {$info['s']} {$lang['seconds']} </td>
					<td>".($running?"<div class=\"state running\"><div class=\"state-content\">{$lang['running']}</div></div>":"<div class=\"state stopped\"><div class=\"state-content\">{$lang['stopped']}")."</div></div></td>
				</tr>
	";
	$j++;
}
$content .= "
			</table>			
		</div>
	</div>
	<br />
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['changepass']}</h3>
		<p style=\"text-align: center;\">{$lang['changepass_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/settings/update_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input type=\"password\" name=\"pass\" />
					<span class=\"help-block\">{$lang['pass_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"confirm\" />
					<span class=\"help-block\">{$lang['confirm_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newDialog('new', 550, 350);
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

function secondsToTime($inputSeconds) {

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($inputSeconds / $secondsInADay);

    // extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // return the final array
    $obj = array(
        'd' => (int) $days,
        'h' => (int) $hours,
        'm' => (int) $minutes,
        's' => (int) $seconds,
    );
    return $obj;
}

?>