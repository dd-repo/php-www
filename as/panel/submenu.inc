<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'icon'=>"iDownload", 'link'=>"/panel"),
	array('text'=>"menu_service", 'icon'=>"iImage", 'link'=>"/panel/service"),
	array('text'=>"menu_dev", 'icon'=>"iDev", 'link'=>"/panel/dev"),
	array('text'=>"menu_domain", 'icon'=>"iGlobe", 'link'=>"/panel/domain"),
	array('text'=>"menu_mail", 'icon'=>"iMail", 'link'=>"/panel/user"),
	array('text'=>"menu_billing", 'icon'=>"iMoney2", 'link'=>"/panel/billing"),
	array('text'=>"menu_profile", 'icon'=>"iProfile", 'link'=>"/panel/profile"),
);

return $menu;

?>
