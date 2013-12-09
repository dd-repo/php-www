<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$bill = api::send('self/bill/list', array('id'=>$_GET['id']));
$bill = $bill[0];
$userinfo = api::send('self/whoami');
$userinfo = $userinfo[0];
	
$status = $bill['status'];
			
$content = "
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['title']}</h5></div>
				<div style=\"float: left; width: 200px; margin: 20px;\">
					<strong>S.Y.S. SAS</strong><br />
					19 chemin de Ch&acirc;teau Gombert<br />
					13013 Marseille, France
				</div>
				<div style=\"float: right; width: 200px; margin: 20px;\">
					<strong>{$userinfo['firstname']} {$userinfo['lastname']}</strong><br />
					{$userinfo['email']}
				</div>
				<div style=\"clear: both;\"></div>
				<div class=\"widget first\">
					<div class=\"head\">
						<h5 class=\"iFrames\">{$bill['name']}</h5>
						<div class=\"icon\"><a href=\"/panel/billing/pdf?id={$_GET['id']}\" title=\"\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/download3.png\" alt=\"\" /></a></div>
					</div>
					<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" class=\"tableStatic\">
						<thead>
							<tr>
								<td>{$lang['service']}</td>
								<td>{$lang['description']}</td>
								<td>{$lang['time']}</td>
								<td>{$lang['number']}</td>
								<td>{$lang['price']}</td>
								<td>{$lang['vat']}</td>
								<td>{$lang['total_et']}</td>
							</tr>
						</thead>
						<tbody>
";

if( count($bill['services']) > 0 )
{
	$vat = array();
	foreach( $bill['services'] as $s )
	{
		$content .= "
							<tr class=\"gradeA\">
								<td>{$s['name']}</td>
								<td>{$s['description']}</td>
		";
		if( $s['from'] > 10000 && $s['to'] > 10000 )
			$content .= "<td>{$lang['from']} ".date('d/m/Y', $s['from'])." {$lang['to']} ".date('d/m/Y', $s['to'])."</td>";
		else
			$content .= "<td></td>";
	
	$content .= "
								<td>{$s['count']}</td>
								<td align=\"right\">".number_format($s['price'], 2, ',', ' ')." &euro;</td>
								<td>".number_format($s['vat'], 2, ',', ' ')."%</td>
								<td align=\"right\">".number_format($s['total'], 2, ',', ' ')." &euro;</td>
							</tr>
		";
	}
}
	
$content .= "
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>{$lang['total_et']}</td>
								<td align=\"right\">".number_format($bill['total_et'], 2, ',', ' ')." &euro;</td>						
							</tr>
";

foreach( $bill['vats'] as $key => $value )
{
	$content .= "

							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>{$lang['total_vat']} (".number_format($key, 2, ',', ' ')."%)</td>
								<td align=\"right\">".number_format($value, 2, ',', ' ')." &euro;</td>						
							</tr>
	";
}

$content .= "
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>{$lang['total_it']}</td>
								<td align=\"right\">".number_format($bill['total_it'], 2, ',', ' ')." &euro;</td>						
							</tr>
						</tbody>
					</table>									
				</div>
				<p>{$lang['date']} <strong>" . date('Y-m-d H:i:s', $bill['date']) . "</strong><br />
				{$lang['status']} <strong>[ " . $lang['status_' . $status] . " ] </strong></p>
";
if( $status == 0 )
{
//	$content .= "<a href=\"/panel/bill/pay?id={$_GET['id']}\" title=\"\" class=\"btnIconLeft mr10 mt5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/cart.png\" alt=\"\" class=\"icon\" /><span>{$lang['pay']}</span></a>";
}
$content .= "
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>