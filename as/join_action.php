<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
	
if( isset($_POST['antispam']) && $_POST['antispam'] == $_SESSION['ANTISPAM'] )
{
	try
	{
		unset($_SESSION['ANTISPAM']);
		$_SESSION['JOIN_USER'] = $_POST['username'];
		$_SESSION['JOIN_EMAIL'] = $_POST['email'];
		
		//$result = api::send('registration/add', array('auth'=>'', 'user'=>$_POST['username'], 'email'=>$_POST['email'], 'invitation'=>$_POST['code']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		
		$email = str_replace(array('{USER}', '{EMAIL}', '{CODE}'), array($_POST['username'], $_POST['email'], $result['code']), $lang['content']);
		$result = mail($_POST['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['email_title'], $email), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
		
		if( $result === false )
		{
			$_SESSION['MESSAGE']['TYPE'] = 'error';
			$_SESSION['MESSAGE']['TEXT']= $lang['mailerror'];			
		}
		else
		{
			$_SESSION['MESSAGE']['TYPE'] = 'success';
			$_SESSION['MESSAGE']['TEXT']= $lang['error_0'];
		}
	}
	catch(Exception $e)
	{
		if( $e->getCode() == 400 )
		{
			$_SESSION['MESSAGE']['TYPE'] = 'error';
			$_SESSION['MESSAGE']['TEXT']= $lang['error_1'];
		}
		else
		{
			$_SESSION['MESSAGE']['TYPE'] = 'error';
			$_SESSION['MESSAGE']['TEXT']= $lang['error_2'];
		}
	}
}
else
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['MESSAGE']= $lang['error_2'];	
}

template::redirect('/join');

?>