<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
$domain = api::send('self/domain/list', array('domain'=>$_GET['source']));
$domain = $domain[0];

api::send('self/alias/del', array('id'=>$_GET['id']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/domain/config?id='.$domain['id']);

?>
