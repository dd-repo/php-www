<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$bill = api::send('self/bill/list', array('id'=>$_GET['id']));
$bill = $bill[0];

$month = date('F', $bill['date']);
$month_translate = $lang[$month];

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$vats = array();
$credits = 0;

foreach( $bill['lines'] as $l )
{
	$vats[$l['vat']]['vat'] = $vats[$l['vat']]['vat']+($l['amount_ati']-$l['amount_et']);
	$vats[$l['vat']]['et'] = $vats[$l['vat']]['et']+$l['amount_et'];
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\">
				<h1 class=\"dark\">{$lang['bill']}</h1>
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/status_{$bill['status']}.png\" alt=\"\" style=\"display: block; padding: 0 10px 0 0; margin: 0 auto; float: left;\" />
				<span style=\"padding-top: 0px; display: block;\">".$lang['status_'.$bill['status']]."</span>
			</div>
			<div class=\"right\" style=\"float: right; text-align: right;\">
";

if( $bill['status'] == 1 )
{
	$content .= "
				<a class=\"action pay\" href=\"#\" onclick=\"$('#pay').dialog('open'); return false;\">
					{$lang['pay']}
				</a>
	";
}
else
{
		$content .= "
				<a class=\"action print\" href=\"#\" onclick=\"window.print(); return false;\">
					{$lang['print']}
				</a>
		";
}

$content .= "	
			</div>
			<div class=\"clear\"></div>
		</div>
		<br />
		<div class=\"container\">
			<div style=\"padding: 5px 10px 5px 10px; border: 1px solid #e7e7e7;\">
				<div style=\"float: left;\">
					<p>
						<span style=\"font-weight: bold; font-size: 18px;\">Another Service</span><br />
						45 rue Joliot Curie<br />
						13382 Marseille CEDEX 13<br />
						FRANCE<br />
						SIRET 521745935 00010 - TVA FR33 521745935
					</p>
				</div>
				<div style=\"float: right;\">
					<p>
						<span style=\"font-weight: bold; font-size: 18px;\">{$userinfo['organisation']}</span><br />
						".($userinfo['firstname']?"{$userinfo['firstname']} {$userinfo['lastname']}<br />":"")."
						".($userinfo['postal_address']?str_replace("\n", "<br />", $userinfo['postal_address'])."<br />":"")."
						".($userinfo['postal_code']?"{$userinfo['postal_code']}":"")."
						".($userinfo['locality']?"{$userinfo['locality']}<br />":"")."
					</p>
				</div>
				<div class=\"clear\"></div>
			</div>
			<br />
			<p style=\"font-size: 18px;\">Paris, {$lang['the']} ".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $bill['date']))."</i></p></td>
			<div class=\"clear\"></div><br />
			<h2 class=\"dark thin\">
				{$bill['name']}<br />
				<span style=\"font-size: 12px;\">".str_replace($month, $month_translate, $bill['reference'])."</span>
			</h2>
			<table>
				<tr>
					<th></th>
					<th>{$lang['name']}</th>
					<th>{$lang['description']}</th>
					<th>{$lang['amount_et']}</th>
					<th>{$lang['vat']}</th>
					<th>{$lang['amount_ati']}</th>
				</tr>
";
foreach( $bill['lines'] as $l )
{
	$content .= "
				<tr>
					<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/tag.png\" alt=\"\" style=\"display: block; margin: 0 auto;\"/></td>
					<td style=\"padding-top: 12px;\">{$l['name']}</td>
					<td style=\"padding-top: 12px;\">{$l['description']}</td>
					<td style=\"padding-top: 12px;\">{$l['amount_et']} &euro;</td>
					<td style=\"padding-top: 12px;\">".($l['amount_et']>0?"{$l['vat']}%":"")."</td>
					<td style=\"padding-top: 12px;\">".($l['amount_et']>0?"{$l['amount_ati']} &euro;":"")."</td>
				</tr>
	";
}

$content .= "
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\">{$lang['total_et']}</td>
					<td style=\"padding-top: 12px;\">{$bill['amount_et']} &euro;</td>
				</tr>
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\">{$lang['total_ati']}</td>
					<td style=\"padding-top: 12px;\">{$bill['amount_ati']} &euro;</td>
				</tr>
				<tr>
					<td style=\"text-align: center;\">&nbsp;</td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
				</tr>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th>{$lang['vat']}</th>
					<th>{$lang['base']}</th>
					<th>{$lang['totalvat']}</th>
				</tr>
";

foreach( $vats as $key => $value )
{
	$content .= "
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\">{$lang['vat']} ({$key}%)</td>
					<td style=\"padding-top: 12px;\">{$value['et']} &euro;</td>
					<td style=\"padding-top: 12px;\">{$value['vat']} &euro;</td>
				</tr>
	";
}	

$content .= "	
			</table>
		</div>
	</div>
";

$pay = array('bill'=>$bill['id'], 'lang'=>translator::getLanguage(), 'ip'=>$_SERVER['REMOTE_ADDR'], 'email'=>$userinfo['email'], 'user'=>$userinfo['name']);
$xpay = base64_encode(serialize($pay));

$content .= "
	<div id=\"pay\" style=\"text-align: center;\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['pay']}</h3>
		<p style=\"text-align: center;\">{$lang['pay_text']}</p>
		<a class=\"action card big\" style=\"margin-right: 10px;\"href=\"#\" onclick=\"$('#sips').submit(); return false;\">
			{$lang['card']}
		</a>
		<a class=\"action paypal big\" href=\"#\" onclick=\"$('#paypal').submit(); return false;\">
			{$lang['paypal']}
		</a>
		<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" id=\"paypal\" style=\"display: none;\">
			<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />
			<input type=\"hidden\" name=\"business\" value=\"contact@anotherservice.com\" />  
			<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">  
			<input type=\"hidden\" name=\"item_name\" value=\"{$bill['lines'][0]['description']}\" />
			<input type=\"hidden\" name=\"amount\" value=\"".round($bill['amount_ati'], 2)."\" />
			<input type=\"hidden\" name=\"return\" value=\"http://{$GLOBALS['CONFIG']['HOSTNAME']}/panel/billing\" />
			<input type=\"hidden\" name=\"cancel_return\" value=\"http://{$GLOBALS['CONFIG']['HOSTNAME']}/panel/billing\" />
			<input type=\"hidden\" name=\"notify_url\" value=\"https://www.anotherservice.com/ipn_paypal\" />
			<input type=\"hidden\" name=\"custom\" value=\"{$xpay}\" />
			<input style=\"width: 118px; height: 47px;\" type=\"image\" src=\"https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif\" border=\"0\" name=\"submit\" />
			<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif\" width=\"1\" height=\"1\" />
		</form>
		<form action=\"/panel/billing/pay\" method=\"post\" id=\"sips\" style=\"display: none;\">
			<input type=\"hidden\" name=\"xpay\" value=\"{$xpay}\" />
			<input type=\"hidden\" name=\"amount\" value=\"".str_replace('.', '', sprintf("%.2f", round($bill['amount_ati'], 2)))."\" />
			<input type=\"hidden\" name=\"desc\" value=\"".str_replace(' ', '&nbsp;', $bill['lines'][0]['description'])."\" />
		</form>	
		<br /><br />
	</div>
	<script>
		newFlexibleDialog('pay', 550);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
