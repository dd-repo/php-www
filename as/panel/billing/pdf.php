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
			<div style=\"margin: 0 auto; text-align: center; font-weight: bold; font-size: 12px;\">{$lang['title']}</div>
			<br /><br />
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
				<tr>
					<td valign=\"top\" width=\"60%\">
						<strong>S.Y.S. SAS</strong><br />
						19 chemin de Ch&acirc;teau Gombert<br />
						13013 Marseille, France	<br /><br />
						SIRET 52174593500010<br />
						TVA FR33 521 745 935
					</td>
					<td valign=\"top\">
						<strong>{$userinfo['firstname']} {$userinfo['lastname']}</strong><br />
						{$userinfo['email']}					
					</td>
				</tr>
			</table>
			<br /><br />
			<strong>Facture {$bill['name']}</strong>
			<hr>
			<br /><br />			
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
				<thead>
					<tr>
						<td><strong>{$lang['service']}</strong></td>
						<td><strong>{$lang['time']}</strong></td>
						<td><strong>{$lang['number']}</strong></td>
						<td><strong>{$lang['price']}</strong></td>
						<td><strong>{$lang['vat']}</strong></td>
						<td><strong>{$lang['total_et']}</strong></td>
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
		";
		if( $s['from'] > 10000 && $s['to'] > 10000 )
			$content .= "<td style=\"font-size: 10px;\">{$lang['from']} ".date('d/m/Y', $s['from'])." {$lang['to']} ".date('d/m/Y', $s['to'])."</td>";
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
					<tr height=\"100px\">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>						
					</tr>
					<tr>
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
						<td>{$lang['total_it']}</td>
						<td align=\"right\">".number_format($bill['total_it'], 2, ',', ' ')." &euro;</td>						
					</tr>
				</tbody>
			</table>		
			<p>{$lang['date']} <strong>" . date('Y-m-d H:i:s', $bill['date']) . "</strong><br />
			{$lang['status']} <strong>[ " . $lang['status_' . $status] . " ] </strong><br />
			<br />
			Domiciliation :<br />
			SG Marseille Baille (01243) 159 bd Baille 13005 MARSEILLE<br />
			<strong>RIB</strong> : 30003 01243 00027000458 53<br />
			<strong>IBAN</strong> : FR76 3000 3012 4300 0270 0045 853<br />
			<strong>BIC</strong> : SOGEFRPP
";

/* ========================== OUTPUT PAGE ========================== */
//$template->output($content);

require_once('/dns/com/anotherservice/hosting/as/pdf/dompdf_config.inc.php');

$html  ='<html><body>';
$html .= $content;
$html .= '</body></html>';

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("sample.pdf");

?>
?>