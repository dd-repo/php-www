<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'link'=>"/panel"),
	array('text'=>"menu_service", 'link'=>"/panel/service"),
	array('text'=>"menu_dev", 'link'=>"/panel/dev"),
	array('text'=>"menu_domain", 'link'=>"/panel/domain"),
	array('text'=>"menu_mail",  'link'=>"/panel/user"),
	array('text'=>"menu_tools", 'link'=>"/panel/tools"),
	array('text'=>"menu_quota", 'link'=>"/panel/quota"),
	array('text'=>"menu_profile",'link'=>"/panel/settings"),
);

return $menu;

?>
