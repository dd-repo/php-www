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
				<p class=\"large\">{$lang['intro_text']}</p>
				<br />
				<h3>{$lang['languages']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>PHP</td>
						<td>{$lang['script']}</td>
						<td>5.5.3</td>
						<td><a href=\"http://www.php.net\">http://www.php.net</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Ruby</td>
						<td>{$lang['script']}</td>
						<td>1.9.3</td>
						<td><a href=\"http://www.ruby-lang.org\">http://www.ruby-lang.org</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Python</td>
						<td>{$lang['script']}</td>
						<td>2.7.5</td>
						<td><a href=\"http://www.python.org\">http://www.python.org</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-nodejs.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>NodeJS</td>
						<td>{$lang['script']}</td>
						<td>0.10.26</td>
						<td><a href=\"http://www.nodejs.org\">http://www.nodejs.org</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Java</td>
						<td>{$lang['prog']}</td>
						<td>1.7.0</td>
						<td><a href=\"http://www.java.com\">http://www.java.com</a></td>
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
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubyrails.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Ruby on Rails</td>
						<td>{$lang['frameruby']}</td>
						<td>4.0.4</td>
						<td><a href=\"http://rubyonrails.org\">http://rubyonrails.org</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubysinatra.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Sinatra</td>
						<td>{$lang['frameruby']}</td>
						<td>1.4.5</td>
						<td><a href=\"http://www.sinatrarb.com\">http://www.sinatrarb.com</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythondjango.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Django</td>
						<td>{$lang['framepython']}</td>
						<td>1.6.2</td>
						<td><a href=\"http://www.djangoproject.com\">http://www.djangoproject.com</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-javatomcat.png\" style=\"width: 40px;\" alt=\"PHP\"></td>
						<td>Tomcat</td>
						<td>{$lang['framejava']}</td>
						<td>7.0.42</td>
						<td></td>
					</tr>
				</table>
				<br />
				<h3>{$lang['services']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mysql.png\" style=\"width: 40px;\" alt=\"MySQL\"></td>
						<td>MySQL MariaDB</td>
						<td>{$lang['db']}</td>
						<td>5.5</td>
						<td><a href=\"http://www.mariadb.com\">http://www.mariadb.com</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-pgsql.png\" style=\"width: 40px;\" alt=\"PostgeSQL\"></td>
						<td>PostgreSQL</td>
						<td>{$lang['db']}</td>
						<td>9.3</td>
						<td><a href=\"http://www.postgresql.com\">http://www.postgresql.com</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mongodb.png\" style=\"width: 40px;\" alt=\"MongoDB\"></td>
						<td>MongoDB</td>
						<td>{$lang['key']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-redis.png\" style=\"width: 40px;\" alt=\"Redis\"></td>
						<td>Redis</td>
						<td>{$lang['key']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>	
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-memcached.png\" style=\"width: 40px;\" alt=\"Memcached\"></td>
						<td>MemCached</td>
						<td>{$lang['key']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-rabbitmq.png\" style=\"width: 40px;\" alt=\"RabbitMQ\"></td>
						<td>RabbitMQ</td>
						<td>{$lang['queue']}</td>
						<td>{$lang['soon']}</td>
						<td>{$lang['soon']}</td>
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