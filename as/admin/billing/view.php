<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$bill = api::send('bill/list', array('id'=>$_GET['id']));
$bill = $bill[0];

$month = date('F', $bill['date']);
$month_translate = $lang[$month];

$userinfo = api::send('user/list', array('user'=>$bill['user']['id']));
$userinfo = $userinfo[0];

$vats = array();
$credits = 0;
foreach( $bill['lines'] as $l )
	$vats[$l['vat']] = $vats[$l['vat']]+($l['amount_ati']-$l['amount_et']);

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
				<a class=\"action edit\" href=\"#\" onclick=\"$('#add').dialog('open'); return false;\">
					{$lang['add']}
				</a>
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
						<span style=\"font-weight: bold; font-size: 18px;\">{$userinfo['name']}</span><br />
						".($userinfo['firstname']?"{$userinfo['firstname']} {$userinfo['lastname']}<br />":"")."
						".($userinfo['address']?str_replace("\n", "<br />", $userinfo['address']):"")."
						<a href=\"mailto:{$userinfo['user_mail']}\">{$userinfo['user_mail']}</a>
					</p>
				</div>
				<div style=\"float: right;\">
					<p>
						<span style=\"font-weight: bold; font-size: 18px;\">Another Service</span><br />
						40 Bis Rue du Faubourg Poissonni&egrave;re<br />
						75010 Paris FRANCE<br />
						<a href=\"mailto:contact@anotherservice.com\">contact@anotherservice.com</a><br />
						SIRET 521 745 935 00010
					</p>
				</div>
				<div class=\"clear\"></div>
			</div>
			<br />
			<p style=\"font-size: 18px;\">Paris, {$lang['the']} ".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $bill['date']))."</i></p></td>
			<div class=\"clear\"></div><br />
			<h2 class=\"dark thin\">
				{$bill['name']}<br />
				<span style=\"font-size: 12px;\">{$bill['reference']}</span>
			</h2>
			<table>
				<tr>
					<th></th>
					<th>{$lang['name']}</th>
					<th>{$lang['description']}</th>
					<th>{$lang['amount_et']}</th>
					<th>{$lang['vat']}</th>
					<th>{$lang['amount_ati']}</th>
					<th style=\"text-align: center;\">{$lang['actions']}</th>
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
					<td style=\"padding-top: 12px; text-align: center;\">
						".($l['amount_et']>0?"<a href=\"/admin/billing/reverse_action?id={$bill['id']}&title={$l['name']}&amount={$l['amount_et']}&vat={$l['vat']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/arrowLeft.png\" alt=\"\" /></a>":"")."
						<a href=\"/admin/billing/delete_action?id={$bill['id']}&lid={$l['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
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
					<td style=\"padding-top: 12px;\"></td>
				</tr>
";

foreach( $vats as $key => $value )
{
	$content .= "
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\">{$lang['vat']} ({$key}%)</td>
					<td style=\"padding-top: 12px;\">{$value} &euro;</td>
					<td style=\"padding-top: 12px;\"></td>
				</tr>
	";
}	

$content .= "
				<td style=\"text-align: center;\"></td>
				<td style=\"padding-top: 12px;\"></td>
				<td style=\"padding-top: 12px;\"></td>
				<td style=\"padding-top: 12px;\"></td>
				<td style=\"padding-top: 12px;\">{$lang['total_ati']}</td>
				<td style=\"padding-top: 12px;\">{$bill['amount_ati']} &euro;</td>
				<td style=\"padding-top: 12px;\"></td>
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
	<div id=\"add\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['add']}</h3>
		<div class=\"form-small\">		
			<form action=\"/admin/billing/add_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$bill['id']}\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['title']}\" name=\"title\" onfocus=\"this.value = this.value=='{$lang['title']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['title']}' : this.value; this.value=='{$lang['title']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['tiptitle']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['desc']}\" name=\"desc\" onfocus=\"this.value = this.value=='{$lang['desc']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['desc']}' : this.value; this.value=='{$lang['desc']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['tipdesc']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['amount']}\" name=\"amount\" onfocus=\"this.value = this.value=='{$lang['amount']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['amount']}' : this.value; this.value=='{$lang['amount']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['tipamount']}</span>
				</fieldset>
				<fieldset>
					<select name=\"vat\">
						<option value=\"20\">20%</option>
						<option value=\"5.5\">5.5%</option>
						<option value=\"0\">0%</option>
					</select>
					<span class=\"help-block\">{$lang['tipvat']}</span>
				</fieldset>
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('pay', 550);
		newFlexibleDialog('add', 550);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>