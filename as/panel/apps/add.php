<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$quotas =  api::send('self/quota/user/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'APPS' )
		$aquota = $q;
	if( $q['name'] == 'MEMORY' )
		$mquota = $q;
}

$domains = api::send('self/domain/list');

if( $_POST['password'] )
	$_SESSION['APP_PASS'] = security::encode($_POST['password']);
if( $_POST['tag'] )
	$_SESSION['APP_TAG'] = security::encode($_POST['tag']);

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
			<h2 class=\"dark\">{$lang['frameworks']}</h2>
			<a href=\"#\" onclick=\"$('#runtime').val('php55'); $('#standalone').val(0); $('#binary').hide(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" alt=\"PHP\"><span class=\"large\">PHP (Web)</span></p>
					<div class=\"overline\">5.5.3</div>
					<br />					
				</div>
			</a>
";
if( $mquota['max'] > 0 )
{
	$content .= "
			<a href=\"#\" onclick=\"$('#runtime').val('php52'); $('#standalone').val(0); $('#binary').hide(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-php.png\" alt=\"PHP\"><span class=\"large\">PHP (Web)</span></p>
					<div class=\"overline\">5.2.17</div>
					<br />					
				</div>
			</a>						
			<a href=\"#\" onclick=\"$('#runtime').val('rails40'); $('#standalone').val(0); $('#binary').hide(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubyrails.png\" alt=\"Ruby on Rails\"><span class=\"large\">Ruby on Rails</span></p>
					<div class=\"overline\">4.0.4</div>
					<br />
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('sinatra14'); $('#standalone').val(1); $('#binary').show(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-rubysinatra.png\" alt=\"Ruby Sinatra\"><span class=\"large\">Ruby Sinatra</span></p>
					<div class=\"overline\">1.4.5</div>
					<br />					
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('django16'); $('#standalone').val(0); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-pythondjango.png\" alt=\"Python Django\"><span class=\"large\">Python Django</span></p>
					<div class=\"overline\">1.6.2</div>
					<br />					
				</div>			
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('tomcat70'); $('#standalone').val(0); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-javatomcat.png\" alt=\"Tomcat\"><span class=\"large\">Java Tomcat</span></p>
					<div class=\"overline\">7.0.42</div>
					<br />
				</div>
			</a>
			<div class=\"clear\"></div>
			<br />
			<h2 class=\"dark\">{$lang['standalone']}</h2>
			<a href=\"#\" onclick=\"$('#runtime').val('phpworker55'); $('#standalone').val(1); $('#binary').show(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-phpworker.png\" alt=\"PHP (Worker)\"><span class=\"large\">PHP (Worker)</span></p>
					<div class=\"overline\">5.5.3</div>
					<br />					
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('python27'); $('#standalone').val(1); $('#binary').show(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-python.png\" alt=\"Python\"><span class=\"large\">Python</span></p>
					<div class=\"overline\">2.7.4</div>
					<br />					
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('java17'); $('#standalone').val(1); $('#binary').show(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-java.png\" alt=\"Java\"><span class=\"large\">Java</span></p>
					<div class=\"overline\">1.7.0</div>
					<br />
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('ruby19'); $('#standalone').val(1); $('#binary').show(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-ruby.png\" alt=\"Ruby\"><span class=\"large\">Ruby</span></p>
					<div class=\"overline\">1.9.3</div>
					<br />
				</div>
			</a>
			<a href=\"#\" onclick=\"$('#runtime').val('nodejs010'); $('#standalone').val(1); $('#binary').show(); $('#new').dialog('open'); return false;\">
				<div class=\"nservice\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-nodejs.png\" alt=\"NodeJS\"><span class=\"large\">NodeJS</span></p>
					<div class=\"overline\">0.10.26</div>
					<br />
				</div>
			</a>			
			<div class=\"clear\"></div>
			<br /><br />
	";
}
$content .= "
		</div>
	</div>
	<div id=\"new\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['new']}</h3>
		<p style=\"text-align: center;\">{$lang['new_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/add_action\" method=\"post\" class=\"center\">
				<input id=\"runtime\" type=\"hidden\" name=\"runtime\" value=\"{$_SESSION['APP_RUNTIME']}\" />
				<input id=\"standalone\" type=\"hidden\" name=\"standalone\" value=\"{$_SESSION['APP_STANDALONE']}\" />
				<input type=\"hidden\" name=\"pass\" value=\"{$_SESSION['APP_PASS']}\" />
				<input type=\"hidden\" name=\"tag\" value=\"{$_SESSION['APP_TAG']}\" />
				<input type=\"hidden\" name=\"nodocker\" value=\"".($mquota['max']>0?"0":"1")."\" />
				<fieldset>
					<input type=\"text\" disabled value=\"{$_SESSION['APP_TAG']}\" />
					<span class=\"help-block\">{$lang['name']}</span>
				</fieldset>
				<fieldset>
					<input type=\"text\" disabled value=\"{$_SESSION['APP_PASS']}\" />
					<span class=\"help-block\">{$lang['password']}</span>
				</fieldset>
				<fieldset>
					<select name=\"domain\">";
					
	foreach( $domains as $d )
		$content .= "		<option value=\"{$d['hostname']}\">{$d['hostname']}</option>";

	$content .= "
					</select>
					<span class=\"help-block\">{$lang['help_domain']}</span>
				</fieldset>
				<fieldset id=\"binary\" style=\"display: none;\">
					<input class=\"auto\" type=\"text\" value=\"{$lang['binary']}\" name=\"binary\" onfocus=\"this.value = this.value=='{$lang['binary']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['binary']}' : this.value; this.value=='{$lang['binary']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
					".(isset($_GET['estandalone'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['error_binary']}</span>":"<span class=\"help-block\">{$lang['binary_help']}</span>")."
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('new', 550);
";

if( isset($_GET['estandalone']) )
{
	$content .= "
		$('#binary').show();
		$('#new').dialog('open');
	";
}

$content .= "
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>