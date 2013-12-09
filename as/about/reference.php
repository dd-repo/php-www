<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<a href=\"http://www.iprotego.com\">
				<div class=\"reference white\" style=\"background-color: #ffffff;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/iprotego.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.centre-dentaire-marseille.fr\">
				<div class=\"reference white\" style=\"background-color: #fcfdff;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/cdm.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.wyplay.com\">
				<div class=\"reference white\" style=\"background-color: #ffffff;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/wyplay.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.phidias.fr\">
				<div class=\"reference white\" style=\"background-color: #fdfbfb;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/phidias.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.internethic.com\">
				<div class=\"reference black\" style=\"background-color: #1c1c1c;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/internethic.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.rabasse.com\">
				<div class=\"reference white\" style=\"background-color: #ffffff;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/tdr.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.itika.net\">
				<div class=\"reference white\" style=\"background-color: #ffffff;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/itika.png\" alt=\"\" />
				</div>
			</a>
			<a href=\"http://www.continental-university.com\">
				<div class=\"reference white\" style=\"background-color: #ffffff;\">
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/continental.png\" alt=\"\" />
				</div>
			</a>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>