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
			<p class=\"large\">{$lang['intro']}</p>
			<br />
			<h3 class=\"colored\">{$lang['frameworks']}</h3>
			<br />			
			<a href=\"/panel/app/add2?runtime=ruby193&framework=rails3&app=rails\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ror.png\" alt=\"Ruby\"><span class=\"large\">Ruby on Rails</span></p>
					<div class=\"overline\">3.2.5</div>
					<br />
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=ruby193&framework=sinatra&app=sinatra\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-sinatra.png\" alt=\"Ruby\"><span class=\"large\">Ruby Sinatra</span></p>
					<div class=\"overline\">1.3.2</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=python2&framework=django&app=django&service=mysql&version=5.1\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-django.png\" alt=\"Ruby\"><span class=\"large\">Python Django</span></p>
					<div class=\"overline\">1.4</div>
					<br />					
				</div>			
			</a>
			<a href=\"/panel/app/add2?runtime=python2&framework=wsgi&app=wsgi\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-wsgi.png\" alt=\"Ruby\"><span class=\"large\">Python WSGI</span></p>
					<div class=\"overline\">2.7.3</div>
					<br />					
				</div>
			</a>
			<div class=\"clearfix\"></div>
			<br />
			<h3 class=\"colored\">{$lang['standalone']}</h3>
			<br />
			<a href=\"/panel/app/add2?runtime=php&framework=php&app=php\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" alt=\"PHP\"><span class=\"large\">PHP (Web)</span></p>
					<div class=\"overline\">5.3.10</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=python2&framework=standalone&app=python\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python2.png\" alt=\"Python\"><span class=\"large\">Python</span></p>
					<div class=\"overline\">2.6.5</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=java&framework=java_web&app=java\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" alt=\"Java\"><span class=\"large\">Java</span></p>
					<div class=\"overline\">1.6.0</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=java7&framework=java_web&app=java\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" alt=\"Java\"><span class=\"large\">Java</span></p>
					<div class=\"overline\">1.7.0</div>
					<br />
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=ruby193&framework=standalone&app=ruby\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" alt=\"Ruby\"><span class=\"large\">Ruby</span></p>
					<div class=\"overline\">1.9.3</div>
					<br />
				</div>
			</a>
			<a href=\"/panel/app/add2?runtime=node08&framework=node&app=node\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-node.png\" alt=\"Java\"><span class=\"large\">Node</span></p>
					<div class=\"overline\">0.8.2</div>
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