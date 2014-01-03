<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$lang = translator::getLanguage();

$news = api::send('news/list', array('limit'=>10), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$xml = "
<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><rss version=\"2.0\">
	<channel> 
		<title>{$lang['channel']}</title>
		<link>http://www.olympe.in</link>
		<description>{$lang['description']}</description>
";

foreach( $news as $n )
{
	$xml .= "
			<item>
				<title>{$n['title']}</title>
				<link>http://www.olympe.in/blog/post?id={$n['id']}</link>
				<pubDate>."date("D, d M Y H:i:s", $n['date'])." GMT</pubDate> 
				<description>{$n['description']}</description>
			</item>
	";
}

$content .= "
	</channel>
</rss>
";

echo $content;