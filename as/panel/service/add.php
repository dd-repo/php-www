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
			<a href=\"/panel/service/add2?vendor=mysql&version=5.1\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mysql.png\" alt=\"mysql\"><span class=\"large\">MySQL</span><br /><span style=\"color: #000000;\" class=\"small\">MySQL Database Service</span></p>
					<div class=\"overline\">5.5</div>
					<br />		
				</div>
			</a>
			<a href=\"/panel/service/add2?vendor=postgresql&version=9.0\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-postgresql.png\" alt=\"postgresql\"><span class=\"large\">PostgreSQL</span><br /><span style=\"color: #000000;\" class=\"small\">PostgreSQL Database Service</span></p>
					<div class=\"overline\">9.0</div>
					<br />					
				</div>
			</a>				
			<a href=\"/panel/service/add2?vendor=mongodb&version=1.8\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mongodb.png\" alt=\"mongodb\"><span class=\"large\">MongoDB</span><br /><span style=\"color: #000000;\" class=\"small\">MongoDB datastore</span></p>
					<div class=\"overline\">1.8</div>
					<br />					
				</div>
			</a>
			<div class=\"clearfix\"></div>
			<br />	
			<a href=\"/panel/service/add2?vendor=redis&version=2.2\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-redis.png\" alt=\"redis\"><span class=\"large\">Redis</span><br /><span style=\"color: #000000;\" class=\"small\">Redis clé-valeur datastore</span></p>
					<div class=\"overline\">2.2</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/service/add2?vendor=memcached&version=1.4\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-memcached.png\" alt=\"memcached\"><span class=\"large\">Memcached</span><br /><span style=\"color: #000000;\" class=\"small\">Memcached bucket</span></p>
					<div class=\"overline\">1.4</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/service/add2?vendor=rabbitmq&version=2.4\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-rabbitmq.png\" alt=\"rabbitmq\"><span class=\"large\">RabbitMQ</span><br /><span style=\"color: #000000;\" class=\"small\">RabbitMQ Queue Service</span></p>
					<div class=\"overline\">2.4</div>
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