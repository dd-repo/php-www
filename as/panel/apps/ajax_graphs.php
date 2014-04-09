<?php


if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

function random_color($type)
{
	$color = array();
	switch( $type )
	{
		case 1:
			$color[0] = rand(0,56);
			$color[1] = rand(0,56);
			$color[2] = rand(0,255);
		break;
		case 2:
			$color[0] = rand(0,56);
			$color[1] = rand(0,255);
			$color[2] = rand(0,56);
		break;
		case 2:
			$color[0] = rand(0,56);
			$color[1] = rand(0,56);
			$color[2] = rand(0,56);
		break;
	}

    return $color[0] . $color[1] . $color[2];
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$now = time();
// Last 24 hours
$data_day = array();
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $inst )
{
	$dayago = mktime(date('H')+1, 0, 0, date('n'), date('j'), date('Y'))-(3600*24);
	$ram = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'memory', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'instance'=>$inst['id'], 'group' => 'HOUR', 'from' => $dayago, 'to' => $now, 'start' => 0, 'limit' => 1000));
	$cpu = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'cpu', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'instance'=>$inst['id'], 'group' => 'HOUR', 'from' => $dayago, 'to' => $now, 'start' => 0, 'limit' => 1000));
	
	$current = $dayago;
	for( $i = 1; $i <= 24; $i++ )
	{
		$next = $current+3600;
		$data_day[$current]['ram' . $inst['id']] = 0;
		$data_day[$current]['cpu' . $inst['id']] = 0;
		$data_day[$current]['date'] = date($lang['dateformathour'], $current);
		foreach( $cpu as $c )
		{
			if( $c['HOUR'] == date('H', $current) )
				$data_day[$current]['cpu' . $inst['id']] = $c['average'];
		}
		foreach( $ram as $r )
		{
			if( $r['HOUR'] == date('H', $current) )
				$data_day[$current]['ram' . $inst['id']] = $r['average'];
		}
		$current = $next;
	}
}

// Last month
$data_month = array();
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $inst )
{
	$monthago = mktime(date('H'), 0, 0, date('n'), date('j')+1, date('Y'))-(3600*24*30);
	$ram = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'memory', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'instance'=>$inst['id'], 'group' => 'DAY', 'from' => $monthago, 'to' => $now, 'start' => 0, 'limit' => 1000));
	$cpu = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'cpu', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'instance'=>$inst['id'], 'group' => 'DAY', 'from' => $monthago, 'to' => $now, 'start' => 0, 'limit' => 1000));
	$current = $monthago;
	for( $i = 1; $i <= 30; $i++ )
	{
		$next = $current+(3600*24);
		$data_month[$current]['ram' . $inst['id']] = 0;
		$data_month[$current]['cpu' . $inst['id']] = 0;
		$data_month[$current]['date'] = date($lang['dateformat'], $current);
		foreach( $cpu as $c )
		{
			if( $c['DAY'] == date('d', $current) )
				$data_month[$current]['cpu' . $inst['id']] = $c['average'];
		}
		foreach( $ram as $r )
		{
			if( $r['DAY'] == date('d', $current) )
				$data_month[$current]['ram' . $inst['id']] = $r['average'];
		}
		$current = $next;
	}
}

$content = "
	<div id=\"chart1\"></div>
	<br />
	<div id=\"chart2\"></div>
	<br /><br />
	<script>
		$(function()
		{		
			var dataSourceDay = [";

foreach( $data_day as $key => $value )
{
	$content .= "
			{ hour: '".date($lang['dateformathour'], $key)."', "; 

	foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
	{
		$content .= " memory{$i['id']}: " . $value['ram' . $i['id']] . ", cpu{$i['id']}: " . $value['cpu' . $i['id']] . ", ";
	}
	
	$content .= "}, ";
}

$content .= "
			];
			
			var dataSourceMonth = [";

foreach( $data_month as $key => $value )
{
	$content .= "
			{ day: '".date($lang['dateformat'], $key)."', ";
	
	foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
	{
		$content .= " memory{$i['id']}: " . $value['ram' . $i['id']] . ", cpu{$i['id']}: " . $value['cpu' . $i['id']] . ",";
	}
	
	$content .= " }, ";
}

$content .= "
			];
			
			$(\"#chart1\").dxChart({
				dataSource: dataSourceDay,
				commonSeriesSettings: {
					argumentField: \"hour\",
					point: {
						visible: false
					}
				},
				series: [
";
$k = 1;
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	$content .= "					{ valueField: \"memory{$i['id']}\", name: \"{$app['name']}-{$_SESSION['DATA'][$app['id']]['branch']}-{$i['id']} ({$lang['memory']})\", type: 'bar', 'color': '#".random_color($k)."', axis: \"memory\" },
									{ valueField: \"cpu{$i['id']}\", name: \"{$app['name']}-{$_SESSION['DATA'][$app['id']]['branch']}-{$i['id']} ({$lang['cpu']})\", type: 'spline', 'color': '#".random_color($k)."', axis: \"cpu\" },
	";
	$k++;
	
	if( $k == 4 )
		$k = 1;
}

$content .= "
				],
				valueAxis: [
					{ name: \"memory\", position: \"left\", grid: { visible: true }, title: { text: \"{$lang['memory2']}\" } },
					{ name: \"cpu\", position: \"right\", grid: { visible: true }, title: { text: \"{$lang['cpu']}\" } }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart1_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\"
				},
				size: {
					width: 1100,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});

			$(\"#chart2\").dxChart({
				dataSource: dataSourceMonth,
				commonSeriesSettings: {
					argumentField: \"day\"
				},
				series: [
";
$k = 1;
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	$content .= "					{ valueField: \"memory{$i['id']}\", name: \"{$app['name']}-{$_SESSION['DATA'][$app['id']]['branch']}-{$i['id']} ({$lang['memory']})\", type: 'bar', 'color': '#".random_color($k)."', axis: \"memory\" },
									{ valueField: \"cpu{$i['id']}\", name: \"{$app['name']}-{$_SESSION['DATA'][$app['id']]['branch']}-{$i['id']} ({$lang['cpu']})\", type: 'spline', 'color': '#".random_color($k)."', axis: \"cpu\" },
	";
	$k++;
	
	if( $k == 4 )
		$k = 1;
}
$content .= "
				],
				valueAxis: [
					{ name: \"memory\", position: \"left\", grid: { visible: true }, title: { text: \"{$lang['memory2']}\" } },
					{ name: \"cpu\", position: \"right\", grid: { visible: true }, title: { text: \"{$lang['cpu']}\" } }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart2_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\"
				},
				size: {
					width: 1100,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});
		});
	</script>
";

echo $content;