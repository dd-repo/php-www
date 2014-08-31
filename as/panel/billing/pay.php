<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$sips_params  = "merchant_id=052174593500010";
$sips_params .= " pathfile=/dns/com/anotherservice/etc/sips/pathfile";
$sips_params .= " merchant_country=fr";
$sips_params .= " language=fr";
$sips_params .= " amount=".security::encode($_POST['amount']);
$sips_params .= " currency_code=978";
$sips_params .= " transaction_id=" . date("His");
$sips_params .= " customer_email=" . $userinfo['email'];
$sips_params .= " customer_ip_address=42.42.42.42";
$sips_params .= " caddie=" . security::encode($_POST['xpay']);
$sips_params .= " cancel_return_url=https://www.anotherservice.com/panel/billing";
$sips_params .= " automatic_response_url=https://www.anotherservice.com/ipn_sips";
$sips_params .= " normal_return_url=https://www.anotherservice.com/panel/billing";
//$sips_params .= " templatefile=template_fr";

try
{
	$sips_params = escapeshellcmd($sips_params);
	$result = exec("/dns/com/anotherservice/etc/sips/request {$sips_params}");
	$result = explode ('!', $result);
	$code    = $result[1];
	$error   = $result[2];
	$message = $result[3];
}
catch( Exception $e )
{
	print_r($e);
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<h1 class=\"dark\" style=\"text-align: center;\">{$lang['payment']}</h1>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\" style=\"text-align: center;\">
			{$message}
		</div>
	</div>
			
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>