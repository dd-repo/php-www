<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$content = "
	<div class=\"box rightcol\">
		<div class=\"left\">
			<div class=\"container\">
				<h2>{$lang['title']} :: {$app['name']}</h2>
				<p class=\"large\">{$lang['intro']}</p>
				<a  href=\"/panel/app/del_action?id={$app['id']}\" class=\"btn icon\">{$lang['delete']}</a>
			</div>
		</div>
		<div class=\"right\">
			<div class=\"container\">
				<h2>Gestion d'une application</h2>
				<ul class=\"leftmenu\">
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/home.png\" alt=\"\" /> <a href=\"/panel/app/show?id={$app['id']}\"><span>{$lang['home']}</span></a></li>
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/suitcase.png\" alt=\"\" /> <a href=\"/panel/app/service?id={$app['id']}\"><span>{$lang['services']}</span></a></li>
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/cloudUpload.png\" alt=\"\" /> <a href=\"/panel/app/update?id={$app['id']}\"><span>{$lang['update']}</span></a></li>
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/globe.png\" alt=\"\" /> <a href=\"/panel/app/address?id={$app['id']}\"><span>{$lang['address']}</span></li>
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/locked2.png\" alt=\"\" /> <a href=\"/panel/app/ssl?id={$app['id']}\"><span>{$lang['ssl']}</span></li>
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/refresh4.png\" alt=\"\" /> <a href=\"/panel/app/clone?id={$app['id']}\"><span>{$lang['clone']}</span></li>
					<li><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/cog.png\" alt=\"\" /> <a href=\"/panel/app/settings?id={$app['id']}\"><span>{$lang['settings']}</span></li>
				</ul>
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>