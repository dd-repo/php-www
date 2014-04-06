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
			<a href=\"#\" onclick=\"$('#vendor').val('mysql'); $('#version').val('5.5'); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mysql.png\" alt=\"mysql\"><span class=\"large\">MySQL</span><br /><span style=\"color: #000000;\" class=\"small\">MySQL Database Service</span></p>
					<div class=\"overline\">5.5</div>
					<br />		
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#vendor').val('pgsql'); $('#version').val('9.1'); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-pgsql.png\" alt=\"postgresql\"><span class=\"large\">PostgreSQL</span><br /><span style=\"color: #000000;\" class=\"small\">PostgreSQL Database Service</span></p>
					<div class=\"overline\">9.1</div>
					<br />					
				</div>
			</a>				
			<a href=\"#\" onclick=\"$('#vendor').val('mongo'); $('#version').val('9.1'); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-mongodb.png\" alt=\"mongodb\"><span class=\"large\">MongoDB</span><br /><span style=\"color: #000000;\" class=\"small\">MongoDB datastore</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>
			</a>
			<div class=\"clearfix\"></div>
			<br />	
			<a href=\"#\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-redis.png\" alt=\"redis\"><span class=\"large\">Redis</span><br /><span style=\"color: #000000;\" class=\"small\">Redis clé-valeur datastore</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>
			</a>
			<a href=\"#\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-memcached.png\" alt=\"memcached\"><span class=\"large\">Memcached</span><br /><span style=\"color: #000000;\" class=\"small\">Memcached bucket</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>
			</a>
			<a href=\"#\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-rabbitmq.png\" alt=\"rabbitmq\"><span class=\"large\">RabbitMQ</span><br /><span style=\"color: #000000;\" class=\"small\">RabbitMQ Queue Service</span></p>
					<div class=\"overline\">{$lang['soon']}</div>
					<br />					
				</div>
			</a>			
			<div class=\"clear\"></div>
		</div>
	</div>
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: center;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/services/add_action\" method=\"post\" class=\"center\">
				<input id=\"vendor\" type=\"hidden\" name=\"vendor\" value=\"\" />
				<input id=\"version\" type=\"hidden\" name=\"version\" value=\"\" />
				<fieldset>
					<input class=\"auto\" type=\"text\" value=\"{$lang['desc']}\" name=\"desc\" onfocus=\"this.value = this.value=='{$lang['desc']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['desc']}' : this.value; this.value=='{$lang['desc']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['desc_help']}</span>
				</fieldset>
				<fieldset>
					<input class=\"auto\" type=\"password\" value=\"{$lang['password']}\" name=\"pass\" onfocus=\"this.value = this.value=='{$lang['password']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['password']}' : this.value; this.value=='{$lang['password']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					<span class=\"help-block\">{$lang['password_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newDialog('new', 550, 350);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>