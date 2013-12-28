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
			<h3>{$lang['domain']}</h3>
			<p class=\"large\">{$lang['domain_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/1.png\" alt=\"1\" />
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/2.png\" alt=\"2\" />
			<br />
			<h3>{$lang['app']}</h3>
			<p class=\"large\">{$lang['app_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"3\" />
			<p class=\"large\">{$lang['app_text2']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"4\" />
			<p class=\"large\">{$lang['app_text3']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/5.png\" alt=\"5\" />
			<p class=\"large\">{$lang['app_text4']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/6.png\" alt=\"6\" />
			<br />
			<h3>{$lang['publish']}</h3>
			<p class=\"large\">{$lang['publish_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/7.png\" alt=\"7\" />
			<p class=\"large\">{$lang['publish2_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/8.png\" alt=\"8\" />
			<p class=\"large\">{$lang['publish3_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/9.png\" alt=\"9\" />
			<p class=\"large\">{$lang['publish4_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/10.png\" alt=\"10\" />
			<br />
			<h3>{$lang['access']}</h3>			
			<p class=\"large\">{$lang['access_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/11.png\" alt=\"11\" />
			<p class=\"large\">{$lang['access2_text']}</p>
			<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/12.png\" alt=\"12\" />
			<br />
			<p class=\"large\" style=\"text-align: center;\">
				{$lang['end']}<br /><br />
				<a class=\"button classic\" style=\"width: 120px; margin: 0 auto;\" href=\"/doc\">{$lang['back']}</a>
			</p>
		</div>
		<div class=\"clear\"></div><br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>