<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_intro", 'default'=>true, 'link'=>"/doc"),
	array('text'=>"menu_concepts", 'link'=>"/doc/concepts"),
	array('text'=>"menu_languages", 'link'=>"/doc/languages"),
	array('text'=>"menu_services", 'link'=>"/doc/services"),
	array('text'=>"menu_faq", 'link'=>"/doc/faq"),
);

return $menu;

?>
