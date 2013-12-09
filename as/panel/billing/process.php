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
					<strong>Bus IT SAS</strong><br />
					19 chemin de Ch&acirc;teau Gombert<br />
					13013 Marseille, France
				</div>
				<div style=\"float: right; width: 200px; margin: 20px;\">
					<strong>{$userinfo['firstname']} {$userinfo['lastname']}</strong><br />
					{$userinfo['email']}
				</div>
				<div style=\"clear: both;\"></div>
				<div class=\"widget first\">
					<div class=\"head\"><h5 class=\"iFrames\">{$lang['subtitle']} #BI-{$bill['id']}</h5></div>
					<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" class=\"tableStatic\">
						<thead>
							<tr>
								<td>{$lang['service']}</td>
								<td>{$lang['description']}</td>
								<td>{$lang['price']}</td>
								<td>{$lang['number']}</td>
								<td>{$lang['total']}</td>
							</tr>
						</thead>
						<tbody>
";

$credits = 0;
if( count($bill['services']) > 0 )
{
	foreach( $bill['services'] as $s )
	{
		$credits = $credits+($s['count']*$s['credits']);
		$content .= "
							<tr class=\"gradeA\">
								<td>{$s['name']}</td>
								<td>{$s['description']}</td>
								<td>{$s['price']} &euro;</td>
								<td>{$s['count']}</td>
								<td>{$s['total']} &euro;</td>
							</tr>
		";
	}
}
	
$content .= "
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>{$lang['total_et']}</td>
								<td>{$bill['total_et']} &euro;</td>						
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>{$lang['total_vat']} ({$bill['vat']})</td>
								<td>{$bill['total_vat']} &euro;</td>						
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td>{$lang['total_it']}</td>
								<td>{$bill['total_it']} &euro;</td>						
							</tr>
						</tbody>
					</table>					
				</div>
				<p>{$lang['date']} <strong>" . date('Y-m-d H:i:s', $bill['date']) . "</strong><br />
				{$lang['status']} <strong>[ " . $lang['status_' . $status] . " ]</strong></p>
				<div style=\"float: right;\">
";
if( $status == 0 )
{
	switch( $_GET['mode'] )
	{
		case 'paypal':
			$content .= "
				<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
					<input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />
					<input type=\"hidden\" name=\"business\" value=\"contact@bus-it.com\" />  
					<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">  
					<input type=\"hidden\" name=\"item_name\" value=\"{$bill['services'][0]['count']} x {$bill['services'][0]['description']}\" />
					<input type=\"hidden\" name=\"amount\" value=\"{$bill['total_it']}\" />
					<input type=\"hidden\" name=\"return\" value=\"https://panel.bus-it.com/panel/credits\" />
					<input type=\"hidden\" name=\"cancel_return\" value=\"https://panel.bus-it.com/panel/bill/failed\" />
					<input type=\"hidden\" name=\"notify_url\" value=\"https://panel.bus-it.com/ipn_paypal\" />
					<input type=\"hidden\" name=\"custom\" value=\"{$bill['id']} {$bill['user']} {$credits}\" />
					<input type=\"image\" src=\"https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif\" border=\"0\" name=\"submit\" />
					<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif\" width=\"1\" height=\"1\" />
				</form>
			";
		break;
		default:
	
	}
}
$content .= "
			</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>