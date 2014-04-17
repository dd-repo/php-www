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
			<div style=\"text-align: left;\">
				<a href=\"http://www.lafourchette.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						 <div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/lafourchette.png\" alt=\"\"/></div></div>
					</div>
				</a>
				<a href=\"http://www.bnpparibas.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						 <div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/bnpparibas.png\" alt=\"\"/></div></div>
					</div>
				</a>
				<a href=\"http://www.bpce.fr\">
					<div class=\"reference white\" style=\"background-color: #ffffff;\">
						 <div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/bpce.png\" alt=\"\"/></div></div>
					</div>
				</a>
				<a href=\"http://www.wyplay.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/wyplay.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.nice.aeroport.fr\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/nice.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.gouv.mc\">
					<div class=\"reference white\" style=\"background-color: #ffffff;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/monaco.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.iprotego.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/iprotego.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.akeance.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/akeance.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.cassini-conseil.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/cassini.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.sao-tome.st\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/saotome.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.orlane.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/orlane.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"https//www.bienprevoir.fr\">
					<div class=\"reference white\" style=\"background-color: #fdfbfb;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/bienprevoir.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.provence-luberon-news.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/pln.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.antillesexception.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/antilles.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.phidias.fr\">
					<div class=\"reference white\" style=\"background-color: #fdfbfb;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/phidias.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.randco.fr\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						 <div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/randco.png\" alt=\"\"/></div></div>
					</div>
				</a>
				<a href=\"http://www.internethic.com\">
					<div class=\"reference white\" style=\"background-color: #fdfbfb; margin-right: 80px;\" >
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/internethic.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.rabasse.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/tdr.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.itika.net\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/itika.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.continental-university.com\">
					<div class=\"reference white\" style=\"background-color: #ffffff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/continental.png\" alt=\"\" /></div></div>
					</div>
				</a>
				<a href=\"http://www.carbon-it.fr\">
					<div class=\"reference white\" style=\"background-color: #ffffff;\">
						 <div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/carbon.png\" alt=\"\"/></div></div>
					</div>
				</a>
				<a href=\"http://www.centre-dentaire-marseille.fr\">
					<div class=\"reference white\" style=\"background-color: #fcfdff; margin-right: 80px;\">
						<div class=\"inref\"><div><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/showcases/cdm.png\" alt=\"\" /></div></div>
					</div>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>