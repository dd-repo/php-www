<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = $lang['title'];

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<div class=\"left big\">
				<h2 class=\"dark\" style=\"margin-bottom: 10px;\">{$lang['intro']}</h2>
				<p>{$lang['intro_text']}</p>
			</div>
			<div class=\"right small rounded\">
				<h2 class=\"dark\" style=\"margin-bottom: 15px;\">{$lang['plaquettes']}</h2>
				<ul class=\"simple\">
					<li><a class=\"normal\" href=\"/{$GLOBALS['CONFIG']['SITE']}/documents/AnotherService-Logos.zip\"><i class=\"fa fa-file-zip-o fa-fw\"></i> {$lang['logos']}</a></li>
					<li><a class=\"normal\" href=\"/{$GLOBALS['CONFIG']['SITE']}/documents/AnotherService-Leaflet_institutionnel.pdf\"><i class=\"fa fa-file-pdf-o fa-fw\"></i> {$lang['instit']}</a></li>
					<li><a class=\"normal\" href=\"/{$GLOBALS['CONFIG']['SITE']}/documents/SYS-Leaflet_institutionnel\"><i class=\"fa fa-file-pdf-o fa-fw\"></i> {$lang['sys']}</a></li>
				</ul>
			</div>
			<div class=\"clear\"></div>
			<div class=\"separator\"></div>
			<div style=\"text-align: center;\">
				<div class=\"review\">
					<a href=\"https://{$GLOBALS['CONFIG']['HOSTNAME']}/blog/post?id=2\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/reviews/anotherservice.png\" alt=\"\" />
					</a>
					<h2 class=\"dark\" style=\"font-size: 1.1em;\">
						{$lang['news3']}<br />
						<span class=\"date\">{$lang['news3_date']}</span>
					</h2>
					<p>{$lang['news3_text']}</p>
				</div>
				<div class=\"review\">
					<a href=\"https://{$GLOBALS['CONFIG']['HOSTNAME']}/blog/post?id=3\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/reviews/anotherservice.png\" alt=\"\" />
					</a>
					<h2 class=\"dark\" style=\"font-size: 1.1em;\">
						{$lang['news2']}<br />
						<span class=\"date\">{$lang['news2_date']}</span>
					</h2>
					<p>{$lang['news2_text']}</p>
				</div>
				<div class=\"review\">
					<a href=\"https://{$GLOBALS['CONFIG']['HOSTNAME']}/blog/post?id=1\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/reviews/anotherservice.png\" alt=\"\" />
					</a>
					<h2 class=\"dark\" style=\"font-size: 1.1em;\">{$lang['news1']}<br />
						<span class=\"date\">{$lang['news1_date']}</span>
					</h2>
					<p>{$lang['news1_text']}</p>
				</div>
			</div>
			<br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>