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
			<img class=\"icon-right\" style=\"border: 1px solid #e5e5e5; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illustrations/open.png\" alt=\"intro\" />
			<p class=\"large\">{$lang['intro']}</p>
			<hr>
			<h2>{$lang['usage']}</h2>
			<p class=\"large\">{$lang['usage_text']}</p><br />
			<img class=\"icon\" style=\"border: 3px solid #e5e5e5; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illustrations/rmll.png\" alt=\"intro\" />
			<h2>{$lang['doc']}</h2>
			<p class=\"large\">{$lang['doc_text']}</p><br />
			<h2>{$lang['source']}</h2>
			<p class=\"large\">{$lang['source_text']}</p>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>