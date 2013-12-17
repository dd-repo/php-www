<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">		
			<div style=\"float: left; width: 500px;\">
				<h2>{$lang['access']}</h2>
			</div>
			<div style=\"float: right; text-align: right; width: 300px;\">
				<a class=\"btn\" href=\"/doc\">{$lang['back']}</a>		
			</div>
			<div class=\"clearfix\"></div>
			<br />
			<div style=\"float: left; width: 500px;\">
				<h4 class=\"colored\">{$lang['addresses']}</h4>
				<br />
				<table>
					<tr>
						<th>{$lang['service']}</th>
						<th>{$lang['address']}</th>
					</tr>
					<tr>
						<td>{$lang['webmail']}</td>
						<td><a href=\"https://mail.anotherservice.com\">https://mail.anotherservice.com</a></td>
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
				</table>
				<br /><br />
				<h2>{$lang['contact']}</h2>
				<br />
				<h4 class=\"colored\">{$lang['addresses']}</h4>
				<br />
				<table>
					<tr>
						<th>{$lang['service']}</th>
						<th>{$lang['address']}</th>
					</tr>
					<tr>
						<td>{$lang['status']}</td>
						<td><a href=\"https://www.anotherservice.com/status\">https://www.anotherservice.com/status</a></td>
					</tr>
					<tr>
						<td>{$lang['support']}</td>
						<td><a href=\"https://support.anotherservice.com/projects/support\">https://support.anotherservice.com</a></td>
					</tr>
					<tr>
						<td>{$lang['incident']}</td>
						<td><a href=\"mailto:hosting@anotherservice.com\">hosting@anotherservice.com</a></td>
					</tr>
					<tr>
						<td>{$lang['doc']}</td>
						<td><a href=\"https://www.anotherservice.com/doc\">https://www.anotherservice.com/doc</a></td>
					</tr>			
				</table>
			</div>
			<div style=\"float: right; width: 500px;\">
				<h4 class=\"colored\">{$lang['dns']}</h4>
				<br />
				<table>
					<tr>
						<th>{$lang['serv']}</th>
						<th>{$lang['host']}</th>
						<th>{$lang['ip']}</th>
					</tr>
					<tr>
						<td>{$lang['ns1']}</td>
						<td>ns1.anotherservice.com</td>
						<td>178.32.167.250</td>
					</tr>
					<tr>
						<td>{$lang['ns2']}</td>
						<td>ns2.anotherservice.com</td>
						<td>178.32.65.70</td>
					</tr>
				</table>
				<br /><br />
				<h4 class=\"colored\">{$lang['connection']}</h4>
				<br />
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
						<td>sql.anotherservice.com</td>
						<td>5432</td>
					</tr>
					<tr>
						<td>{$lang['smtp']}</td>
						<td>mail.anotherservice.com</td>
						<td>25 / 465</td>
					</tr>
					<tr>
						<td>{$lang['pop']}</td>
						<td>mail.anotherservice.com</td>
						<td>110 / 995</td>
					</tr>
					<tr>
						<td>{$lang['imap']}</td>
						<td>mail.anotherservice.com</td>
						<td>143 / 993</td>
					</tr>						
				</table>
			</div>
		</div>
		<div class=\"clearfix\"></div>
		<br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>