<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\"  style=\"text-align: center;\">
				<h1 class=\"dark\"  style=\"text-align: center;\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://www.linkedin.com/profile/view?id=12837370\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/1.png\" /></a><br />
				<span style=\"color: #2475ae; font-size: 20px;\" id=\"Yann Autissier\">Yann Autissier</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['yann']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">aya@anotherservice.com</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://twitter.com/SamuelHassine\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/2.png\" /></a><br />
				<span style=\"color: #2475ae; font-size: 20px;\" id=\"Samuel Hassine\">Samuel Hassine</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['samuel']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">sam@anotherservice.com</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"https://twitter.com/suytt\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/3.png\" /></a><br />
				<span style=\"color: #2475ae; font-size: 20px;\" id=\"Simon Uyttendaele\">Simon Uyttendaele</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['simon']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">usyms@anotherservice.com</span><br />
			</div>
			<div style=\"float: left; text-align: center; width: 275px;\">
				<a href=\"/about/contact\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/you.png\" /></a><br />
				<span style=\"color: #2475ae; font-size: 20px;\" id=\"You\">{$lang['you']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['you_position']}</span><br />
				<span style=\"color: #a8a8a8; font-size: 12px;\">vous@anotherservice.com</span><br />
			</div>
			<div class=\"clear\"></div>
			<br />
			<div class=\"separator\"></div>
			<br />
			<div style=\"text-align: center;\">
				<h1 class=\"dark\"  style=\"text-align: center;\">{$lang['hiring']}</h1>
				<br />
				<p style=\"font-size: 17px; text-align: center;\">{$lang['hiring_text']}</p>
				<br />
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/photo.png\" style=\"height: 300px; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
				<br /><br />
			</div>
				<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/about/contact\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['contact']}</span>	
				</a>
				<p>{$lang['help']}</p>
			</div>
			<br /><br />			
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>