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
			<div style=\"float: left;  width: 520px;\">
				<h2 class=\"dark\">{$lang['datacenters']}</h2>
				<p>{$lang['datacenters_text']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: right;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/map.png\" style=\"float: left; display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"float: left; width: 500px;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/stack.png\" style=\"display: block; border-radius: 3px;\" />
			</div>
			<div style=\"float: right; width: 530px;\">
				<h2 class=\"dark\">{$lang['virt']}</h2>
				<p>{$lang['virt_text']}</p>			
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/status\" style=\"height: 22px; width: 230px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['status']}</span>	
				</a>
			</div>
			<br /><br />
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>