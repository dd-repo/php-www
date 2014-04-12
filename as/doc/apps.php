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
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\" class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
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
				<h3>{$lang['languages']}</h3>
				<p>{$lang['languages_text']}</p>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 40px; text-align: center;\">{$lang['doc']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/php\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" style=\"width: 40px;\" alt=\"PHP\"></a></td>
						<td>PHP</td>
						<td>{$lang['script']}</td>
						<td>5.5.3</td>
						<td style=\"text-align: center;\"><a href=\"/doc/php\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><a href=\"/doc/ruby\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" style=\"width: 40px;\" alt=\"Ruby\"></a></td>
						<td>Ruby</td>
						<td>{$lang['script']}</td>
						<td>1.9.3</td>
						<td style=\"text-align: center;\"><a href=\"/doc/ruby\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" alt=\"\" /></a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python.png\" style=\"width: 40px;\" alt=\"Python\"></td>
						<td>Python</td>
						<td>{$lang['script']}</td>
						<td></td>
						<td style=\"text-align: center;\"></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-nodejs.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>NodeJS</td>
						<td>{$lang['script']}</td>
						<td></td>
						<td style=\"text-align: center;\"></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Java</td>
						<td>{$lang['prog']}</td>
						<td></td>
						<td style=\"text-align: center;\"></td>
					</tr>
				</table>
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
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubyrails.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Ruby on Rails</td>
						<td>{$lang['frameruby']}</td>
						<td>4.0.4</td>
						<td style=\"text-align: center;\"></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubysinatra.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Sinatra</td>
						<td>{$lang['frameruby']}</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythondjango.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Django</td>
						<td>{$lang['framepython']}</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythonwsgi.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>WSGI</td>
						<td>{$lang['framepython']}</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-javatomcat.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Tomcat</td>
						<td>{$lang['framejava']}</td>
						<td></td>
						<td></td>
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
