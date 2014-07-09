<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

switch( $_GET['plan'] )
{
	case '1':
		$ram = 1024;
		$services = 4;
		$disk = 1000;
		$success = true;
	break;
	case '2':
		$ram = 4096;
		$services = 16;
		$disk = 1000;
		$success = true;
	break;
	case '3':
		$ram = 8192;
		$services = 32;
		$disk = 10000;
		$success = true;
	break;
	case '4':
		$ram = 16384;
		$services = 64;
		$disk = 10000;
		$success = true;
	break;
	case '5':
		$ram = 32768;
		$services = 128;
		$disk = 50000;
		$success = true;
	break;
	case '6':
		$ram = 65536;
		$services = 256;
		$disk = 50000;
	break;
	case '8':
		$disk = 10000;
		$success = true;
		$diskplan = true;
	break;
	case '9':
		$disk = 50000;
		$success = true;	
		$diskplan = true;
	break;
	case '10':
		$disk = 100000;
		$success = true;
		$diskplan = true;
	break;
	case '11':
		$disk = 500000;
		$success = true;	
		$diskplan = true;
	break;
	case '12':
		$disk = 1000000;
		$success = true;
		$diskplan = true;
	break;	
	default:
		$success = false;
}
				
				
$quotas = api::send('self/quota/list');
foreach( $quotas as $q )
{
	if( $q['name'] == 'DISK' )
		$dquota = $q;
	if( $q['name'] == 'MEMORY' )
		$mquota = $q;
	if( $q['name'] == 'SERVICES' )
		$squota = $q;
}
				
if( ($disk && $dquota['used'] > $disk && ($dquota['max'] <= $disk || $diskplan === true) ) || ($ram && $mquota['used'] > $ram) || ($ram && $squota['used'] > $services)  )
{
	$_SESSION['MESSAGE']['TYPE'] = 'error';
	$_SESSION['MESSAGE']['TEXT']= $lang['impossible'];
	
	template::redirect($_SERVER['HTTP_REFERER']);
}

$pay = array('lang'=>translator::getLanguage(), 'first'=>1, 'ip'=>$_SERVER['REMOTE_ADDR'], 'email'=>$userinfo['email'], 'user'=>$userinfo['name'], 'plan'=>security::encode($_GET['plan']));
$xpay = base64_encode(serialize($pay));

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
						<input type=\"hidden\" name=\"custom\" value=\"{$xpay}\" />
						<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif\" width=\"1\" height=\"1\" />
					</form>
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/paypal.png\" style=\"width: 150px;\" alt=\"\" />
				</div>
				<div class=\"pay\" onclick=\"$('#sips').submit(); return false;\">
					<h3 class=\"colored\">{$lang['card']}</h3>
					<br />
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/card.png\" style=\"width: 150px;\" alt=\"\" />
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
	<form action=\"/panel/plans/card\" method=\"post\" id=\"sips\" style=\"display: none;\">
		<input type=\"hidden\" name=\"xpay\" value=\"{$xpay}\" />
		<input type=\"hidden\" name=\"amount\" value=\"2\" />
		<input type=\"hidden\" name=\"amount2\" value=\"".str_replace('.', '', sprintf("%.2f", round($lang['offer_' . security::encode($_GET['plan']) . '_price'], 2)))."\" />
		<input type=\"hidden\" name=\"desc\" value=\"".str_replace(' ', '&nbsp;', $lang['offer_' . security::encode($_GET['plan']) . '_title'])."\" />
	</form>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>