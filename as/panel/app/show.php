<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domains/list');

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
					<a href=\"#\" class=\"branch\" onclick=\"$('#newbranch').dialog('open'); return false;\">+</a>
				</div>
			</div>
			<div class=\"right\" style=\"width: 600px; float: right; text-align: right;\">
				<a class=\"action settings big\" href=\"#\" onclick=\"$('#settings').dialog('open'); return false;\">
					{$lang['settings']}
				</a>
				<a class=\"action push big\" href=\"#\" onclick=\"$('#push').dialog('open'); return false;\">
					{$lang['push']}
				</a>
				<a class=\"action delete big\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\">
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
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"/panel/app/memory_less_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/less.png\" alt=\"\" /></a>
							<a href=\"/panel/app/memory_plus_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/add.png\" alt=\"\" /></a>
						</td>
					</tr>
					<tr>
						<td>{$lang['number']}</td>
						<td><span class=\"large\">{$instances}</span> {$lang['instances']}</td>
						<td style=\"width: 70px; text-align: center;\">
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
					<a class=\"button classic\" href=\"#\" onclick=\"$('#newurl').dialog('open');\" style=\"width: 22px; height: 22px; float: right;\">
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
						<td style=\"width: 30px; text-align: center;\">
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
	<div id=\"newurl\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['newurl_title']}</h3>
		<p style=\"text-align: center;\">{$lang['newurl_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/app/add_url_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<input type=\"hidden\" name=\"branch\" value=\"{$_SESSION['DATA'][$app['id']]['branch']}\" />
				<fieldset>
					<select name=\"url\">";
foreach( $domains as $d )
{
	$content .= "		<optgroup label=\"{$d['hostname']}\">
							<option value=\"{$d['hostname']}\">{$d['hostname']}</option>
	";

	$subdomains = api::send('self/subdomain/list', array('domain' => $d['hostname']));
	foreach( $subdomains as $s )
		$content .= "			<option value=\"{$s['hostname']}\">{$s['hostname']}</option>";
		
	$content .= " 			</optgroup>";
}

$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_url']}</span>
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['add_url']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"newbranch\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['newbranch_title']}</h3>
		<p style=\"text-align: center;\">{$lang['newbranch_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/app/add_env_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<fieldset>
					<select name=\"branch\">
						<option value=\"production\">production</option>
						<option value=\"develop\">develop</option>
						<option value=\"recipe\">recipe</option>
						<option value=\"staging\">staging</option>
						<option value=\"testing\">testing</option>
					</select>
					<span class=\"help-block\">{$lang['help_branch']}</span>
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['add_branch']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"settings\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['settings_title']}</h3>
		<p style=\"text-align: center;\">{$lang['settings_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/app/update_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<fieldset>
					<input type=\"text\" name=\"tag\" value=\"{$app['tag']}\" />
					<span class=\"help-block\">{$lang['tag_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"newpassword\" />
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
	<div id=\"push\" class=\"floatingdialog\">
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['push_title']}</h3>
		<p style=\"text-align: center;\">{$lang['push_text']}</p>
		<br />
		<table>
			<tr>
				<th>{$lang['type']}</th>
				<th>{$lang['infos']}</th>
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
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['delete_title']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<a style=\"width: 150px; margin: 0 auto;\" href=\"/panel/app/del_action?id={$app['id']}\" class=\"button classic\">{$lang['delete_now']}</a>
	</div>
	<script>
		newFlexibleDialog('newurl', 550);
		newFlexibleDialog('newbranch', 550);
		newFlexibleDialog('settings', 550);
		newDialog('delete', 550, 170);
		newDialog('push', 700, 330);
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