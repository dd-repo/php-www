<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$params = array();
if( $_GET['service'] )
	$params['service'] = $_GET['service'];
else if( $_GET['app'] )
	$params['app'] = $_GET['app'];
if( $_GET['branch'] )
	$params['branch'] = $_GET['branch'];

api::send('self/backup/add', $params);

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/backups');

?>
