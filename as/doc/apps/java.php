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
					<code>java server</code>
				</pre>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/34.png\" alt=\"34\" />
				<p>{$lang['create_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/35.png\" alt=\"35\" />
				<p>{$lang['create_text3']}</p>
				<blockquote style=\"width: 700px; margin: 0 auto;\">
					<p>
						<span style=\"font-weight: bold;\">{$lang['sftp']}</span> sftp://java-xxxxxx@ftp.anotherservice.com/master<br />
						<span style=\"font-weight: bold;\">{$lang['git']}</span> ssh://java-xxxxxx@git.as/~utilisateur/java-xxxxxxx.git
					</p>
				</blockquote>
				<p>{$lang['create_text4']}</p>
				<pre>
					<code>import java.io.IOException;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;

public class server
{
	public static void main(String[] args) throws Exception
	{
		int port = 8080;
		ServerSocket serverSocket = new ServerSocket(port);
		System.err.println(\"Server launched on port: \" + port);

		while (true)
		{
			Socket clientSocket = serverSocket.accept();
			BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			BufferedWriter out = new BufferedWriter(new OutputStreamWriter(clientSocket.getOutputStream()));

			String s;
			while ((s = in.readLine()) != null) 
			{
				System.out.println(s);
				if (s.isEmpty())
				{
					break;
				}
			}

			out.write(\"HTTP/1.0 200 OK\\r\\n\");
			out.write(\"Date: Fri, 31 Dec 1999 23:59:59 GMT\\r\\n\");
			out.write(\"Server: AnotherService/0.1\\r\\n\");
			out.write(\"Content-Type: text/html\\r\\n\");
			out.write(\"Content-Length: 13\\r\\n\");
			out.write(\"Expires: Sat, 01 Jan 2000 00:59:59 GMT\\r\\n\");
			out.write(\"Last-modified: Fri, 09 Aug 1996 14:21:40 GMT\\r\\n\");
			out.write(\"\\r\\n\");
			out.write(\"Hello, World!\");

			out.close();
			in.close();
			clientSocket.close();
		}
	}
}</code>
				</pre>
				<p>{$lang['compile']}</p>
				<pre>
					<code>javac server.java</code>
				</pre>
				<p>{$lang['create_text5']}</p>
				<pre><code>git clone ssh://java-xxxxxx@git.as/~utilisateur/java-xxxxxxx.git
cd java-xxxxxxx.git
git add server.class
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