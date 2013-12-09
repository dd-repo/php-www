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
			<h1>{$lang['governance']}</h1>
			<p class=\"large\">{$lang['governance_text']}</p>
			<br />
			<table class=\"offer\" style=\"margin: 0 auto; width: 900px;\">
				<tr>
					<td style=\"width: 50%; background-color: #f9f9f9;\">
						<h2>{$lang['offer_1_title']}</h2>
						<p>{$lang['offer_1_desc']}</p>
					</td>
					<td style=\"width: 50%; background-color: #f9f9f9;\">
						<h2>{$lang['offer_2_title']}</h2>
						<p>{$lang['offer_2_desc']}</p>
					</td>
				</tr>
			</table>
			<br />
			<h1>{$lang['manage']}</h1>
			<p class=\"large\">{$lang['manage_text']}</p>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>