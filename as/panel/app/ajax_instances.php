<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

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
					<td>".round($i['cpu']['usage']/10, 1)."% / {$i['cpu']['quota']} core</td>
					<td>{$i['memory']['usage']}Mo / {$i['memory']['quota']}Mo</td>
					<td>{$info['d']} {$lang['days']} {$info['h']} {$lang['hours']} {$info['m']} {$lang['minutes']} {$info['s']} {$lang['seconds']} </td>
					<td>".($running?"<div class=\"state running\"><div class=\"state-content\">{$lang['running']}</div></div>":"<div class=\"state stopped\"><div class=\"state-content\">{$lang['stopped']}")."</div></div></td>
				</tr>
	";
	$j++;
}
$content .= "
			</table>
";

echo $content;

?>