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
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"1\" />
			<br />
			<a href=\"/doc/domains\"><h3>{$lang['domains']}</h3></a>
			<p class=\"large\">{$lang['domains_text']}</p>
			<a href=\"/doc/domains\"><img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/1.png\" alt=\"1\" /></a>
			<br />
			<a href=\"/doc/emails\"><h3>{$lang['emails']}</h3></a>
			<p class=\"large\">{$lang['emails_text']}</p>
			<a href=\"/doc/emails\"><img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/13.png\" alt=\"1\" /></a>
			<br />
			<a href=\"/doc/apps\"><h3>{$lang['app']}</h3></a>
			<p class=\"large\">{$lang['app_text']}</p>
			<a href=\"/doc/apps\"><img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"3\" /></a>
			<br />
			<a href=\"/doc/branches\"><h3>{$lang['branches']}</h3></a>
			<p class=\"large\">{$lang['branches_text']}</p>
			<a href=\"/doc/branches\"><img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/15.png\" alt=\"4\" /></a>
			<br />
			<a href=\"/doc/process\"><h3>{$lang['process']}</h3></a>
			<p class=\"large\">{$lang['process_text']}</p>
			<a href=\"/doc/process\"><img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/16.png\" alt=\"4\" /></a>
			<a href=\"/doc/process\"><img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/17.png\" alt=\"4\" /></a>			
			<br />
			<p class=\"large\" style=\"text-align: center;\">
				<a class=\"button classic\" style=\"width: 120px; margin: 0 auto;\" href=\"/doc\">{$lang['back']}</a>
			</p>
		</div>
		<div class=\"clear\"></div><br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>