<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<div style=\"float: left; width: 500px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div style=\"float: right; width: 500px;\">
					<a class=\"button classic\" href=\"/doc\" style=\"float: right; height: 22px; width: 150px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['back']}</span>
					</a>
				</div>
				<div class=\"clear\"></div>
			</div>
		</div>
		<div class=\"content\">		
			<h3>{$lang['intro']}</h3>
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
			<h3>{$lang['manage']}</h3>
			<p class=\"large\">{$lang['manage_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/18.png\" alt=\"1\" />
			<br />
		</div>
		<div class=\"clear\"></div><br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>