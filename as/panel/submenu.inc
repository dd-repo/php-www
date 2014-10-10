<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'link'=>"/panel", 'icon'=>"desktop"),
	array('text'=>"menu_services", 'link'=>"/panel/services", 'icon'=>"database"),
	array('text'=>"menu_repositories", 'link'=>"/panel/repositories", 'icon'=>"code-fork"),
	array('text'=>"menu_domains", 'link'=>"/panel/domains", 'icon'=>"globe"),
	array('text'=>"menu_tools", 'link'=>"/panel/tools", 'icon'=>"area-chart"),
	array('text'=>"menu_quotas", 'link'=>"/panel/quotas", 'icon'=>"dashboard"),
	array('text'=>"menu_backups", 'link'=>"/panel/backups", 'icon'=>"save"),
	array('text'=>"menu_settings",'link'=>"/panel/settings", 'icon'=>"cog"),
);

return $menu;

?>
