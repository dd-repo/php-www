<?php

if( !defined('PROPER_START') )
{
        header("HTTP/1.0 403 Forbidden");
        exit;
}

api::send('user/qcompute', array('user'=>$_GET['id']));

if( isset($_GET['redirect']) )
        template::redirect($_GET['redirect']);
else
        $template->redirect('/admin/users/detail?id=' . $_GET['id'].'#quotas');

?>