<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\" style=\"text-align: center;\">
			<br />
			<p style=\"font-size: 18px;\">{$lang['intro']}</p>
			<br />
			<br />
			<div style=\"text-align: center;\">
				<div class=\"pay\" onclick=\"window.location.href='/panel/plans'; return false;\">
					<h3 class=\"colored\">{$lang['memory']}</h3>
					<br />
					
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/memory.png\" style=\"width: 150px;\" alt=\"\" />
				</div>
				<div class=\"pay\" onclick=\"window.location.href='/panel/storage'; return false;\">
					<h3 class=\"colored\">{$lang['disk']}</h3>
					<br />
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/disk.png\" style=\"width: 150px;\" alt=\"\" />
				</div>
				<div class=\"clear\"></div><br /><br />
			</div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>