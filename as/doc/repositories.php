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
				<h3>{$lang['list']}</h3>
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th style=\"width: 110px;\">{$lang['name']}</th>
						<th style=\"width: 210px;\">{$lang['info']}</th>
						<th style=\"width: 40px;\">{$lang['version']}</th>
						<th style=\"width: 200px;\">{$lang['site']}</th>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-git.png\" style=\"width: 40px;\" alt=\"Git\"></td>
						<td>Git</td>
						<td>{$lang['git']}</td>
						<td>1.8.3.2</td>
						<td><a href=\"http://www.git-scm.com\">http://www.git-scm.com</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-svn.png\" style=\"width: 40px;\" alt=\"PostgeSQL\"></td>
						<td>Subversion</td>
						<td>{$lang['svn']}</td>
						<td>1.7.9</td>
						<td><a href=\"http://subversion.apache.org\">http://subversion.apache.org</a></td>
					</tr>
					<tr>
						<td style=\"text-align: center;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-hg.png\" style=\"width: 40px;\" alt=\"MongoDB\"></td>
						<td>Mercurial</td>
						<td>{$lang['mercurial']}</td>
						<td>2.6.3</td>
						<td><a href=\"http://mercurial.selenic.com\">http://mercurial.selenic.com</a></td>
					</tr>	
				</table>
				<br />
				<h3>{$lang['create']}</h3>
				<p>{$lang['create_text']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/57.png\" alt=\"57\" />
				<p>{$lang['create_text1']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/58.png\" alt=\"58\" />
				<p>{$lang['create_text2']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/59.png\" alt=\"59\" />
				<p>{$lang['create_text3']}</p>
				<img class=\"doc\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/doc/60.png\" alt=\"60\" />
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>