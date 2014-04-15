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
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/4.png\" alt=\"4\" />
				<p>{$lang['create_text1']}</p>
				<pre>
					<code>python server.py</code>
				</pre>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/27.png\" alt=\"27\" />
				<p>{$lang['create_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/31.png\" alt=\"31\" />
				<p>{$lang['create_text3']}</p>
				<blockquote style=\"width: 700px; margin: 0 auto;\">
					<p>
						<span style=\"font-weight: bold;\">{$lang['sftp']}</span> sftp://python-xxxxxx@ftp.anotherservice.com/master<br />
						<span style=\"font-weight: bold;\">{$lang['git']}</span> ssh://python-xxxxxx@git.as/~utilisateur/python-xxxxxxx.git
					</p>
				</blockquote>
				<p>{$lang['create_text4']}</p>
				<pre>
					<code>#!/usr/bin/python
def app(environ, start_response):
    start_response('200 OK', [])
    yield \"".htmlspecialchars("<html><div style='text-align: center; font-size: 20px;'><br /><br />Hello, World!</div></html>")."\"
 
if __name__ == '__main__':
    from wsgiref.simple_server import make_server
    server = make_server('0.0.0.0', 8080, app)
    server.serve_forever()</code>
				</pre>
				<p>{$lang['create_text5']}</p>
				<pre><code>git clone ssh://python-xxxxxx@git.as/~utilisateur/python-xxxxxxx.git
cd python-xxxxxxx.git
git add server.py
git commit -a -m \"First commit\"
git push origin master</code></pre>
				<p>{$lang['create_text6']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/25.png\" alt=\"25\" />
				<p>{$lang['create_text7']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/30.png\" alt=\"30\" />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>