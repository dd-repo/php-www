<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$_SESSION['JOIN_USER'] = $_POST['username'];
$_SESSION['JOIN_EMAIL'] = $_POST['email'];

api::send('registration/add', array('auth'=>'', 'user'=>$_POST['username'], 'email'=>$_POST['email'], 'invitation'=>$_POST['code']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
	
$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<h2>{$lang['payment']}</h2>
			<p>{$lang['payment_text']}</p>
			<br />
			
			<div style=\"float: left; width: 330px; text-align: center;\">
				<h3 class=\"colored\">{$lang['paypal']}</h3>
				<br />
				<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" id=\"paypal\">
					<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />
					<input type=\"hidden\" name=\"business\" value=\"contact@anotherservice.com\" />  
					<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">  
					<input type=\"hidden\" name=\"item_name\" value=\"".$lang['offer_' . security::encode($_POST['plan']) . '_title']."\" />
					<input type=\"hidden\" name=\"amount\" value=\"".$lang['offer_' . security::encode($_POST['plan']) . '_price']."\" />
					<input type=\"hidden\" name=\"return\" value=\"https://www.anotherservice.com/join/landing\" />
					<input type=\"hidden\" name=\"cancel_return\" value=\"https://www.anotherservice.com/join/landing\" />
					<input type=\"hidden\" name=\"notify_url\" value=\"https://www.anotherservice.com/ipn_paypal\" />
					<input type=\"hidden\" name=\"custom\" value=\"".security::encode($_POST['email'])." ".security::encode($_POST['username'])."\" />
					<input style=\"width: 118px; height: 47px;\" type=\"image\" src=\"https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif\" border=\"0\" name=\"submit\" />
					<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif\" width=\"1\" height=\"1\" />
				</form>
			</div>
			<div style=\"float: left; width: 330px; text-align: center;\">
				<h3 class=\"colored\">{$lang['card']}</h3>
				<br />
				<p><i>Prochainement</i></p>
			</div>
			<div style=\"float: left; width: 330px; text-align: center;\">
				<h3 class=\"colored\">{$lang['transfer']}</h3>
				<br />
				<p><i>Prochainement</i></p>
			</div>
			<div class=\"clearfix\"></div>
			<br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>