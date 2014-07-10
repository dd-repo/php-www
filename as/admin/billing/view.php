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
			<div class=\"right\" style=\"width: 500px; float: right; text-align: right;\">
				<a class=\"action edit\" href=\"#\" onclick=\"$('#add').dialog('open'); return false;\">
					{$lang['add']}
				</a>
				<a class=\"action push\" href=\"#\" onclick=\"$('#send').dialog('open'); return false;\">
					{$lang['send']}
				</a>
				<a class=\"action print\" href=\"#\" onclick=\"window.print(); return false;\">
					{$lang['print']}
				</a>
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
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\">{$lang['total_ati']}</td>
					<td style=\"padding-top: 12px;\">{$bill['amount_ati']} &euro;</td>
					<td style=\"padding-top: 12px;\"></td>
				</tr>
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\">&nbsp;</td>
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
					<th></th>
				</tr>
";

foreach( $vats as $key => $value )
{
	if( $value['vat'] != 0 )
	{
		$content .= "
				<tr>
					<td style=\"text-align: center;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\"></td>
					<td style=\"padding-top: 12px;\">{$lang['vat']} ({$key}%)</td>
					<td style=\"padding-top: 12px;\">{$value['et']} &euro;</td>
					<td style=\"padding-top: 12px;\">{$value['vat']} &euro;</td>
					<td style=\"padding-top: 12px;\"></td>
				</tr>
		";
	}
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
		<div class=\"form-small\">		
			<form action=\"/admin/billing/pay_action\" method=\"get\" class=\"center\">
				<input id=\"id\" type=\"hidden\" value=\"{$bill['id']}\" name=\"id\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['confirm']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"send\" style=\"text-align: center;\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['send']}</h3>
		<p style=\"text-align: center;\">{$lang['send_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/billing/pay_action\" method=\"get\" class=\"center\">
				<input id=\"id\" type=\"hidden\" value=\"{$bill['id']}\" name=\"id\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['confirm']}\" />
				</fieldset>
			</form>
		</div>
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
						<option value=\"10\">10%</option>
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
		newFlexibleDialog('add', 550);
		newFlexibleDialog('send', 550);
		newFlexibleDialog('pay', 550);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>