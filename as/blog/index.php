<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$news = api::send('news/select', array(), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
";

if( count($news) > 0 )
{
	foreach( $news as $n )
	{
		$d = date('d', $n['date']);
		$m = date('M', $n['date']);
		$y = date('Y', $n['date']);
		
		$content .= "
			<div class=\"blogentry\">
				<span class=\"bigdate\">
					{$d}<br />{$m}<br />{$y}
				</span>
				<span style=\"float: left; margin: 5px 0 0 20px; display: block;\">
					<a href=\"/blog/view?id={$n['id']}\"><h2 style=\"color: #424242;\">{$n['title']}</h2></a>
					<span class=\"author\">{$lang['by']} {$n['author']}</span>
				</span>
				<div class=\"clearfix\"></div>
				<a href=\"/blog/view?id={$n['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/news/{$n['id']}.png\" class=\"newssmall\" /></a>
				<p class=\"large\">{$n['description']}</p>
				<div style=\"float: left;\">
					<div class=\"social\">
						<div class=\"fb-like\" data-href=\"https://www.anotherservice.com/blog/view?id=32\" data-width=\"\" data-height=\"\" data-colorscheme=\"light\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-send=\"false\"></div>
					</div>
					<div class=\"social\">
						<div class=\"g-plusone\" data-size=\"medium\"></div>
					</div>
				</div>
				<a class=\"btn\" style=\"float: right; margin-top: 10px;\" href=\"/blog/view?id={$n['id']}\">{$lang['read']}</a>
				<div class=\"clearfix\"></div>
				<br />
				<div class=\"seperator-light\"></div>
				
			</div>";
	}
}

$content .= "
			<script type=\"text/javascript\">
				window.___gcfg = {lang: 'fr'};
			
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/plusone.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>