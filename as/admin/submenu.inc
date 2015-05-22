<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/submenu.lang');

// initialize the menu
$menu = array(
	array('text'=>"menu_home", 'link'=>"/admin"),
	array('text'=>"menu_users", 'link'=>"/admin/users"),
	array('text'=>"menu_billing", 'link'=>"/admin/billing"),
	array('text'=>"menu_domains", 'link'=>"/admin/domains"),
	array('text'=>"menu_groups", 'link'=>"/admin/groups"),
	array('text'=>"menu_grants", 'link'=>"/admin/grants"),
	array('text'=>"menu_quotas", 'link'=>"/admin/quotas"),
	array('text'=>"menu_stats", 'link'=>"/admin/stats"),
	array('text'=>"menu_blog", 'link'=>"/admin/blog"),
	array('text'=>"menu_logs", 'link'=>"/admin/logs")
);

return $menu;

?>
