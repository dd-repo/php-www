<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head-light\">
				<div class=\"container\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
			</div>	
			<div class=\"content\">
				<div class=\"left big\">
					<h4>{$lang['intro']}</h4>
					<p>{$lang['intro_text']}</p>
					<br />
					<h4>{$lang['data']}</h4>
					<p>{$lang['data_text']}</p>
				</div>
				<div class=\"right small border\">
					<h4>{$lang['follow']}</h4>
					<p><a href=\"http://twitter.com/anotherservice\">Twitter</a></p>
					<p><a href=\"http://www.facebook.com/another.service\">Facebook</a></p>
					<p><a href=\"http://www.linkedin.com/company/2401897\">LinkedIn</a></p>
					<p><a href=\"/blog\">{$lang['news']}</a></p>
					<br />
					<h4>{$lang['behind']}</h4>
					<p>{$lang['behind_text']}</p>
					<br />
					<h4>{$lang['legal']}</h4>
					<p>{$lang['legal_text']}</p>
				</div>
				<div class=\"clear\"></div>
				<br /><br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>