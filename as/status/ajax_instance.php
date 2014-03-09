<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( !isset($_GET['key']) )
	exit();

try
{	
	$key = explode('-', $_GET['key']);
	$app = $key[0];
	$branch = $key[1];
	$id = $key[2];

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

	$result = api::send('app/list', array('id'=>$app, 'extended'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$result = $result[0];

	foreach( $result['branches'][$branch]['instances'] as $i )
	{
		if( $i['id'] == $id )
			$instance = $i;
	}

	$info = secondsToTime($instance['uptime']);

	$content = "
			<span title=\"{$result['name']}-{$branch}-{$id} - {$info['d']} {$lang['days']} {$info['h']} {$lang['hours']} {$info['m']} {$lang['minutes']} {$info['s']} {$lang['seconds']}\" class=\"gridsquare ".($instance['status']=='run'?"green":"orange")."\">".($instance['status']=='run'?"{$lang['running']}":"{$lang['stopped']}")."</span>
			<script>$('.gridsquare').tooltip();</script>
	";

	echo $content;
}
catch( Exception $e )
{
	exit();
}

?>