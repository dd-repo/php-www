<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_last", 'default'=>true, 'link'=>"/blog"),
	array('text'=>"menu_press", 'link'=>"/blog/press"),
	array('text'=>"menu_archives", 'link'=>"/blog/archive")
);

return $menu;

?>
