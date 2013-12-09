<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['payment']}</h5></div>
				<div class=\"widget first\">
					<div class=\"head\"><h5 class=\"iImage2\">{$lang['choose']}</h5></div>
					<div class=\"body aligncenter\">
						<a href=\"/panel/bill/process?id={$_GET['id']}&mode=paypal\" title=\"\" class=\"btn55 mr10\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/middlenav/paypal.png\" alt=\"\" /><span>{$lang['paypal']}</span></a>
						<a href=\"/panel/bill/process?id={$_GET['id']}&mode=paypal\" title=\"\" class=\"btn55 mr10\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/middlenav/book.png\" alt=\"\" /><span>{$lang['card']}</span></a>
					</div>
				</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>