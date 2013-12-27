<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( strlen($_GET['code']) < 2 || !isset($_GET['user']) || !isset($_GET['email']) )
	throw new SiteException('Invalid or missing arguments', 400, 'Parameter code or user is not present');
	
// CONNECT TO THE API AS ADMIN TO CHECK REGISTRATION
$result = api::send('registration/select', array('user'=>$_GET['user'], 'code'=>$_GET['code'], 'email'=>$_GET['email']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
if( count($result) == 0 )
	throw new SiteException('Invalid user/code', 400, 'No registration matches for this user/code');
if( $result[0]['date'] < (time() - 864000) ) // 10 days
	throw new SiteException('Outdated registration', 400, 'The registration is outdated : ' . date('Y-n-j', $result[0]['date']));

// REGISTRATION IS OK -> DELETE REGISTRATION
api::send('registration/delete', array('user'=>$_GET['user']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

// INSERT USER WITH RANDOM PASSWORD
$chars = "23456789abdefghjknpqtyABCDEFGHJKLNPRSTUVXYZ";
$pass = '';
for( $i = 0; $i < 12; $i++ ) $pass .= $chars{mt_rand(0,strlen($chars)-1)};
$result = api::send('user/add', array('user'=>$_GET['user'], 'pass'=>$pass, 'email'=>$_GET['email'], 'ip'=>$_SERVER['HTTP_X_REAL_IP'], 'firstname'=>'', 'lastname'=>'', 'language'=>translator::getLanguage()), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$uid = $result['id'];

// INSERT THE USER IN THE USERS GROUP
api::send('group/user/add', array('user'=>$uid, 'group'=>'USERS'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

// CREATE THE FIRST TOKEN WITH BASIC ACCESS
$result = api::send('token/insert', array('user'=>$uid, 'lease'=>'never', 'name'=>'Another Service', 'grants'=>'ACCESS,SELF_SELECT,SELF_UPDATE,SELF_DELETE,SELF_GRANT_SELECT,SELF_GROUP_SELECT,SELF_GROUP_DELETE,SELF_TOKEN_INSERT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_DELETE,SELF_QUOTA_SELECT,SELF_TOKEN_GRANT_DELETE,SELF_TOKEN_GRANT_INSERT,SELF_DOMAIN_INSERT,SELF_DOMAIN_SELECT,SELF_DOMAIN_DELETE,SELF_DOMAIN_UPDATE,SELF_SUBDOMAIN_SELECT,SELF_SUBDOMAIN_UPDATE,SELF_SUBDOMAIN_INSERT,SELF_SUBDOMAIN_DELETE,SELF_ACCOUNT_DELETE,SELF_ACCOUNT_INSERT,SELF_ACCOUNT_SELECT,SELF_ACCOUNT_UPDATE,SELF_SERVICE_DELETE,SELF_SERVICE_INSERT,SELF_SERVICE_SELECT,SELF_SERVICE_UPDATE,SELF_APP_INSERT,SELF_APP_DELETE,SELF_APP_UPDATE,SELF_APP_SELECT,SELF_BILL_SELECT,SELF_BILL_INSERT,SELF_STORAGE_SELECT,SELF_STORAGE_UPDATE,SELF_STORAGE_DELETE,SELF_STORAGE_INSERT'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$token = $result['token'];

// ADD USER QUOTAS
api::send('quota/user/add', array('user'=>$uid, 'quotas'=>'APPS,DOMAINS,SERVICES,MEMORY,DISK'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'APPS', 'max'=>200), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'DOMAINS', 'max'=>50), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'SERVICES', 'max'=>4), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'MEMORY', 'max'=>1024), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
api::send('quota/user/update', array('user'=>$uid, 'quota'=>'DISK', 'max'=>1000), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

// OUTPUT USER INFO
$content .= "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<p class=\"large\">{$lang['success']}</p>
			<p class=\"large\">".str_replace(array('{USER}','{TOKEN}','{PASS}'), array($_GET['user'], $token, $pass), $lang['user'])."</p>
			<br />
			<a class=\"btn\" href=\"/login\">{$lang['login']}</a>
		</div>
	</div>
<!-- Google Code for Nouveau compte Conversion Page -->
<script type=\"text/javascript\">
/* <![CDATA[ */
var google_conversion_id = 998104197;
var google_conversion_language = \"en\";
var google_conversion_format = \"3\";
var google_conversion_color = \"ffffff\";
var google_conversion_label = \"q-ZJCJP36AMQhbn32wM\";
var google_conversion_value = 30;
/* ]]> */
</script>
<script type=\"text/javascript\" src=\"https://www.googleadservices.com/pagead/conversion.js\">
</script>
<noscript>
<div style=\"display:inline;\">
<img height=\"1\" width=\"1\" style=\"border-style:none;\" alt=\"\" src=\"https://www.googleadservices.com/pagead/conversion/998104197/?value=30&amp;label=q-ZJCJP36AMQhbn32wM&amp;guid=ON&amp;script=0\"/>
</div>
</noscript>

";

// SEND MAIL
$mail = "{$lang['success']}<br /><br />".str_replace(array('{USER}','{TOKEN}','{PASS}'), array($_GET['user'], $token, $pass), $lang['user']).$lang['thanks'];
$result = mail($_GET['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['subject'], $lang['mailstart'].$mail.$lang['mailend']), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\nBcc: contact@anotherservice.com\r\n");

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>