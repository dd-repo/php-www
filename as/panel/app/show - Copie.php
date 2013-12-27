<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id'], 'extended'=>1));
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
	<div class=\"box nocol\">
		<div class=\"container\">
			<div style=\"float: left; width: 550px; margin-right: 40px;\">
				<h2>{$lang['title']} {$app['name']}</h2>
				<br />
				<br />
				<h3 class=\"colored\">{$lang['info']} ".security::encode($_SESSION['DATA'][$app['id']]['branch'])."</h3>
				<br />
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
			<div style=\"float: left; width: 470px;\">
				<div style=\"text-align: right;\">
";

foreach( $app['branches'] as $key => $value )
	$content .= "<a href=\"/panel/app/show?id={$app['id']}&branch={$key}\" class=\"btn ".($key==$_SESSION['DATA'][$app['id']]['branch']?"active":"")."\">{$key}</a>&nbsp;&nbsp;&nbsp;";

$content .= "
				<a class=\"btn\" href=\"/panel/app/add_env?id={$app['id']}\">+</a>		
				</div>
				<br />
				<br />
				<h3 class=\"colored\">{$lang['uris']} ".security::encode($_SESSION['DATA'][$app['id']]['branch'])."</h3>
				<br />
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
				<br />
				<a class=\"btn\" href=\"/panel/app/add_url?id={$app['id']}\">{$lang['add_url']}</a>
				<br />
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<br />
			<div style=\"float: left; width: 500px; margin-right: 40px;\">
				<h2>{$lang['process']} ".security::encode($_SESSION['DATA'][$app['id']]['branch'])."</h2>
			</div>
			<div style=\"float: right; width: 500px;\">
				<div style=\"text-align: right;\">
					<a href=\"/panel/app/rebuild_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" class=\"btn\">{$lang['rebuild']}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"/panel/app/restart_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" class=\"btn\">{$lang['restart']}</a>&nbsp;&nbsp;&nbsp;<a href=\"/panel/app/start_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" class=\"btn pill-left ".($running?"active":"")."\">{$lang['start']}</a><a href=\"/panel/app/stop_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" class=\"btn pill-right ".($running?"":"active")."\">{$lang['stop']}</a>
				</div>
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<table>
				<tr>
					<th>{$lang['id']}</th>
					<th>{$lang['host']}</th>
					<th>{$lang['port']}</th>
					<th>{$lang['cpu']}</th>
					<th>{$lang['mem']}</th>
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
			<hr>
			<div style=\"float: left; width: 550px; margin-right: 40px;\">
				<h3 class=\"colored\">{$lang['infosapp']}</h3>
				<br />
				<table>
					<tr>
						<th>{$lang['info']}</th>
						<th>{$lang['data']}</th>
					</tr>
					<tr>
						<td>{$lang['language']}</td>
						<td><span class=\"large\">{$lang[$language]}</span></td>
					</tr>			
					<tr>
						<td>{$lang['framework']}</td>
						<td><span class=\"large\">".$lang['framework_' . $language]."</span></td>
					</tr>
					<tr>
						<td>{$lang['binary']}</td>
						<td><span class=\"small\">".($app['binary']?"{$lang['command']} {$app['binary']}":str_replace('{BRANCH}', security::encode($_SESSION['DATA'][$app['id']]['branch']), $lang['binary_' . $language]))."</span></td>
					</tr>
				</table>
			</div>
			<div style=\"float: left; width: 470px;\">
				<h3 class=\"colored\">{$lang['change']}</h3>
				<br />
				<form action=\"/panel/app/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
					<fieldset>
						<label>{$lang['tag']}</label>
						<input type=\"text\" name=\"tag\" value=\"{$app['tag']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['password']}</label>
						<input type=\"password\" name=\"newpassword\" />
					</fieldset>
					<fieldset>
						<label>{$lang['password2']}</label>
						<input type=\"password\" name=\"confirm\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div class=\"clearfix\"></div>
			<h3 class=\"colored\">{$lang['access']}</h3>
			<br />
			<table>
				<tr>
					<th>{$lang['type']}</th>
					<th>{$lang['info']}</th>
					<th>{$lang['user']}</th>
					<th>{$lang['port']}</th>
				</tr>
				<tr>
					<td><span class=\"large\">GIT</span></td>
					<td>ssh://git.as/~".security::get('USER')."/{$app['name']}.git</td>
					<td>{$app['name']}</td>
					<td>22</td>
				</tr>
				<tr>
					<td><span class=\"large\">SFTP</span></td>
					<td>sftp://ftp.anotherservice.com</td>
					<td>{$app['name']}</td>
					<td>22</td>
				</tr>				
				<tr>
					<td><span class=\"large\">FTP</span></td>
					<td>ftp://ftp.anotherservice.com</td>
					<td>{$app['name']}</td>
					<td>21</td>
				</tr>
			</table>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/** 
 * Convert number of seconds into hours, minutes and seconds 
 * and return an array containing those values 
 * 
 * @param integer $inputSeconds Number of seconds to parse 
 * @return array 
 */ 

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

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>