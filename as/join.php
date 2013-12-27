<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<table style=\"border: 0;\">
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h2>{$lang['offer_1_title']}</h2>
						<p>{$lang['offer_1_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">29&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"btn\" href=\"/join/prepare?plan=1\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h2>{$lang['offer_2_title']}</h2>
						<p>{$lang['offer_2_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">99&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"btn\" href=\"/join/prepare?plan=2\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h2>{$lang['offer_3_title']}</h2>
						<p>{$lang['offer_3_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">180&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"btn\" href=\"/join/prepare?plan=3\">{$lang['select']}</a></td>
				</tr>
				<tr>
					<td style=\"border: 0;\">
						<h2>{$lang['offer_4_title']}</h2>
						<p>{$lang['offer_4_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">320&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"btn\" href=\"/join/prepare?plan=4\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h2>{$lang['offer_5_title']}</h2>
						<p>{$lang['offer_5_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">560&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"btn\" href=\"/join/prepare?plan=5\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h2>{$lang['offer_6_title']}</h2>
						<p>{$lang['offer_6_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">999&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"btn\" href=\"/join/prepare?plan=6\">{$lang['select']}</a></td>
				</tr>
			</table>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>