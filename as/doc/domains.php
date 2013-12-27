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
			<br />
			<blockquote style=\"width: 500px; margin: 0 auto;\">
				<p>
					<span style=\"font-weight: bold;\">{$lang['primary']}</span> ns1.anotherservice.com - 178.32.167.250<br />
					<span style=\"font-weight: bold;\">{$lang['secondary']}</span> ns2.anotherservice.com - 178.32.65.70
				</p>
			</blockquote>
			<br />
			<p class=\"large\">{$lang['intro2_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/1.png\" alt=\"1\" />
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/2.png\" alt=\"2\" />
			<br />
			<h2>{$lang['manage']}</h2>
			<p class=\"large\">{$lang['manage_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/18.png\" alt=\"1\" />
			<br />
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>