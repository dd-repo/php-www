<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

api::send('self/team/update', array('id'=>$_POST['id'], 'domain'=>$_POST['domain'], 'mode'=>'add', 'redirection'=>$_POST['redirection']));

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	$template->redirect('/panel/group/config?id='.$_POST['id'].'&domain='.$_POST['domain']);

?>