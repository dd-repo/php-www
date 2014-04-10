<?php


if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

function random_color()
{
	$color = array();
	$color[0] = rand(128,201);
	$color[1] = rand(128,201);
	$color[2] = rand(128,201);
		
    return dechex($color[0]) . dechex($color[1]) . dechex($color[2]);
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

foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	$content .= "
					{ valueField: \"cpu{$i['id']}\", name: \"{$app['name']}-{$_SESSION['DATA'][$app['id']]['branch']}-{$i['id']} ({$lang['cpu']})\", type: 'spline', 'color': '#".random_color()."' },
	";
}

$content .= "
				],
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + '%'
						}
					},
				},
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
					verticalAlignment: \"bottom\",
					horizontalAlignment: \"center\"
				},
				size: {
					width: 1100,
					height: 300
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});

			$(\"#chart2\").dxChart({
				dataSource: dataSourceDay,
				commonSeriesSettings: {
					argumentField: \"hour\"
				},
				series: [
";
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	$content .= "					{ valueField: \"memory{$i['id']}\", name: \"{$app['name']}-{$_SESSION['DATA'][$app['id']]['branch']}-{$i['id']} ({$lang['memory']})\", type: 'bar', 'color': '#".random_color()."' },
	";
}
$content .= "
				],
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + 'M'
						}
					}
				},
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
					verticalAlignment: \"bottom\",
					horizontalAlignment: \"center\"
				},
				size: {
					width: 1100,
					height: 300
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