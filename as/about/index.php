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
					<h4>{$lang['intro']}</h4>
					<p>{$lang['intro_text']}</p>
					<br />
					<h4>{$lang['data']}</h4>
					<p>{$lang['data_text']}</p>
				</div>
				<div class=\"right small\" style=\"background-color: #f0f0f0; border-radius: 5px; padding: 10px;\">
					<h4>{$lang['infos']}</h4>
					<p>
						<span style=\"color: #959595;\">{$lang['creation']}</span>
						<br />
						<span style=\"font-weight: bold; font-size: .9em; font-family: 'Open Sans';\">2010</span>
					</p>
					<p>
						<span style=\"color: #959595;\">{$lang['founders']}</span>
						<br />
						<span style=\"font-weight: bold; font-size: .9em; font-family: 'Open Sans';\"><a href=\"http://www.sys.as\">SYS SAS</a></span>	
					</p>
					<p>
						<span style=\"color: #959595;\">{$lang['capital']}</span>
						<br />
						<span style=\"font-weight: bold; font-size: .9em; font-family: 'Open Sans';\">125 K&euro;</span>						
					</p>
					<p>
						<span style=\"color: #959595;\">{$lang['siret']}</span>
						<br />
						<span style=\"font-weight: bold; font-size: .9em; font-family: 'Open Sans';\">52174593500010</span>						
					</p>
					<p>
						<span style=\"color: #959595;\">{$lang['office']}</span>
						<br />
						<span style=\"font-weight: bold; font-size: .9em; font-family: 'Open Sans';\">19 rue Pierre Lescot<br />75001 Paris</span>						
					</p>
				</div>
				<div class=\"right small\" style=\"padding: 10px;\">
					<br />
					<h4>{$lang['labels']}</h4>
					<a href=\"http://www.entreprise-innovante-des-poles.fr\">
						<img style=\"display: block; width: 70%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/eip.png\" alt=\"\" />
					</a>
					<a href=\"http://www.lafrenchtech.com\">
						<img style=\"display: block; width: 70%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/partners/ft.png\" alt=\"\" />
					</a>
				</div>
				<div class=\"clear\"></div>
				<br /><br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>