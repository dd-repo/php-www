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
				<h2>{$lang['intro']}</h2>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 30px 0 30px 0;\">
					<a href=\"/doc/first\"><h4 class=\"colored\">{$lang['first']}</h4></a>
					<p>{$lang['first_text']}</p>			
				</div>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/concepts\"><h4 class=\"colored\">{$lang['concepts']}</h4></a>
					<p>{$lang['concepts_text']}</p>			
				</div>			
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/languages\"><h4 class=\"colored\">{$lang['languages']}</h4></a>
					<p>{$lang['languages_text']}</p>			
				</div>
			</div>
			<div style=\"float: right; text-align: left; width: 500px;\">
				<a class=\"btn\" style=\"float: right;\" href=\"/doc/info\">{$lang['info']}</a>
				<div class=\"clearfix\"></div>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 10px 0 30px 0;\">
					<a href=\"/doc/services\"><h4 class=\"colored\">{$lang['services']}</h4></a>
					<p>{$lang['services_text']}</p>			
				</div>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"/doc/first\"><h4 class=\"colored\">{$lang['developers']}</h4></a>
					<p>{$lang['developers_text']}</p>			
				</div>
				<div style=\"border-left: 3px solid #555555; padding-left: 10px; margin: 20px 0 30px 0;\">
					<a href=\"https://support.anotherservice.com\"><h4 class=\"colored\">{$lang['support']}</h4></a>
					<p>{$lang['support_text']}</p>			
				</div>
			</div>
			<div class=\"clearfix\"></div>
			<h2>{$lang['top']}</h2>
			<br />
			<ul style=\"list-style-type: none; margin: 0; padding: 0;\">
				<div style=\"float: left; width: 500px;\">
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_1']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/domains\">{$lang['question_2']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_3']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_4']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_5']}</a></li>
				</div>
				<div style=\"float: left; width: 500px; margin-left: 50px;\">
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_6']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_7']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_8']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_9']}</a></li>
					<li style=\"font-size: 18px; padding: 10px 10px 10px 0;\"><a href=\"/doc/faq/1\">{$lang['question_10']}</a></li>
				</div>				
			</ul>
		</div>
		<div class=\"clearfix\"></div>
		<br />
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>