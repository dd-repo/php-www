<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$apps = api::send('app/list', array(), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$instances['docker-001'] = array();
$instances['docker-002'] = array();
$instances['docker-003'] = array();
$instances['docker-004'] = array();
$instances['docker-005'] = array();
$instances['docker-006'] = array();
$instances['docker-007'] = array();
$instances['docker-008'] = array();
$instances['docker-009'] = array();
$instances['docker-010'] = array();
$instances['docker-011'] = array();
$instances['docker-012'] = array();
$instances['docker-013'] = array();

foreach( $apps as $a )
{
	if( is_array($a['branches']) )
	{
		foreach( $a['branches'] as $key => $value )
		{
			if( is_array($value) )
			{
				foreach( $value['instances'] as $i )
				{
					$i['app'] = $a['id'];
					$i['name'] = $a['name'];
					$i['branch'] = $key;
					$instances[$i['host']][] = $i;
					$j++;
				}
			}
		}
	}
}

$content = "
		<div class=\"content\" style=\"margin-top: 0; padding-top: 20px;\">
			<h2 class=\"dark\">{$lang['grid']}</h2>
			<br />
";

foreach( $instances as $key => $value )
{
	$content .= "
			<h4 style=\"float: left; margin-right: 30px; padding-top: 5px; width: 120px;\">{$key}</h4>
	";
	
	if( is_array($value) )
	{
		foreach( $value as $i )
		{
			$content .= "
			<div class=\"grid\" id=\"{$i['app']}-{$i['branch']}-{$i['id']}\">
				<span class=\"gridsquare\"></span>			
			</div>";
		}
	}
	
	$content .= "<div class=\"clear\"></div><br />";
}

$content .= "			
			<br />
		</div>
		<script>
		 $(function() {
";

foreach( $instances as $key => $value )
{
	if( is_array($value) )
	{
		foreach( $value as $i )
		{	
			$content .= "
			getinstances('{$i['app']}-{$i['branch']}-{$i['id']}');
			setInterval(function(){ getinstances('{$i['app']}-{$i['branch']}-{$i['id']}'); }, 60000);
			";
		}
	}
}

$content .= "
			function getinstances(instance)
			{
				$('#' + instance).load('/status/ajax_instance?key=' + instance);
			}		
		});
		</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>