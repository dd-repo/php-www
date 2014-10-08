<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = $lang['title'];

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<div style=\"float: left;  width: 770px;\">
				<h2 class=\"dark\">{$lang['events']}</h2>
				<a href=\"http://www.solutionslinux.fr\"><img style=\"display: block; float: left; width: 200px; margin-right: 20px; padding: 5px; border: 1px solid #d6d6d6; border-radius: 3px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/events/1.png\" /></a>
				<span style=\"font-size: 18px;\">{$lang['event1_title']}</span><br />
				<span style=\"color: #9b9b9b;\">{$lang['published']} {$lang['event1_date']}</span>
				<p>{$lang['event1_extract']}</p>
				<div class=\"clear\"></div>
				<br />				
			</div>
			<div style=\"float: right; width: 300px;\">
				<h2 class=\"dark\">{$lang['print']}</h2>
				<a href=\"/{$GLOBALS['CONFIG']['SITE']}/documents/plaquette.png\"><img style=\"display: block; float: left; width: 120px; margin-right: 20px; padding: 5px; border: 1px solid #d6d6d6; border-radius: 3px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/plaquette_mini.png\" /></a>
				<p>{$lang['commercial']}</p>
				<div class=\"clear\"></div>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<h2 class=\"dark\">{$lang['kit']}</h2>
			<table style=\"border: 0; padding: 0;\">
				<tr style=\"border: 0; padding: 0;\">
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-small.png\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-small.png\" /></a>
					</td>
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-normal.png\"><img style=\"width: 550px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-normal.png\" /></a>
					</td>
					<td style=\"border: 0; text-align: center; padding: 0;\">
						<a href=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-big.png\"><img style=\"width: 250px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/goodies/logo-big.png\" /></a>
					</td>
				</tr>
				<tr style=\"border: 0; padding: 0;\">
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['small']}</span></td>
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['normal']}</span></td>
					<td style=\"border: 0; text-align: center; padding: 0;\"><span class=\"legend\">{$lang['big']}</span></td>
				</tr>
			</table>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>