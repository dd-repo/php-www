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
			<h2>{$lang['thanks']}</h2>
			<p>{$lang['thanks_text']}</p>
			<br />
			<a class=\"btn\" href=\"/\">{$lang['home']}</a> <a class=\"btn\" href=\"/doc\">{$lang['doc']}</a> 
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>