<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = $lang['title'];

$content = "
		<div class=\"head-light\">
			<div class=\"container\"  style=\"text-align: center;\">
				<h1 class=\"dark\"  style=\"text-align: center;\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<div style=\"text-align: center;\">
				<div style=\"display: inline-block; margin: 0 auto; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://twitter.com/jackie_ahw\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/7.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Jackie Ah-Woane\">Jackie Ah-Woane</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['jackie']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">jackie@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://twitter.com/0x0474\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/1.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Yann Autissier\">Yann Autissier</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['yann']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">yann@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; margin: 0 auto; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://twitter.com/SamuelHassine\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/2.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Samuel Hassine\">Samuel Hassine</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['samuel']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">samuel@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; margin: 0 auto; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://www.linkedin.com/profile/view?id=2293592\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/6.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Pascal Hoareau\">Pascal Hoareau</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['pascal']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">pascal@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://twitter.com/Guimeriel\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/5.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Simon Uyttendaele\">Guillaume Meriel</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['guillaume']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">guillaume@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://twitter.com/BrunoMillion\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/4.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Bruno Million\">Bruno Million</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['bruno']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">bruno@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"https://twitter.com/suytt\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/3.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"Simon Uyttendaele\">Simon Uyttendaele</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['simon']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">simon@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
				<div style=\"display: inline-block; text-align: center; width: 240px; margin-bottom: 20px;\">
					<a href=\"/about/contact\"><img class=\"photo\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/you.png\" /></a><br />
					<span style=\"color: #2475ae; font-size: 20px;\" id=\"You\">{$lang['you']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['you_position']}</span><br />
					<span style=\"color: #a8a8a8; font-size: 12px;\">{$lang['you2']}@{$GLOBALS['CONFIG']['DOMAIN']}</span><br />
				</div>
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
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/photo.png\" style=\"width: 90%; max-width: 500px; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
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