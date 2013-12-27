<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<h3 class=\"colored\">{$lang['frameworks']}</h3>
			<br />
			<a href=\"/panel/app/add2?runtime=php\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" alt=\"PHP\"><span class=\"large\">PHP (Web)</span></p>
					<div class=\"overline\">5.4.9</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=php52\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" alt=\"PHP\"><span class=\"large\">PHP (Web)</span></p>
					<div class=\"overline\">5.2.17</div>
					<br />					
				</div>
			</a>						
			<a href=\"/panel/app/add2?runtime=rubyrails\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubyrails.png\" alt=\"Ruby\"><span class=\"large\">Ruby on Rails</span></p>
					<div class=\"overline\">4.0.2</div>
					<br />
				</div>
			</a>
			<a href=\"#\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubysinatra.png\" alt=\"Ruby\"><span class=\"large\">Ruby Sinatra</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>
			</a>
			<a href=\"#\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythondjango.png\" alt=\"Ruby\"><span class=\"large\">Python Django</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>			
			</a>
			<a href=\"/panel/app/add2?runtime=pythonwsgi\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythonwsgi.png\" alt=\"Ruby\"><span class=\"large\">Python WSGI</span></p>
					<div class=\"overline\">2.7.4</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=php\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-javatomcat.png\" alt=\"PHP\"><span class=\"large\">Java Tomcat</span></p>
					<div class=\"overline\">7.0.47</div>
					<br />					
				</div>
			</a>
			<div class=\"clearfix\"></div>
			<br />
			<h3 class=\"colored\">{$lang['standalone']}</h3>
			<br />
			<a href=\"/panel/app/add2?runtime=phpworker&standalone\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-phpworker.png\" alt=\"PHP\"><span class=\"large\">PHP (Worker)</span></p>
					<div class=\"overline\">5.4.9</div>
					<br />					
				</div>
			</a>
			<a href=\"#\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python.png\" alt=\"Python\"><span class=\"large\">Python</span></p>
					<div class=\"overline\">2.7.4</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=java&standalone\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" alt=\"Java\"><span class=\"large\">Java</span></p>
					<div class=\"overline\">1.7.0</div>
					<br />
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=ruby&standalone\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" alt=\"Ruby\"><span class=\"large\">Ruby</span></p>
					<div class=\"overline\">1.9.3</div>
					<br />
				</div>
			</a>
			<a href=\"#\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-nodejs.png\" alt=\"NodeJS\"><span class=\"large\">NodeJS</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>
			</a>			
			<div class=\"clearfix\"></div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>