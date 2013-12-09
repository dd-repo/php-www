<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
$quotas = api::send('self/quota/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'MEMORY' )
		$quota = $q;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<table>
				<tr>
					<th>{$lang['plan']}</th>
					<th>{$lang['price']}</th>
					<th>{$lang['actions']}</th>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_1_title']}</h2>
						<p>{$lang['offer_1_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">29&euro;</span> / {$lang['month']}</span></td>
					<td>".($quota['max']==1024?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"btn\" href=\"/panel/plan/select?plan=1\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_2_title']}</h2>
						<p>{$lang['offer_2_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">99&euro;</span> / {$lang['month']}</span></td>
					<td>".($quota['max']==4096?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"btn\" href=\"/panel/plan/select?plan=2\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_3_title']}</h2>
						<p>{$lang['offer_3_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">180&euro;</span> / {$lang['month']}</span></td>
					<td>".($quota['max']==8192?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"btn\" href=\"/panel/plan/select?plan=3\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_4_title']}</h2>
						<p>{$lang['offer_4_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">320&euro;</span> / {$lang['month']}</span></td>
					<td>".($quota['max']==16384?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"btn\" href=\"/panel/plan/select?plan=4\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_5_title']}</h2>
						<p>{$lang['offer_5_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">560&euro;</span> / {$lang['month']}</span></td>
					<td>".($quota['max']==32768?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"btn\" href=\"/panel/plan/select?plan=5\">{$lang['select']}</a>")."</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_6_title']}</h2>
						<p>{$lang['offer_6_desc']}</p>
					</td>
					<td><span class=\"large\"><span class=\"colored\">999&euro;</span> / {$lang['month']}</span></td>
					<td>".($quota['max']==65536?"<span class=\"large colored\">{$lang['current']}</span>":"<a class=\"btn\" href=\"/panel/plan/select?plan=6\">{$lang['select']}</a>")."</td>
				</tr>
			</table>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>