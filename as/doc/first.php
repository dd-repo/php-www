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
				<br />
				<blockquote style=\"width: 500px; margin: 0 auto;\">
					<p>
						<span style=\"font-weight: bold;\">{$lang['primary']}</span> ns1.anotherservice.com - 178.32.167.250<br />
						<span style=\"font-weight: bold;\">{$lang['secondary']}</span> ns2.anotherservice.com - 178.32.65.70
					</p>
				</blockquote>
				<br />
				<h3>{$lang['domain']}</h3>
				<p>{$lang['domain_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/1.png\" alt=\"1\" />
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/2.png\" alt=\"2\" />
				<br />
				<h3>{$lang['app']}</h3>
				<p>{$lang['app_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/3.png\" alt=\"3\" />
				<p>{$lang['app_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"4\" />
				<p>{$lang['app_text3']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/5.png\" alt=\"5\" />
				<p>{$lang['app_text4']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/6.png\" alt=\"6\" />
				<br />
				<h3>{$lang['publish']}</h3>
				<p>{$lang['publish_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/7.png\" alt=\"7\" />
				<p>{$lang['publish2_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/8.png\" alt=\"8\" />
				<p>{$lang['publish3_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/9.png\" alt=\"9\" />
				<p>{$lang['publish4_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/10.png\" alt=\"10\" />
				<br />
				<h3>{$lang['access']}</h3>			
				<p>{$lang['access_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/11.png\" alt=\"11\" />
				<p>{$lang['access2_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/12.png\" alt=\"12\" />
				<br />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>