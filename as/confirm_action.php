<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try
{
	if( !isset($_POST['code']) || !isset($_POST['email']) )
		throw new SiteException('Invalid or missing arguments', 400, 'Parameter code or email is not present');
		
	$result = api::send('registration/select', array('code'=>$_POST['code']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

	if( count($result) == 0 )
		throw new SiteException('Invalid user/code', 400, 'No registration matches for this user/code');
	if( $result[0]['date'] < (time() - 864000) ) // 10 days
		throw new SiteException('Outdated registration', 400, 'The registration is outdated : ' . date('Y-n-j', $result[0]['date']));

	// INSERT USER
	$result = api::send('user/add', array('user'=>$_POST['username'], 'pass'=>$_POST['password'], 'email'=>$_POST['email'], 'ip'=>$_SERVER['HTTP_X_REAL_IP'], 'firstname'=>'', 'lastname'=>'', 'language'=>translator::getLanguage()), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$uid = $result['id'];

	// REGISTRATION IS OK -> DELETE REGISTRATION
	api::send('registration/delete', array('code'=>$_POST['code']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

	// INSERT THE USER IN THE USERS GROUP
	api::send('group/user/add', array('user'=>$uid, 'group'=>'USERS'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

	// CREATE THE FIRST TOKEN WITH BASIC ACCESS
	$result = api::send('token/insert', array('user'=>$uid, 'lease'=>'never', 'name'=>'Another Service', 'grants'=>'ACCESS,SELF_SELECT,SELF_UPDATE,SELF_DELETE,SELF_GRANT_SELECT,SELF_GROUP_SELECT,SELF_GROUP_DELETE,SELF_TOKEN_INSERT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_DELETE,SELF_QUOTA_SELECT,SELF_TOKEN_GRANT_DELETE,SELF_TOKEN_GRANT_INSERT,SELF_DOMAIN_INSERT,SELF_DOMAIN_SELECT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_SUBDOMAIN_SELECT,SELF_SUBDOMAIN_UPDATE,SELF_SUBDOMAIN_INSERT,SELF_SUBDOMAIN_DELETE,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE,SELF_SERVICE_DELETE,SELF_SERVICE_INSERT,SELF_SERVICE_SELECT,SELF_SERVICE_UPDATE,SELF_APP_INSERT,SELF_APP_DELETE,SELF_APP_UPDATE,SELF_APP_SELECT,SELF_BILL_SELECT,SELF_BILL_INSERT,SELF_STORAGE_SELECT,SELF_STORAGE_UPDATE,SELF_STORAGE_DELETE,SELF_STORAGE_INSERT,SELF_LOG_SELECT,SELF_LOG_INSERT,SELF_LOG_UPDATE,SELF_LOG_DELETE,SELF_BACKUP_SELECT,SELF_BACKUP_UPDATE,SELF_BACKUP_INSERT,SELF_BACKUP_DELETE'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	$token = $result['token'];

	// ADD USER QUOTAS
	api::send('quota/user/add', array('user'=>$uid, 'quotas'=>'APPS,DOMAINS,SERVICES,MEMORY,DISK'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	api::send('quota/user/update', array('user'=>$uid, 'quota'=>'APPS', 'max'=>200), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	api::send('quota/user/update', array('user'=>$uid, 'quota'=>'DOMAINS', 'max'=>200), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	api::send('quota/user/update', array('user'=>$uid, 'quota'=>'SERVICES', 'max'=>0), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	api::send('quota/user/update', array('user'=>$uid, 'quota'=>'MEMORY', 'max'=>0), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	api::send('quota/user/update', array('user'=>$uid, 'quota'=>'DISK', 'max'=>0), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

	$tracker = "<!-- Google Code for Nouveau compte Conversion Page -->
	<script type=\"text/javascript\">
	/* <![CDATA[ */
	var google_conversion_id = 998104197;
	var google_conversion_language = \"en\";
	var google_conversion_format = \"3\";
	var google_conversion_color = \"ffffff\";
	var google_conversion_label = \"q-ZJCJP36AMQhbn32wM\";
	var google_conversion_value = 1;
	/* ]]> */
	</script>
	<script type=\"text/javascript\" src=\"https://www.googleadservices.com/pagead/conversion.js\">
	</script>
	<noscript>
	<div style=\"display:inline;\">
	<img height=\"1\" width=\"1\" style=\"border-style:none;\" alt=\"\" src=\"https://www.googleadservices.com/pagead/conversion/998104197/?value=30&amp;label=q-ZJCJP36AMQhbn32wM&amp;guid=ON&amp;script=0\"/>
	</div>
	</noscript>";

	$_SESSION['MESSAGE']['TYPE'] = 'success';
	$_SESSION['MESSAGE']['TEXT']= $lang['success'] . ' ' . $tracker;

	// SEND MAIL
	$mail = "{$lang['success']}<br /><br />".str_replace(array('{USER}','{TOKEN}','{PASS}'), array(security::encode($_POST['username']), $token, htmlentities($_POST['password'])), $lang['user']).$lang['thanks'];
	mail($_POST['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $lang['mailstart'].$mail.$lang['mailend']), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
	$mail2 = "{$lang['success']}<br /><br />".str_replace(array('{USER}','{TOKEN}','{PASS}'), array(security::encode($_POST['username']), $token, '*********'), $lang['user']).$lang['thanks'];
	mail('contact@anotherservice.com', $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $lang['mailstart'].$mail2.$lang['mailend']), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
	
	template::redirect('/');
}
catch(Exception $e)
{
	$_SESSION['REGISTER']['STATUS'] = true;
	$_SESSION['REGISTER']['ID'] = security::encode($_POST['id']);
	$_SESSION['REGISTER']['EMAIL'] = security::encode($_POST['email']);
	$_SESSION['REGISTER']['ORIGIN'] = security::encode($_POST['origin']);
	
	$template->redirect(str_replace('?ecode', '', $_SERVER['HTTP_REFERER']) . (strstr($_SERVER['HTTP_REFERER'], 'eregister')===false?"?eregister":""));
}

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>