<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/list', array(), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
					<br />
					<a class=\"button classic\" href=\"/blog/rss\" style=\"width: 120px; height: 23px; padding: 8px 5px 3px 8px;  margin: 0; display: inline-block; font-size: 12px;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/rss.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['rss']}</span>
					</a>
					<a class=\"button classic\" href=\"http://twitter.com/anotherservice\" style=\"width: 120px; height: 23px; padding: 8px 5px 3px 8px; margin: 0 0 0 10px; display: inline-block; font-size: 12px;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/twitter.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['follow']}</span>
					</a>
				</div>
			</div>	
			<div class=\"content\">
";

foreach( $news as $n )
{
	$content .= "
				<div class=\"article\">
					<a href=\"/blog/read?id=1\"><h1 class=\"dark\" style=\"text-align: center;\">{$n['title']}</h1></a>
					<span class=\"date\">".date($lang['DATEFORMAT'], $n['date']).", {$lang['by']} <a href='/blog/author?id=1'>{$n['author']}</a></span>
					<br /><br />
					<img class=\"blogimage\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/news/{$n['id']}.png\"/>
					<div style=\"text-align: left; width: 800px; margin: 0 auto; margin-top: 20px; font-size: 16px;\">
						{$n['description']}
						<p style=\"text-align: right;\"><a href=\"/blog/read?id=1\">{$lang['read']}</a></p>
					</div>
					<div class=\"clear\"></div>
				</div>
	";
}

$content .= "
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>