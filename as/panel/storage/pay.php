<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\" style=\"text-align: center;\">
			<br />
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
						<input type=\"hidden\" name=\"item_name\" value=\"".$lang['offer_' . security::encode($_GET['plan']) . '_title']."\" />
						<input type=\"hidden\" name=\"amount\" value=\"".$lang['offer_' . security::encode($_GET['plan']) . '_price']."\" />
						<input type=\"hidden\" name=\"return\" value=\"https://www.anotherservice.com/panel/plans/landing\" />
						<input type=\"hidden\" name=\"cancel_return\" value=\"https://www.anotherservice.com/panel/plans/landing\" />
						<input type=\"hidden\" name=\"notify_url\" value=\"https://www.anotherservice.com/ipn_paypal\" />
						<input type=\"hidden\" name=\"custom\" value=\"{$userinfo['mail']} {$userinfo['name']} ".security::encode($_GET['plan'])."\" />
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
				<div class=\"clear\"></div><br /><br />
			</div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>