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
			<a href=\"https://twitter.com/aya\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/yann.png\" /></a>
			<h3 class=\"colored\">Yann Autissier</h3>
			<p>{$lang['yann']}</p>
			<div class=\"clear\"></div>
			<br />
			<a href=\"https://twitter.com/SamuelHassine\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/sam.png\" /></a>
			<h3>Samuel Hassine</h3>
			<p>{$lang['sam']}</p>
			<div class=\"clear\"></div>
			<br />
			<a href=\"https://twitter.com/suytt\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/simon.png\" /></a>
			<h3>Simon Uyttendaele</h3>
			<p>{$lang['simon']}</p>
			<div class=\"clear\"></div>
			<br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>