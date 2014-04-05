<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<h1 class=\"dark\" style=\"text-align: center;\">{$lang['thanks']}</h1>
		</div>
		<div class=\"clear\"></div><br /><br />
		<div class=\"container\" style=\"text-align: center;\">
			<p style=\"font-size: 18px;\">{$lang['thanks_text']}</p>
		</div>
		<br /><br />
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>