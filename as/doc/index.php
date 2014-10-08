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
					<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\" class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" placeholder=\"{$GLOBALS['lang']['search']}\"  /></form>
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
					<span style=\"font-size: 25px; color: #555555; font-weight: bold;\">{$lang['questions']}</span>
					<br /><br />
					<span style=\"font-size: 20px; color: #555555;\">{$lang['answers']}</span>
					<br /><br /><br />
					<div style=\"float: left; width: 370px;\">
						<div style=\" padding-left: 10px; margin: 0 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['started']}</h3>
							<ol>
								<li><a href=\"/doc/what\">{$lang['what']}</a></li>
								<li><a href=\"/doc/techno\">{$lang['techno']}</a></li>
								<li><a href=\"/doc/info\">{$lang['infos']}</a></li>
								<li><a href=\"/doc/first\">{$lang['first']}</a></li>
							</ol>
						</div>
						<div style=\"padding-left: 10px; margin: 20px 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['advanced']}</h3>
							<ol>
								<li><a href=\"/doc/env\">{$lang['env']}</a></li>
								<li><a href=\"/doc/process\">{$lang['process']}</a></li>
								<li><a href=\"/doc/repositories\">{$lang['repositories']}</a></li>
								<li><a href=\"/doc/cloud\">{$lang['cloud']}</a></li>
							</ol>
						</div>
					</div>
					<div style=\"float: right; width: 370px;\">
						<div style=\"padding-left: 10px; margin: 0 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['features']}</h3>
							<ol>
								<li><a href=\"/doc/apps\">{$lang['apps']}</a></li>
								<li><a href=\"/doc/domains\">{$lang['domains']}</a></li>
								<li><a href=\"/doc/services\">{$lang['services']}</a></li>
								<li><a href=\"/doc/users\">{$lang['users']}</a></li>	
							</ol>	
						</div>
						<div style=\"padding-left: 10px; margin: 20px 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['account']}</h3>
							<ol>
								<li><a href=\"/doc/tools\">{$lang['tools']}</a></li>
								<li><a href=\"/doc/backups\">{$lang['backups']}</a></li>
								<li><a href=\"/doc/quotas\">{$lang['quotas']}</a></li>	
								<li><a href=\"/doc/tokens\">{$lang['tokens']}</a></li>
							</ol>			
						</div>						
					</div>
					<div class=\"clear\"></div>
					<div class=\"separator\" style=\"width: 600px;\"></div>
					<div style=\"position: relative;\">
						<h3 class=\"grey\" id=\"title\">{$lang['faq']}</h3>
						<div id=\"hiddentitle\" style=\"display: none;\">{$lang['faq']}</div>
						<div class=\"faq\">
							<div id=\"questions\">
								<div style=\"float: left; width: 400px;\">
									<div id=\"question-1\" class=\"question\" onclick=\"showAnswer(1); return false;\">{$lang['question_1']}</div>
									<div id=\"question-2\" class=\"question\" onclick=\"showAnswer(2); return false;\">{$lang['question_2']}</div>
									<div id=\"question-3\" class=\"question\" onclick=\"showAnswer(3); return false;\">{$lang['question_3']}</div>
									<div id=\"question-4\" class=\"question\" onclick=\"showAnswer(4); return false;\">{$lang['question_4']}</div>
									<div id=\"question-5\" class=\"question\" onclick=\"showAnswer(5); return false;\">{$lang['question_5']}</div>
								</div>
								<div style=\"float: right; width: 400px;\">
									<div id=\"question-6\" class=\"question\" onclick=\"showAnswer(6); return false;\">{$lang['question_6']}</div>
									<div id=\"question-7\" class=\"question\" onclick=\"showAnswer(7); return false;\">{$lang['question_7']}</div>
									<div id=\"question-8\" class=\"question\" onclick=\"showAnswer(8); return false;\">{$lang['question_8']}</div>
									<div id=\"question-9\" class=\"question\" onclick=\"showAnswer(9); return false;\">{$lang['question_9']}</div>
									<div id=\"question-10\" class=\"question\" onclick=\"showAnswer(10); return false;\">{$lang['question_10']}</div>
								</div>
							</div>
							<div id=\"answer-1\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(1); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['transfer']}</p>
								<br />
								<table>
									<tr>
										<th>{$lang['type']}</th>
										<th>{$lang['hostname']}</th>
										<th>{$lang['port']}</th>
										<th>{$lang['user']}</th>
									</tr>
									<tr>	
										<td>Git</td>
										<td>ssh://anotherservice.com</td>
										<td>22</td>
										<td><i>{$lang['name']}</i></td>
									</tr>
									<tr>	
										<td>FTP</td>
										<td>ftp.anotherservice.com</td>
										<td>21</td>
										<td><i>{$lang['name']}</i></td>
									</tr>
									<tr>	
										<td>SFTP</td>
										<td>ftp.anotherservice.com</td>
										<td>22</td>
										<td><i>{$lang['name']}</i></td>
									</tr>
								</table>
								<br /><br />
							</div>
							<div id=\"answer-2\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(2); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['dns']}</p>
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
							</div>
							<div id=\"answer-3\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(3); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['envi']}</p>
							</div>
							<div id=\"answer-4\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(4); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['errors']}</p>
							</div>
							<div id=\"answer-5\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(5); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['access']}</p>
							</div>
							<div id=\"answer-6\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(6); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['rebuild']}</p>
							</div>
							<div id=\"answer-7\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(7); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['subdomain']}</p>
							</div>
							<div id=\"answer-8\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(8); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['boot']}</p>
							</div>
							<div id=\"answer-9\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(9); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['groups']}</p>
							</div>
							<div id=\"answer-10\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(10); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['deploy']}</p>
							</div>
						</div>
					</div>
					<br /><br />
				</div>
				<div class=\"clear\"></div>
				<br /><br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>