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
					<a class=\"button classic\" href=\"/doc/concepts\" style=\"float: right; height: 22px; width: 150px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['back']}</span>
					</a>
				</div>
				<div class=\"clear\"></div>
			</div>
		</div>
		<div class=\"content\">		
			<h3>{$lang['intro']}</h3>
			<p class=\"large\">{$lang['intro_text1']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"1\" />
			<br />
			<p class=\"large\">{$lang['intro_text2']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"1\" />
			<br />
			<h3>{$lang['manage']}</h3>
			<p class=\"large\">{$lang['manage_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/18.png\" alt=\"1\" />
			<p class=\"large\" style=\"text-align: center;\">
				{$lang['end']}<br /><br />
				<a class=\"button classic\" style=\"width: 120px; margin: 0 auto;\" href=\"/doc/concepts\">{$lang['back']}</a>
			</p>
		</div>
		<div class=\"clear\"></div><br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>