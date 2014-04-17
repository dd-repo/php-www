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
			<div style=\"float: left; width: 520px;\">
				<h2 class=\"dark\">{$lang['api']}</h2>
				<p>{$lang['api_text']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: right;\">
				<a href=\"https://api.anotherservice.com\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/api.png\" style=\"float: left; display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" /></a>
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"float: left;  width: 440px;\">
			<a href=\"https://github.com/AnotherService\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sources.png\" style=\"display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px; margin-left: 20px;\" /></a>
			</div>
			<div style=\"float: right; width: 560px;\">
				<h2 class=\"dark\">{$lang['sources']}</h2>
				<p>{$lang['sources_text']}</p>			
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>