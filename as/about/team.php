<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box rightcol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"left\">
			<div class=\"container\">
				<h1>{$lang['team']}</h1>
				<p class=\"large\">{$lang['team_text']}</p>
				<br />
				<p>
					<a href=\"https://twitter.com/SamuelHassine\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/sam.png\" /></a>
					<a href=\"https://twitter.com/suytt\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/simon.png\" /></a>
					<a href=\"#\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/yann.png\" /></a>
				</p>
			</div>
		</div>
		<div class=\"right\">
			<div class=\"container\">
				<h1>{$lang['job']}</h1>
				<p class=\"large\">{$lang['job_text']}</p>
				<br />
				<a class=\"btn\" href=\"/about/contact\">{$lang['apply']}</a>
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>