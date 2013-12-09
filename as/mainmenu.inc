<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/mainmenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"nhosting", 'anonymous'=>false, 'link'=>"/service/hosting"),
	array('text'=>"nhosting", 'anonymous'=>true, 'link'=>"/service/hosting"),
	array('text'=>"nconsulting", 'anonymous'=>false, 'link'=>"/service/consulting"),
	array('text'=>"nconsulting", 'anonymous'=>true, 'link'=>"/service/consulting"),
	array('text'=>"ncontact", 'anonymous'=>false, 'link'=>"/about/contact"),
	array('text'=>"ncontact", 'anonymous'=>true, 'link'=>"/about/contact"),
	array('text'=>"nblog", 'anonymous'=>false, 'link'=>"/blog"),
	array('text'=>"nblog", 'anonymous'=>true, 'link'=>"/blog"),
	array('text'=>"nhelp", 'anonymous'=>false, 'link'=>"/doc"),
	array('text'=>"nhelp", 'anonymous'=>true, 'link'=>"/doc"),
	array('text'=>"npanel", 'anonymous'=>false, 'link'=>"/panel"),
	array('text'=>"nlogout", 'anonymous'=>false, 'link'=>"/logout"),
	array('text'=>"nlogin", 'anonymous'=>true, 'link'=>"/login"),
	array('text'=>"nregister", 'anonymous'=>true, 'link'=>"/join"),
);

return $menu;

?>