<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$quotas = api::send('self/quota/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'APPS' )
		$aquota = $q;
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
";

if( $mquota['max'] == 0 )
{
	$content .= "
				<h2 class=\"dark\">{$lang['mutu']}</h2>
				<table>
					<tr>
						<th>{$lang['plan']}</th>
						<th>{$lang['price']}</th>
						<th>{$lang['actions']}</th>
					</tr>
					<tr>
						<td>
							<h3>{$lang['mutu_1_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['mutu_1_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">2&euro;</span> / {$lang['month']}</span></td>
						<td>".($aquota['max']==1?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=101\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['mutu_2_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['mutu_2_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">5&euro;</span> / {$lang['month']}</span></td>
						<td>".($aquota['max']==3?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=102\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['mutu_3_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['mutu_3_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">10&euro;</span> / {$lang['month']}</span></td>
						<td>".($aquota['max']==6?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=103\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['mutu_4_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['mutu_4_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">20&euro;</span> / {$lang['month']}</span></td>
						<td>".($aquota['max']==12?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=104\">{$lang['select']}</a>")."</td>
					</tr>
				</table>
				<br /><br />
";
}

$content .= "
				<h2 class=\"dark\">{$lang['paas']}</h2>
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
						<td><span class=\"large\"><span class=\"colored\">29&euro;</span> / {$lang['month']}</span></td>
						<td>".($mquota['max']==1024?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=1\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['offer_2_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['offer_2_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">99&euro;</span> / {$lang['month']}</span></td>
						<td>".($mquota['max']==4096?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=2\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['offer_3_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['offer_3_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">180&euro;</span> / {$lang['month']}</span></td>
						<td>".($mquota['max']==8192?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=3\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['offer_4_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['offer_4_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">320&euro;</span> / {$lang['month']}</span></td>
						<td>".($mquota['max']==16384?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=4\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['offer_5_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['offer_5_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">560&euro;</span> / {$lang['month']}</span></td>
						<td>".($mquota['max']==32768?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=5\">{$lang['select']}</a>")."</td>
					</tr>
					<tr>
						<td>
							<h3>{$lang['offer_6_title']}</h3>
							<p style=\"margin-bottom: 0;\">{$lang['offer_6_desc']}</p>
						</td>
						<td><span class=\"large\"><span class=\"colored\">999&euro;</span> / {$lang['month']}</span></td>
						<td>".($mquota['max']==65536?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"button classic\" href=\"/panel/plans/pay?plan=6\">{$lang['select']}</a>")."</td>
					</tr>
				</table>
			</div>
		</div>
		<br />
		<div id=\"new\" style=\"display: none;\" class=\"floatingdialog\">
			<h3 class=\"center\">{$lang['confirm']}</h3>
			<p style=\"text-align: center;\">{$lang['confirm_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/panel/plan/select_action\" method=\"get\" class=\"center\">
					<input id=\"plan\" type=\"hidden\" name=\"plan\" value=\"\" />
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['ok']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<script>
			newFlexibleDialog('new', 550);
		</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>