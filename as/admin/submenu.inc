<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'icon'=>"iDownload", 'link'=>"/admin"),
	array('text'=>"menu_user", 'icon'=>"iUsers", 'link'=>"/admin/user"),
	array('text'=>"menu_domain", 'icon'=>"iGlobe", 'link'=>"/admin/domain"),
	array('text'=>"menu_group", 'icon'=>"iUsers", 'link'=>"/admin/group"),
	array('text'=>"menu_grant", 'icon'=>"iKey", 'link'=>"/admin/grant"),
	array('text'=>"menu_quota", 'icon'=>"iChart8", 'link'=>"/admin/quota")
);

return $menu;

?>
