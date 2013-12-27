<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head\">
			<div class=\"container\" style=\"width: 1100px; margin: 0 auto; padding: 40px 0 40px 0;\">
				<h1>{$lang['thanks']}</h1>
			</div>
		</div>	
		<div class=\"content\" style=\"text-align: center;\">
			<p style=\"font-size: 18px;\">{$lang['thanks_text']}</p>
		</div>
		<br />
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>