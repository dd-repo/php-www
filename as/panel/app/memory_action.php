<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/app/update', array('app'=>$_GET['id'], 'branch'=>$_GET['branch'], 'memory' => $_GET['memory']));

sleep(4);

echo "OK";

?>
