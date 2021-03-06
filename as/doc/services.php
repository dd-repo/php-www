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
						<td>2.4.9</td>
						<td><a href=\"http://www.mongodb.org\">http://www.mongodb.org</a></td>
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
				<h3>{$lang['create']}</h3>
				<p>{$lang['create_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/45.png\" alt=\"45\" />
				<p>{$lang['create_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/46.png\" alt=\"46\" />
				<p>{$lang['create_text3']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/47.png\" alt=\"47\" />
				<p>{$lang['create_text4']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/48.png\" alt=\"48\" />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>