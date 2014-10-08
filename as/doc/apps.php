<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

require_once('as/doc/menu.php');

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\" style=\"float: left;\">{$lang['title']}</h1>
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\" class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" placeholder=\"{$GLOBALS['lang']['search']}\"  /></form>
				<div class=\"clear\"></div>
			</div>
		</div>
		<div class=\"content\">		
			<div class=\"left small\">
				<div class=\"sidemenu\">
					{$menu}
				</div>					
			</div>
			<div class=\"right big\">
				<h3>{$lang['intro']}</h3>
				<p>{$lang['intro_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"3\" />
				<br />
				<p>{$lang['languages_text']}</p>
				<br />
				<h3>{$lang['frameworks']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 40px; text-align: center;\">{$lang['doc']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/php\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" style=\"width: 40px;\" alt=\"PHP\"></a></td>
						<td>PHP (Web)</td>
						<td>{$lang['script']}</td>
						<td>5.5.3</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/php\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/rubyrails\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubyrails.png\" style=\"width: 40px;\" alt=\"Ruby on Rails\"></a></td>
						<td>Ruby on Rails</td>
						<td>{$lang['frameruby']}</td>
						<td>4.0.4</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/rubyrails\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/rubysinatra\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubysinatra.png\" style=\"width: 40px;\" alt=\"Ruby Sinatra\"></a></td>
						<td>Sinatra</td>
						<td>{$lang['frameruby']}</td>
						<td>1.4.5</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/rubysinatra\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/pythondjango\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythondjango.png\" style=\"width: 40px;\" alt=\"Python Django\"></a></td>
						<td>Django</td>
						<td>{$lang['framepython']}</td>
						<td>1.6.2</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/pythondjango\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/javatomcat\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-javatomcat.png\" style=\"width: 40px;\" alt=\"Tomcat\"></a></td>
						<td>Tomcat</td>
						<td>{$lang['framejava']}</td>
						<td>7.0.42</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/javatomcat\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
				</table>
				<br /><br />
				<h3>{$lang['languages']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 40px; text-align: center;\">{$lang['doc']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/phpworker\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" style=\"width: 40px;\" alt=\"PHP\"></a></td>
						<td>PHP (Worker)</td>
						<td>{$lang['script']}</td>
						<td>5.5.3</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/phpworker\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/ruby\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" style=\"width: 40px;\" alt=\"Ruby\"></a></td>
						<td>Ruby</td>
						<td>{$lang['script']}</td>
						<td>1.9.3</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/ruby\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/python\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python.png\" style=\"width: 40px;\" alt=\"Python\"></a></td>
						<td>Python</td>
						<td>{$lang['script']}</td>
						<td>2.7.5</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/python\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/nodejs\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-nodejs.png\" style=\"width: 40px;\" alt=\"NodeJS\"></a></td>
						<td>NodeJS</td>
						<td>{$lang['script']}</td>
						<td>0.10.26</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/nodejs\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/java\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" style=\"width: 40px;\" alt=\"JAVA\"></a></td>
						<td>Java</td>
						<td>{$lang['prog']}</td>
						<td>1.7.0</td>
						<td style=\"text-align: center;\"><a href=\"/doc/apps/java\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
				</table>

				<br />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
