<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$quotas =  api::send('self/quota/user/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'APPS' )
		$aquota = $q;
	if( $q['name'] == 'MEMORY' )
		$mquota = $q;
}

if( $mquota['max'] == 0 && $aquota['max'] == 0 )
	template::redirect('/panel/plans');

$bills = api::send('self/bill/list');

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\">

					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
";

if( count($bills) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th style=\"text-align: center; width: 50px;\">#</th>
							<th>{$lang['name']}</th>
							<th>{$lang['ref']}</th>
							<th>{$lang['date']}</th>
							<th>{$lang['amount']}</th>
							<th>{$lang['status']}</th>
						</tr>
	";

	foreach( $bills as $b )
	{
		$month = date('F', $b['date']);
		$month_translate = $lang[$month];

		$content .= "
				<tr>
					<td tyle=\"text-align: center; width: 50px;\"><a href=\"/panel/billing/view?id={$b['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/doc.png\" alt=\"\" style=\"display: block; padding-top: 5px; margin: 0 auto;\"/></a></td>
					<td>{$b['name']}</td>
					<td>{$b['reference']}</td>
					<td>".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $b['date']))."</td>
					<td>{$b['amount_ati']} &euro;</td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/status_{$b['status']}.png\" alt=\"\" style=\"display: block; padding: 0 10px 0 0; margin: 0 auto; float: left;\"/>".$lang['status_'.$b['status']]."</td>
				</tr>
		";
	}
	$content .= "			</table>";
}
else
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['nobill']}</span><br /><br />
					<a class=\"button classic\" href=\"/doc/billing\" style=\"width: 140px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>
";
	
}
	
$content .= "
				<div class=\"clear\"></div>
				<br /><br />
				</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
