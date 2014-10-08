<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = $lang['title'];

$content = "
		<div class=\"head\">
			<div class=\"container\">
				<br /><br />
				<h1 style=\"margin: 15px 0 5px 0;\">{$lang['title']}</h1>
				<h2 style=\"margin: 20px 0 10px 0; color: #ffffff; letter-spacing: 1px;\">{$lang['subtitle']}</h2>
				<br /><br />
			</div>
		</div>	
		<div class=\"content\">
			<br />
			<div style=\"text-align: center;\">
				<a href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\">
					<div class=\"box offer\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/xs.png\" alt=\"\" style=\"width: 80px;\" />
						<h3>{$lang['xs']}</h3>
						<span style=\"font-size: .9em; color: #cccccc;\">
							<span style=\"color: #a8a8a8; font-weight: bold;\">1</span> {$lang['gb']} {$lang['ram']}, <span style=\"color: #a8a8a8; font-weight: bold;\">4</span> {$lang['services']}<br />
							<span style=\"color: #a8a8a8; font-weight: bold;\">1 {$lang['gb']}</span> {$lang['diskspace']}
						</span>
						<br />
						<br />
						<span class=\"colored large\">29 &euro; / {$lang['month']}</span>
					</div>
				<a href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\">
					<div class=\"box offer\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/s.png\" alt=\"\" style=\"width: 80px;\" />
						<h3>{$lang['s']}</h3>
						<span style=\"font-size: .9em; color: #cccccc;\">
							<span style=\"color: #a8a8a8; font-weight: bold;\">4</span> {$lang['gb']} {$lang['ram']}, <span style=\"color: #a8a8a8; font-weight: bold;\">16</span> {$lang['services']}<br />
							<span style=\"color: #a8a8a8; font-weight: bold;\">1 {$lang['gb']}</span> {$lang['diskspace']}
						</span>
						<br />
						<br />
						<span class=\"colored large\">99 &euro; / {$lang['month']}</span>
					</div>
				</a>
				<a href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\">
					<div class=\"box offer\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/m.png\" alt=\"\" style=\"width: 80px;\" />
						<h3>{$lang['m']}</h3>
						<span style=\"font-size: .9em; color: #cccccc;\">
							<span style=\"color: #a8a8a8; font-weight: bold;\">8</span> {$lang['gb']} {$lang['ram']}, <span style=\"color: #a8a8a8; font-weight: bold;\">32</span> {$lang['services']}<br />
							<span style=\"color: #a8a8a8; font-weight: bold;\">10 {$lang['gb']}</span> {$lang['diskspace']}
						</span>
						<br />
						<br />
						<span class=\"colored large\">180 &euro; / {$lang['month']}</span>
					</div>
				</a>
				<a href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\">
					<div class=\"box offer\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/l.png\" alt=\"\" style=\"width: 80px;\" />
						<h3>{$lang['l']}</h3>
						<span style=\"font-size: .9em; color: #cccccc;\">
							<span style=\"color: #a8a8a8; font-weight: bold;\">16</span> {$lang['gb']} {$lang['ram']}, <span style=\"color: #a8a8a8; font-weight: bold;\">64</span> {$lang['services']}<br />
							<span style=\"color: #a8a8a8; font-weight: bold;\">10 {$lang['gb']}</span> {$lang['diskspace']}
						</span>
						<br />
						<br />
						<span class=\"colored large\">320 &euro; / {$lang['month']}</span>
					</div>
				</a>
			</div>
			<br />
		</div>
		<div class=\"grey\">
			<div class=\"content\">
				<table style=\"width: 80%; margin: 0 auto; text-align: center;\">
					<tr>
						<td style=\"font-weight: bold;\">{$lang['script']}</td>
						<td style=\"text-align: right\">{$lang['script_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['access']}</td>
						<td style=\"text-align: right\">{$lang['access_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['databases']}</td>
						<td style=\"text-align: right\">{$lang['databases_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['repositories']}</td>
						<td style=\"text-align: right\">{$lang['repositories_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['stats']}</td>
						<td style=\"text-align: right\">{$lang['stats_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['disk']}</td>
						<td style=\"text-align: right\">{$lang['disk_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['domains']}</td>
						<td style=\"text-align: right\">{$lang['domains_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['accounts']}</td>
						<td style=\"text-align: right\">{$lang['accounts_text']}</td>
					</tr>
					<tr>
						<td style=\"font-weight: bold;\">{$lang['traffic']}</td>
						<td style=\"text-align: right\">{$lang['traffic_text']}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class=\"content\">
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['signup_now']}</span>
				</a>
				<p>{$lang['help']}</p>
			</div>
			<br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>