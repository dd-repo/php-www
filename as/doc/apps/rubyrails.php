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
				<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input  name=\"keyword\"  class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
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
				<h3>{$lang['create']}</h3>
				<p>{$lang['create_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"7\" />
				<p>{$lang['create_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/24.png\" alt=\"9\" />
				<p>{$lang['create_text3']}</p>
				<blockquote style=\"width: 700px; margin: 0 auto;\">
					<p>
						<span style=\"font-weight: bold;\">{$lang['sftp']}</span> sftp://rubyrails-xxxxxx@ftp.anotherservice.com/master<br />
						<span style=\"font-weight: bold;\">{$lang['git']}</span> ssh://rubyrails-xxxxxx@git.as/~utilisateur/rubyrails-xxxxxxx.git
					</p>
				</blockquote>
				<p>{$lang['create_text4']}</p>
				<pre>
					<code>git clone https://github.com/appfog/af-ruby-rails</code>
				</pre>
				<p>{$lang['create_text5']}</p>
				<pre><code>git clone ssh://rubyrails-xxxxxx@git.as/~utilisateur/rubyrails-xxxxxxx.git
cd rubyrails-xxxxxxx.git
git add *
git commit -a -m \"First commit\"
git push origin master</code></pre>
				<p>{$lang['create_text6']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/25.png\" alt=\"25\" />
				<p>{$lang['create_text7']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/29.png\" alt=\"29\" />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>