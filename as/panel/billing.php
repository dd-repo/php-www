<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$me = api::send('self/whoami');
$me = $me[0];
$bills = array();

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"float: left; width: 500px;\">
				<span class=\"lightlarge\">{$lang['account']}</span> <span class=\"large colored\">".$lang['status_' . $me['status']]."</span>
				<br /><br />
				<p class=\"large\">".($me['iban']?"{$lang['infos_ok']}":"{$lang['infos_nok']}")."</p>
				<div class=\"clearfix\"></div>
			</div>
			<div style=\"padding-top: 14px;\">
				<a class=\"btn\" href=\"/panel/billing/update\">{$lang['infos']}</a>
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<h2>{$lang['bills']}</h2>
			<p class=\"large\">{$lang['intro']}</p>
			<table>
				<tr>
					<th>{$lang['id']}</th>
					<th>{$lang['date']}</th>
					<th>{$lang['total']}</th>
					<th>{$lang['status']}</th>
				</tr>
";

foreach( $bills as $b )
{
	$content .= "
				<tr>
					<td><img class=\"language\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$s['vendor']}.png\" alt=\"\" /><strong>{$s['name']}</strong></td>
					<td>{$s['vendor']}</td>
					<td>{$s['version']}</td>
					<td align=\"center\">
		";
		
		if( security::hasGrant('SELF_SERVICE_DELETE') )
		{
			$content .= "
									<a href=\"/panel/service/del_action?name={$s['name']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>";
		}
		
		$content .= "
								</td>
							</tr>
		";
}

$content .= "
				</tr>
			</table>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
