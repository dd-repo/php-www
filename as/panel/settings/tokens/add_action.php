<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

switch( $_POST['type'] )
{
	case 'admin':
		api::send('self/token/add', array('name'=>$_POST['name'], 'lease'=>'never', 'grants'=>'ACCESS,SELF_SELECT,SELF_UPDATE,SELF_DELETE,SELF_GRANT_SELECT,SELF_GROUP_SELECT,SELF_GROUP_DELETE,SELF_TOKEN_INSERT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_DELETE,SELF_QUOTA_SELECT,SELF_TOKEN_GRANT_DELETE,SELF_TOKEN_GRANT_INSERT,SELF_DOMAIN_INSERT,SELF_DOMAIN_SELECT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_SUBDOMAIN_SELECT,SELF_SUBDOMAIN_UPDATE,SELF_SUBDOMAIN_INSERT,SELF_SUBDOMAIN_DELETE,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE,SELF_SERVICE_DELETE,SELF_SERVICE_INSERT,SELF_SERVICE_SELECT,SELF_SERVICE_UPDATE,SELF_APP_INSERT,SELF_APP_DELETE,SELF_APP_UPDATE,SELF_APP_SELECT,SELF_BILL_SELECT,SELF_BILL_INSERT,SELF_STORAGE_SELECT,SELF_STORAGE_UPDATE,SELF_STORAGE_DELETE,SELF_STORAGE_INSERT,SELF_LOG_SELECT,SELF_LOG_INSERT,SELF_LOG_UPDATE,SELF_LOG_DELETE,SELF_BACKUP_SELECT,SELF_BACKUP_UPDATE,SELF_BACKUP_INSERT,SELF_BACKUP_DELETE'));
	break;
	case 'apps':
		api::send('self/token/add', array('name'=>$_POST['name'], 'lease'=>'never', 'grants'=>'ACCESS,SELF_APP_INSERT,SELF_APP_SELECT,SELF_APP_UPDATE,SELF_APP_DELETE'));
	break;
	case 'services':
		api::send('self/token/add', array('name'=>$_POST['name'], 'lease'=>'never', 'grants'=>'ACCESS,SELF_SERVICE_INSERT,SELF_SERVICE_SELECT,SELF_SERVICE_UPDATE,SELF_SERVICE_DELETE'));
	break;
	case 'domains':
		api::send('self/token/add', array('name'=>$_POST['name'],  'lease'=>'never', 'grants'=>'ACCESS,SELF_DOMAIN_INSERT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_DOMAIN_SELECT,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE'));
	break;
	case 'blank':
		api::send('self/token/add', array('name'=>$_POST['name'], 'lease'=>'never'));
	break;
}

if( isset($_GET['redirect']) )
	template::redirect($_GET['redirect']);
else
	template::redirect('/panel/settings/tokens');

?>