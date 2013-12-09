<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;

	}
$me = api::send('self/whoami');
$me = $me[0];
$address = json_decode($me['address'], true);

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['bank']}</h3><br />
				<p class=\"large\">{$lang['intro']}</p>
				<form action=\"/panel/billing/update_action\" method=\"post\">
					<fieldset>
						<label>{$lang['iban']}</label>
						<input type=\"text\" name=\"iban\" value=\"{$me['iban']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['bic']}</label>
						<input type=\"text\" name=\"bic\" value=\"{$me['bic']}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['address']}</h3><br />
				<form action=\"/panel/billing/update_action\" method=\"post\">
					<fieldset>
						<label>{$lang['company']}</label>
						<input type=\"text\" name=\"company\" value=\"{$address['company']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['street']}</label>
						<input type=\"text\" name=\"street\" value=\"{$address['street']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['code']}</label>
						<input type=\"text\" name=\"code\" value=\"{$address['code']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['city']}</label>
						<input type=\"text\" name=\"city\" value=\"{$address['city']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['country']}</label>
						<input type=\"text\" name=\"country\" value=\"{$address['country']}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
