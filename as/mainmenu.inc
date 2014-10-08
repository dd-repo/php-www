<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/mainmenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"nhosting", 'anonymous'=>false, 'link'=>"/hosting"),
	array('text'=>"nhosting", 'anonymous'=>true, 'link'=>"/hosting"),
	array('text'=>"npaas", 'anonymous'=>false, 'link'=>"/paas"),
	array('text'=>"npaas", 'anonymous'=>true, 'link'=>"/paas"),
	array('text'=>"ninfra", 'anonymous'=>false, 'link'=>"/infrastructure"),
	array('text'=>"ninfra", 'anonymous'=>true, 'link'=>"/infrastructure"),
	array('text'=>"nblog", 'anonymous'=>false, 'link'=>"/blog"),
	array('text'=>"nblog", 'anonymous'=>true, 'link'=>"/blog"),
	array('text'=>"nhelp", 'anonymous'=>false, 'link'=>"/doc"),
	array('text'=>"nhelp", 'anonymous'=>true, 'link'=>"/doc"),
	array('text'=>"npanel", 'anonymous'=>false, 'link'=>"/panel"),
	array('text'=>"madmin", 'anonymous'=>false, 'link'=>"/admin"),
	array('text'=>"nlogout", 'anonymous'=>false, 'link'=>"/logout"),
	array('text'=>"nlogin", 'anonymous'=>true, 'link'=>"#", 'onclick'=>"$('#login').dialog('open'); return false;"),
	array('text'=>"nsignup", 'anonymous'=>true, 'link'=>"#", 'onclick'=>"$('#signup').dialog('open'); return false;")	
);

return $menu;

?>