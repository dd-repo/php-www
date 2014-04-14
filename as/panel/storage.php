<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
$quotas = api::send('self/quota/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'DISK' )
		$dquota = $q;
	if( $q['name'] == 'MEMORY' )
		$mquota = $q;
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px; width: 600px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">		
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<table>
				<tr>
					<th>{$lang['plan']}</th>
					<th>{$lang['price']}</th>
					<th>{$lang['actions']}</th>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_1_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_1_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">0&euro;</span> / {$lang['month']}</span></td>
					<td><span class=\"large colored\">{$lang['included']}</span></td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_2_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_2_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">5&euro;</span> / {$lang['month']}</span></td>
			";
			if( $dquota['max'] == 10000 )
				$content .= "<td><span class=\"large colored\">{$lang['current']}</span></td>";
			else
				$content .= "<td>".($mquota['max']>=8192?"<span class=\"large colored\">{$lang['included']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=8\">{$lang['select']}</a>")."</td>";
			
			$content .= "
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_3_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_3_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">20&euro;</span> / {$lang['month']}</span></td>
			";
			if( $dquota['max'] == 50000 )
				$content .= "<td><span class=\"large colored\">{$lang['current']}</span></td>";
			else
				$content .= "<td>".($mquota['max']>=32768?"<span class=\"large colored\">{$lang['included']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=9\">{$lang['select']}</a>")."</td>";
			
			$content .= "
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_4_title']}</h2>
						<p style=\"margin-bottom: 0;\">{$lang['offer_4_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">30&euro;</span> / {$lang['month']}</span></td>
					<td>".($dquota['max']==100000?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=10\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_5_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_5_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">100&euro;</span> / {$lang['month']}</span></td>
					<td>".($dquota['max']==500000?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=11\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_6_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_6_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">150&euro;</span> / {$lang['month']}</span></td>
					<td>".($dquota['max']==1000000?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=12\">{$lang['select']}</a>")."</td>
				</tr>
			</table>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>