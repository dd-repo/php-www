<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['title']}</h5></div>
				<div class=\"widget first\">
					<div class=\"head\"><h5 class=\"iCreate\">{$lang['subtitle']}</h5></div>
					<div class=\"body\">
						{$lang['intro']}
						<br /><br />
						<a href=\"https://stats.olympe.in\" title=\"\" class=\"btnIconLeft mr10 mt5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/chart5.png\" alt=\"\" class=\"icon\" /><span>{$lang['access']}</span></a>
						</p>						
					</div>
				</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);
?>
