<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang['TITLE'] = $lang['title'];

$content = "
		<div class=\"head\">
			<div class=\"container\">
				<br /><br />
				<h1 style=\"margin: 15px 0 5px 0;\">{$lang['title']}</h1>
				<h2 style=\"margin: 20px 0 10px 0; color: #ffffff; letter-spacing: 1px;\">{$lang['subtitle']}</h2>
				<br /><br />
			</div>
		</div>	
		<div class=\"content\">
			<div style=\"float: left;  width: 520px;\">
				<h2 class=\"dark\">{$lang['datacenters']}</h2>
				<p>{$lang['datacenters_text']}</p>
			</div>
			<div style=\"float: right; width: 480px; text-align: right;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/map.png\" style=\"float: left; display: block; padding: 10px; border: 1px solid #d1d1d1; border-radius: 3px;\" />
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div class=\"separator light\"></div>			
			<div style=\"text-align: center;\">
				<div style=\"display: inline-block; margin-right: 50px; opacity: 0.6;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/cisco.png\" alt=\"\" />
				</div>
				<div style=\"display: inline-block; margin-right: 50px; opacity: 0.6;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/juniper.png\" alt=\"\" />
				</div>
				<div style=\"display: inline-block; margin-right: 50px; opacity: 0.6;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/intel.png\" alt=\"\" />
				</div>
				<div style=\"display: inline-block; opacity: 0.6;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/dell.png\" alt=\"\" />
				</div>
			</div>
			<div class=\"clearfix\"></div>
			<div class=\"separator light\"></div>	
			<br />
			<div style=\"float: left; width: 500px;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/stack.png\" style=\"display: block; border-radius: 3px;\" />
			</div>
			<div style=\"float: right; width: 530px;\">
				<h2 class=\"dark\">{$lang['virt']}</h2>
				<p>{$lang['virt_text']}</p>			
			</div>
			<div class=\"clear\"></div>
			<br /><br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/status\" style=\"height: 22px; width: 230px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['status']}</span>	
				</a>
			</div>
			<br /><br />
			<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/paris.png\" style=\"display: block; float: left; border-radius: 3px; padding: 10px; border: 1px solid #d1d1d1; margin: 0 20px 0 0;\" />
			<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/paris4.png\" style=\"display: block; float: left; border-radius: 3px; padding: 10px; border: 1px solid #d1d1d1; margin: 0 20px 0 20px;\" />
			<div style=\"float: left; width: 370px;\">
				<h2 class=\"dark\">{$lang['paris']}</h2>
				<p>{$lang['paris_text']}</p>
				<p>{$lang['paris_text2']}</p>
			</div>
			<div class=\"clear\"></div>	
			<br /><br />
			<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/marseille.png\" style=\"display: block; float: right; border-radius: 3px; padding: 10px; border: 1px solid #d1d1d1; margin: 0 20px 0 0;\" />
			<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/techno/marseille2.png\" style=\"display: block; float: right; border-radius: 3px; padding: 10px; border: 1px solid #d1d1d1; margin: 0 20px 0 20px;\" />
			<h2 class=\"dark\">{$lang['marseille']}</h2>
			<p>{$lang['marseille_text']}</p>
			<p>{$lang['marseille_text2']}</p>
			<div class=\"clear\"></div>	
			<br /><br />		
		</div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>