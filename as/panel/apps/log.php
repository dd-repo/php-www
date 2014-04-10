<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

function cmp($a, $b)
{
    return strcmp($b["date"], $a["date"]);
}

$app = api::send('self/app/list', array('id'=>$_GET['id'], 'log'=>1));
$app = $app[0];

$log = '';
$logs = array();

if( $_GET['instance'] )
{
	if( count($app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances']) > 0 )
	{
		foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
		{	
			if( $i['id'] == $_GET['instance'] )
				$instance = $i;
		}
		foreach( preg_split("/((\r?\n)|(\r\n?))/", $instance['log']) as $line )
		{
			preg_match("/^\\s*([0-9\\-_:\\.]+)?(.*)$/is", trim($line), $m);
			$logs[] = array('host'=>$instance['host'], 'date'=>$m[1], 'text'=>$m[2]);
			$j++;
		}
	}
	$log = $i['log'];
}
else
{
	if( count($app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances']) > 0 )
	{
		foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
		{	
			foreach( preg_split("/((\r?\n)|(\r\n?))/", $i['log']) as $line )
			{
				preg_match("/^\\s*([0-9\\-_:\\.]+)?(.*)$/is", trim($line), $m);
				$logs[] = array('host'=>$i['host'], 'date'=>$m[1], 'text'=>$m[2]);
				$j++;
			}
		}
	}	
	usort($logs, "cmp");
}

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 700px;\">
				<h1 class=\"dark\">{$lang['title']} {$app['name']}</h1>
			</div>
			<div class=\"right\" style=\"width: 300px;\">
			</div>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\">
			<table>
				<tr>
					<th style=\"width: 100px;\">{$lang['host']}</th>
					<th style=\"width: 160px;\">{$lang['date']}</th>
					<th>{$lang['text']}</th>
				</tr>
";
foreach( $logs as $l )
{
	$l['date'] = explode('.', $l['date']);
	$l['date'] = $l['date'][0];
	
	$content .= "
				<tr>
					<td style=\"width: 100px;\">{$l['host']}</td>
					<td style=\"width: 160px;\">{$l['date']}</td>
					<td>{$l['text']}</td>
				</tr>
	";
}

$content .= "
			</table>
			
		</div>
	</div>
	";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
