<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

try 
{
	$_SESSION['JOIN_USER'] = $_POST['username'];
	$_SESSION['JOIN_EMAIL'] = $_POST['email'];
	$_SESSION['JOIN_PLAN'] = $_POST['plan'];

	$registration = api::send('registration/add', array('auth'=>'', 'user'=>$_POST['username'], 'plan' => $_POST['plan'], 'email'=>$_POST['email'], 'invitation'=>$_POST['code']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
}
catch( Exception $e )
{
	$template->redirect($_SERVER['HTTP_REFERER'] . (strstr($_SERVER['HTTP_REFERER'], 'eregisteradd')===false?"?eregisteradd":""));
}

if( $_POST['plan'] == '99' )
{	
	$email = str_replace(array('{USER}', '{EMAIL}', '{CODE}'), array(security::encode($_POST['username']), security::encode($_POST['email']), $registration['code']), $lang['content']);
	mail($_POST['email'], $lang['subject'], str_replace(array('{TITLE}', '{CONTENT}'), array($lang['email_title'], $email), $GLOBALS['CONFIG']['MAIL_TEMPLATE']), "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: Another Service <no-reply@anotherservice.com>\r\n");
}

$content = "
		<div class=\"head\">
			<div class=\"container\" style=\"width: 1100px; margin: 0 auto; padding: 40px 0 40px 0;\">
				<h1>{$lang['title']}</h1>
			</div>
		</div>
		<div class=\"content\" style=\"text-align: center;\">
			<br />
";
if( $_POST['plan'] != '99' )
{
	$content .= "
			<p style=\"font-size: 18px;\">{$lang['payment_text']}</p>
			<br />
			<br />
			<div style=\"text-align: center;\">
				<div class=\"pay\" onclick=\"$('#paypal').submit(); return false;\">
					<h3 class=\"colored\">{$lang['paypal']}</h3>
					<br />
					<form id=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" id=\"paypal\" style=\"display: none;\">
						<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />
						<input type=\"hidden\" name=\"business\" value=\"contact@anotherservice.com\" />  
						<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">  
						<input type=\"hidden\" name=\"item_name\" value=\"".$lang['offer_' . security::encode($_POST['plan']) . '_title']."\" />
						<input type=\"hidden\" name=\"amount\" value=\"".$lang['offer_' . security::encode($_POST['plan']) . '_price']."\" />
						<input type=\"hidden\" name=\"return\" value=\"https://www.anotherservice.com/join/landing\" />
						<input type=\"hidden\" name=\"cancel_return\" value=\"https://www.anotherservice.com/join/landing\" />
						<input type=\"hidden\" name=\"notify_url\" value=\"https://www.anotherservice.com/ipn_paypal\" />
						<input type=\"hidden\" name=\"custom\" value=\"".security::encode($_POST['email'])." ".security::encode($_POST['username'])."\" />
						<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif\" width=\"1\" height=\"1\" />
					</form>
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/paypal.png\" style=\"width: 150px;\" alt=\"\" />
				</div>
				<div class=\"pay\">
					<h3 class=\"colored\" style=\"color: #6a6a6a\">{$lang['card']}</h3>
					<br />
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/card_disabled.png\" style=\"width: 150px;\" alt=\"\" />
				</div>
				<div class=\"pay\">
					<h3 class=\"colored\" style=\"color: #6a6a6a\">{$lang['transfer']}</h3>
					<br />
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/transfer_disabled.png\" style=\"width: 150px;\" alt=\"\" />
				</div>
				<div class=\"clear\"></div><br />
			</div>
		";
}
else
{
	$content .= "{$lang['free_text']}";
}
$content .= "
		</div>
		<br />
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>