<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$users = api::send('user/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$apps = api::send('apps/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$services = api::send('service/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$domains = api::send('domain/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$onusers = api::send('user/list', array('count'=>1), $GLOBALS['CONFIG']['API_ON_USERNAME'].':'.$GLOBALS['CONFIG']['API_ON_PASSWORD'], false, $GLOBALS['CONFIG']['API_ON_HOST']);
$onapps = api::send('site/list', array('count'=>1), $GLOBALS['CONFIG']['API_ON_USERNAME'].':'.$GLOBALS['CONFIG']['API_ON_PASSWORD'], false, $GLOBALS['CONFIG']['API_ON_HOST']);
$onservices = api::send('database/list', array('count'=>1), $GLOBALS['CONFIG']['API_ON_USERNAME'].':'.$GLOBALS['CONFIG']['API_ON_PASSWORD'], false, $GLOBALS['CONFIG']['API_ON_HOST']);
$ondomains = api::send('domain/list', array('count'=>1), $GLOBALS['CONFIG']['API_ON_USERNAME'].':'.$GLOBALS['CONFIG']['API_ON_PASSWORD'], false, $GLOBALS['CONFIG']['API_ON_HOST']);

$users['count'] = $users['count']+$onusers['count'];
$apps['count'] = $apps['count']+$onapps['count'];
$services['count'] = $services['count']+$onservices['count'];
$domains['count'] = $domains['count']+$ondomains['count'];

switch( translator::getLanguage() )
{
	case 'FR':
		$users['count'] = number_format($users['count'], 0, ',', ' ');
		$apps['count'] = number_format($apps['count'], 0, ',', ' ');
		$services['count'] = number_format($services['count'], 0, ',', ' ');
		$domains['count'] = number_format($domains['count'], 0, ',', ' ');
	break;
	default:
		$users['count'] = number_format($users['count']);
		$apps['count'] = number_format($apps['count']);
		$services['count'] = number_format($services['count']);
		$domains['count'] = number_format($domains['count']);
}

$content = "		
			<span style=\"display: block; font-size: 70px; margin: 0 auto;\">{$users['count']}</span>
			<span style=\"display: block; font-size: 30px; color: #53bfed; margin-top: 5px;\">{$lang['users']}</span>
			<span style=\"display: block; font-size: 18px; margin-top: 20px;\">
				<span style=\"color: #53bfed\">{$apps['count']}</span> {$lang['apps']}, 
				<span style=\"color: #53bfed\">{$services['count']}</span> {$lang['services']} 
				<span style=\"color: #53bfed\">{$domains['count']}</span> {$lang['domains']}
			</span>
";

echo $content;

?>