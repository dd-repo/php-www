<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/list', array('id'=>$_GET['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$news = $news[0];

$month = date('F', $news['date']);
$month_translate = $lang[$month];
	
$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">{$news['title']}</h1>
					<br />
					<div style=\"width: 305px; margin: 0 auto;\">
						<span style=\"color: #797979; font-size: 14px; display: block; float: left; padding-top: 7px;\">".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $news['date']))." {$lang['by']}</span>
						<img style=\"display: block; float: left; margin-left: 10px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/{$news['author']}.png\" class=\"author\" />
						<a style=\"display: block; float: left; padding-top: 8px; margin-left: 10px;\" href=\"/about/team#".$lang['author_' . $news['author']]."\">".$lang['author_' . $news['author']]."</a>
						<div class=\"clear\"></div>
					</div>
				</div>
			</div>	
			<div class=\"content\" style=\"width: 850px;\">
<!-- DESCRIPTION -->
				{$news['description']}
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				{$news['content']}
<!-- FIN ARTICLE -->
				<br />
				<a class=\"button classic\" style=\"float: right\" href=\"https://community.olympe.in/category/annonces\">{$lang['react']}</a>
				<div class=\"clear\"></div>
				<br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>