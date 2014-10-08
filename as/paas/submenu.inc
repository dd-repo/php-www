<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_service", 'link'=>"/paas"),
	array('text'=>"menu_offer", 'link'=>"/paas/offer"),
	array('text'=>"menu_infrastructure", 'link'=>"/paas/infrastructure"),
);

return $menu;

?>
