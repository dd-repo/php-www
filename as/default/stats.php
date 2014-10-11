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
			<div class=\"boxin small\">
				<span style=\"font-size: .8em; color: #acacac; text-transform: uppercase;\">{$lang['users']}</span><br />
				<span class=\"colored large\" style=\"display: block; margin: 0 auto; margin-bottom: 10px;\">{$users['count']}</span>
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/users_dark.png\" alt=\"\" style=\"width: 40px;\" />
			</div>
			<div class=\"boxin small\">
				<span style=\"font-size: .8em; color: #acacac; text-transform: uppercase;\">{$lang['apps']}</span><br />
				<span class=\"colored large\" style=\"display: block; margin: 0 auto; margin-bottom: 10px;\">{$apps['count']}</span>
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/apps_dark.png\" alt=\"\" style=\"width: 40px;\" />
			</div>
			<div class=\"boxin small\">
				<span style=\"font-size: .8em; color: #acacac; text-transform: uppercase;\">{$lang['services']}</span><br />
				<span class=\"colored large\" style=\"display: block; margin: 0 auto; margin-bottom: 10px;\">{$services['count']}</span>
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/databases_dark.png\" alt=\"\" style=\"width: 40px;\" />
			</div>
			<div class=\"boxin small\">
				<span style=\"font-size: .8em; color: #acacac; text-transform: uppercase;\">{$lang['domains']}</span><br />
				<span class=\"colored large\" style=\"display: block; margin: 0 auto; margin-bottom: 10px;\">{$domains['count']}</span>
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/domains_dark.png\" alt=\"\" style=\"width: 40px;\" />
			</div>
";

echo $content;

?>