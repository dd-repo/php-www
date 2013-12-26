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
			<img class=\"icon-right\" style=\"float: right; display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illustrations/open.png\" alt=\"intro\" />
			<p class=\"large\">{$lang['intro']}</p>
			<div class=\"seperator-light\" style=\"clear: none; width: 500px; margin-right: 350px;\"></div>
			<br />
			<h2 class=\"dark\">{$lang['usage']}</h2>
			<p class=\"large\">{$lang['usage_text']}</p><br />
			<img class=\"icon\" style=\"float: left; display: block; padding: 10px; margin-right: 25px; border: 1px solid #d1d1d1; border-radius: 3px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illustrations/rmll.png\" alt=\"intro\" />
			<h2 class=\"dark\">{$lang['doc']}</h2>
			<p class=\"large\">{$lang['doc_text']}</p><br />
			<h2 class=\"dark\">{$lang['source']}</h2>
			<p class=\"large\">{$lang['source_text']}</p>
		</div>
		<div class=\"clear\"></div><br />
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>