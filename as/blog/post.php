<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('busit/news/list', array(), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
					<br />
					<a class=\"button classic\" href=\"/news/rss\" style=\"width: 120px; height: 23px; padding: 8px 5px 3px 8px;  margin: 0; display: inline-block; font-size: 12px;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/rss.png\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['rss']}</span>
					</a>
					<a class=\"button classic\" href=\"http://twitter.com/Bus_IT\" style=\"width: 120px; height: 23px; padding: 8px 5px 3px 8px; margin: 0 0 0 10px; display: inline-block; font-size: 12px;\">
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
					<a href=\"/blog/read?id=1\"><h1 class=\"dark\" style=\"text-align: center;\">{$n['news_title']}</h1></a>
					<span class=\"date\">".date($lang['DATEFORMAT'], $n['news_date']).", {$lang['by']} <a href='/blog/author?id=1'>{$n['news_author']}</a></span>
					<br /><br />
					<img class=\"blogimage\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/news/{$n['news_id']}.png\"/>
					<div style=\"text-align: left; width: 800px; margin: 0 auto; margin-top: 20px; font-size: 16px;\">
						{$n['news_description']}
						<p style=\"text-align: right;\"><a href=\"/blog/read?id=1\">{$lang['read']}</a></p>
					</div>
					<div class=\"clear\"></div>
				</div>
	";
}

$content .= "
				
				<p style=\"text-align: center; margin-top: 40px;\">Newer posts &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/blog/previous\">Older posts</a></p>
				<p style=\"text-align: center;\">You can also browse the <a href=\"/blog/archive\">blog archive</a>.</p>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>