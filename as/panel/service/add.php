<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<a href=\"/panel/service/add2?vendor=mysql&version=5.5\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mysql.png\" alt=\"mysql\"><span class=\"large\">MySQL</span><br /><span style=\"color: #000000;\" class=\"small\">MySQL Database Service</span></p>
					<div class=\"overline\">5.5</div>
					<br />		
				</div>
			</a>
			<a href=\"/panel/service/add2?vendor=postgresql&version=9.0\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-postgresql.png\" alt=\"postgresql\"><span class=\"large\">PostgreSQL</span><br /><span style=\"color: #000000;\" class=\"small\">PostgreSQL Database Service</span></p>
					<div class=\"overline\">9.0</div>
					<br />					
				</div>
			</a>				
			<a href=\"/panel/service/add2?vendor=mongodb&version=1.8\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mongodb.png\" alt=\"mongodb\"><span class=\"large\">MongoDB</span><br /><span style=\"color: #000000;\" class=\"small\">MongoDB datastore</span></p>
					<div class=\"overline\">1.8</div>
					<br />					
				</div>
			</a>
			<div class=\"clearfix\"></div>
			<br />	
			<a href=\"/panel/service/add2?vendor=redis&version=2.2\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-redis.png\" alt=\"redis\"><span class=\"large\">Redis</span><br /><span style=\"color: #000000;\" class=\"small\">Redis clé-valeur datastore</span></p>
					<div class=\"overline\">2.2</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/service/add2?vendor=memcached&version=1.4\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-memcached.png\" alt=\"memcached\"><span class=\"large\">Memcached</span><br /><span style=\"color: #000000;\" class=\"small\">Memcached bucket</span></p>
					<div class=\"overline\">1.4</div>
					<br />					
				</div>
			</a>
			<a href=\"/panel/service/add2?vendor=rabbitmq&version=2.4\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-rabbitmq.png\" alt=\"rabbitmq\"><span class=\"large\">RabbitMQ</span><br /><span style=\"color: #000000;\" class=\"small\">RabbitMQ Queue Service</span></p>
					<div class=\"overline\">2.4</div>
					<br />					
				</div>
			</a>			
			<div class=\"clearfix\"></div>
		</div>
	</div>
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: center;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/database/add_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['desc']}\" name=\"desc\" onfocus=\"this.value = this.value=='{$lang['desc']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['desc']}' : this.value; this.value=='{$lang['desc']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['desc_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"password\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['password_help']}</span>
				</fieldset>
				<fieldset>
					<select name=\"type\">
						<option value=\"mysql\">MySQL</option>
						<option value=\"postgresql\" disabled>PostgreSQL</option>
						<option value=\"postgresql\" disabled>MongoDB </option>
					</select>
					<span class=\"help-block\">{$lang['type_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>