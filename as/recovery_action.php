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
		$result = api::send('user/list', array('auth'=>'', 'user'=>$_POST['username']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
		foreach( $result as $r )
		{
			if( $r['name'] == $_POST['username'] )
			{
				if( strlen($r['email']) < 5 )
					throw new Exception("Bad email");
				
				$tokenresult = api::send('token/insert', array('user'=>$r['id'], 'lease'=>time()+10800, 'name'=>'Recovery', 'grants'=>'ACCESS,SELF_UPDATE,SELF_SELECT,SELF_GRANT_SELECT,SELF_TOKEN_SELECT,SELF_TOKEN_UPDATE,SELF_TOKEN_GRANT_INSERT,SELF_TOKEN_GRANT_DELETE'), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
				$token = $tokenresult['token'];
				
				$email = str_replace(array('{USER}', '{TOKEN}'), array($_POST['username'], $token), $lang['content']);
				$result = mail($r['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['email_title'], $email), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
				
				if( $result === false )
				{
					$_SESSION['MESSAGE']['TYPE'] = 'error';
					$_SESSION['MESSAGE']['TEXT']= $lang['mailerror'];		
				}
				else
				{
					$_SESSION['MESSAGE']['TYPE'] = 'success';
					$_SESSION['MESSAGE']['TEXT']= $lang['success'];	
				}
				
				template::redirect('/recovery');
			}
		}
		throw new Exception("User not found");
	}
	catch(Exception $e)
	{
			$_SESSION['MESSAGE']['TYPE'] = 'error';
			$_SESSION['MESSAGE']['TEXT']= $lang['nouser'];	
			template::redirect('/recovery');			
	}
}

template::redirect('/recovery');

?>