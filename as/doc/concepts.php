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
			<div style=\"float: left; width: 500px;\">
				<h2>{$lang['intro']}</h2>
			</div>
			<div style=\"float: right; text-align: right; width: 300px;\">
				<a class=\"btn\" href=\"/doc\">{$lang['back']}</a>		
			</div>
			<div class=\"clearfix\"></div>
			<p class=\"large\">{$lang['intro_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"1\" />
			<br />
			<a href=\"/doc/domains\"><h3>{$lang['domains']}</h3></a>
			<p class=\"large\">{$lang['domains_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/1.png\" alt=\"1\" />
			<br />
			<a href=\"/doc/emails\"><h3>{$lang['emails']}</h3></a>
			<p class=\"large\">{$lang['emails_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/13.png\" alt=\"1\" />
			<br />
			<a href=\"/doc/apps\"><h2>{$lang['app']}</h2></a>
			<p class=\"large\">{$lang['app_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"3\" />
			<br />
			<a href=\"/doc/branches\"><h3>{$lang['branches']}</h3></a>
			<p class=\"large\">{$lang['branches_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/15.png\" alt=\"4\" />
			<br />
			<a href=\"/doc/process\"><h3>{$lang['process']}</h3></a>
			<p class=\"large\">{$lang['process_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/16.png\" alt=\"4\" />		
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/17.png\" alt=\"4\" />					
			<br />
			<p class=\"large\" style=\"text-align: center;\">
				<a class=\"btn\" style=\"margin: 0 auto;\" href=\"/doc\">{$lang['back']}</a>
			</p>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>