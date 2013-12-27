<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$me = api::send('self/whoami');
$me = $me[0];

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<h2>{$lang['change_plan']}</h2><br />
";

if( $me['iban'] )
{
	$content .= "<p class=\"large\">{$lang['warning']}</p>
	<br />
	<a class=\"btn\" href=\"/panel/storage/select_action?plan={$_GET['plan']}\">{$lang['select']}</a> <a class=\"btn\" href=\"/panel/plans\">{$lang['back']}</a>";
}
else
	$content .= "<p class=\"large\">{$lang['no_info']}</p><br />
				 <a class=\"btn\" href=\"/panel/billing/update\">{$lang['update']}</a>";
	
$content .= "
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>