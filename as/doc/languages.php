<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<div style=\"float: left; width: 500px;\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div style=\"float: right; width: 500px;\">
					<a class=\"button classic\" href=\"/doc\" style=\"float: right; height: 22px; width: 150px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['back']}</span>
					</a>
				</div>
				<div class=\"clear\"></div>
			</div>
		</div>
		<div class=\"content\">		
			<h3>{$lang['intro']}</h3>
			<p class=\"large\">{$lang['intro_text']}</p>
			<br />
			<div style=\"width: 500px; float: left;\">
				<table>
					<tr>
						<th>{$lang['language']}</th>
						<th>{$lang['name']}</th>
						<th>{$lang['framework']}</th>
						<th>{$lang['version']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/php\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/php\">PHP</a></td>
						<td>Web</td>
						<td>5.4.9, 5.2.17</td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/rails\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubyrails.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/rails\">Ruby</a></td>
						<td>Rails</td>
						<td>4.0.2</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/sinatra\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubysinatra.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/sinatra\">Ruby</a></td>
						<td>Sinatra</td>
						<td>{$lang['soon']}</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/tomcat\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-javatomcat.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/tomcat\">JAVA</a></td>
						<td>Tomcat</td>
						<td>{$lang['soon']}</td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/django\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythondjango.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/django\">Python</a></td>
						<td>Django</td>
						<td>{$lang['soon']}</td>
					</tr>
				</table>
			</div>
			<div style=\"width: 500px; float: right;\">
				<table>
					<tr>
						<th>{$lang['language']}</th>
						<th>{$lang['name']}</th>
						<th>{$lang['framework']}</th>
						<th>{$lang['version']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/wsgi\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythonwsgi.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/wsgi\">Python</a></td>
						<td>WSGI</td>
						<td>{$lang['soon']}</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/java\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/java\">Java</a></td>
						<td>-</td>
						<td>1.7.0</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/ruby\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" style=\"width: 50px;\" alt=\"Ruby\"></a></td>
						<td><a href=\"/doc/ruby\">Ruby</a></td>
						<td>-</td>
						<td>1.9.3</td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/python\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python.png\" style=\"width: 50px;\" alt=\"Python\"></a></td>
						<td><a href=\"/doc/python\">Python</a></td>
						<td>-</td>
						<td>2.7.4</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/nodejs\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-nodejs.png\" style=\"width: 50px;\" alt=\"Ruby\"></td>
						<td><a href=\"/doc/nodejs\">NodeJS</td>
						<td>-</td>
						<td>{$lang['soon']}</td>
					</tr>	
				</table>
			</div>
			<div class=\"clear\"></div>
			<br />
			<h3>{$lang['tutorials']}</h3>
			<div style=\"width: 500px; float: left;\">
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/wordpress\"><h4 class=\"colored\">{$lang['wordpress']}</h4></a>
					<p>{$lang['wordpress_text']}</p>			
				</div>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/ezpublish\"><h4 class=\"colored\">{$lang['ezpublish']}</h4></a>
					<p>{$lang['ezpublish_text']}</p>			
				</div>	
			</div>
			<div style=\"width: 500px; float: right;\">
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/wordpress\"><h4 class=\"colored\">{$lang['drupal']}</h4></a>
					<p>{$lang['drupal_text']}</p>			
				</div>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/ezpublish\"><h4 class=\"colored\">{$lang['redmine']}</h4></a>
					<p>{$lang['redmine_text']}</p>			
				</div>	
			</div>
		</div>
		<div class=\"clear\"></div>
		<p class=\"large\" style=\"text-align: center;\">
			<a class=\"button classic\" style=\"width: 120px; margin: 0 auto;\" href=\"/doc\">{$lang['back']}</a>
		</p>
		<br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>