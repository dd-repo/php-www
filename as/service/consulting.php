<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>
		<div class=\"content\">
			<h2 class=\"dark\">{$lang['governance']}</h2>
			<p>{$lang['governance_text']}</p>
			<br />
			<table class=\"offer\" style=\"margin: 0 auto; width: 900px;\">
				<tr>
					<td style=\"width: 50%; background-color: #f9f9f9;\">
						<h3>{$lang['offer_1_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_1_desc']}</p>
					</td>
					<td style=\"width: 50%; background-color: #f9f9f9;\">
						<h3>{$lang['offer_2_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_2_desc']}</p>
					</td>
				</tr>
			</table>
			<br />
			<h2 class=\"dark\">{$lang['manage']}</h2>
			<p class=\"large\">{$lang['manage_text']}</p>
		</div>
		<br />
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>