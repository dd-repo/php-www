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
				<div style=\"float: left; width: 380px;\">
					<h2 class=\"dark\">{$lang['dns']}</h2>
					<table>
						<tr>
							<th>{$lang['host']}</th>
							<th>{$lang['ip']}</th>
						</tr>
						<tr>
							<td>ns1.anotherservice.com</td>
							<td>178.32.167.250</td>
						</tr>
						<tr>
							<td>ns2.anotherservice.com</td>
							<td>178.32.65.70</td>
						</tr>
					</table>
					<br /><br />
					<h2 class=\"dark\">{$lang['addresses']}</h2>
					<table>
						<tr>
							<th>{$lang['service']}</th>
							<th>{$lang['address']}</th>
						</tr>
						<tr>
							<td>PHP Info</td>
							<td><a href=\"https://phpinfo.anotherservice.com\">https://phpinfo.anotherservice.com</a></td>
						</tr>
						<tr>
							<td>{$lang['webmail']}</td>
							<td><a href=\"https://mail.anotherservice.com\">https://mail.anhotherservice.com</a></td>
						</tr>
						<tr>
							<td>{$lang['cloud']}</td>
							<td><a href=\"https://cloud.anotherservice.com\">https://cloud.anotherservice.com</a></td>
						</tr>
						<tr>
							<td>{$lang['pma']}</td>
							<td><a href=\"https://pma.anotherservice.com\">https://pma.anotherservice.com</a></td>
						</tr>
						<tr>
							<td>{$lang['ppa']}</td>
							<td><a href=\"https://ppa.anotherservice.com\">https://ppa.anotherservice.com</a></td>
						</tr>
						<tr>
							<td>{$lang['stats']}</td>
							<td><a href=\"https://stats.anotherservice.com\">https://stats.anotherservice.com</a></td>
						</tr>				
					</table>
				</div>
				<div style=\"float: right; width: 380px;\">
					<h2 class=\"dark\">{$lang['connection']}</h2>
					<table>
						<tr>
							<th>{$lang['service']}</th>
							<th>{$lang['host']}</th>
							<th>{$lang['port']}</th>
						</tr>
						<tr>
							<td>{$lang['ftp']}</td>
							<td>ftp.anotherservice.com</td>
							<td>21</td>
						</tr>
						<tr>
							<td>{$lang['sftp']}</td>
							<td>ftp.anotherservice.com</td>
							<td>22</td>
						</tr>
						<tr>
							<td>{$lang['ssh']}</td>
							<td>anotherservice.com</td>
							<td>22</td>
						</tr>
						<tr>
							<td>{$lang['mysql']}</td>
							<td>sql.anotherservice.com</td>
							<td>3306</td>
						</tr>
						<tr>
							<td>{$lang['pgsql']}</td>
							<td>psql.anotherservice.com</td>
							<td>5432</td>
						</tr>
						<tr>
							<td>{$lang['mongo']}</td>
							<td>mongo.anotherservice.com</td>
							<td>27017</td>
						</tr>
						<tr>
							<td>{$lang['smtp']}</td>
							<td>mail.anotherservice.com</td>
							<td>465</td>
						</tr>
						<tr>
							<td>{$lang['pop']}</td>
							<td>mail.anotherservice.com</td>
							<td>995</td>
						</tr>
						<tr>
							<td>{$lang['imap']}</td>
							<td>mail.anotherservice.com</td>
							<td>993</td>
						</tr>						
					</table>
				</div>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>