<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_POST['email'] )
	$_SESSION['JOIN_EMAIL'] = security::encode($_POST['email']);

$content = "
		<div class=\"head\">
			<div class=\"container\" style=\"width: 1100px; margin: 0 auto; padding: 40px 0 40px 0;\">
				<h1>{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<table style=\"border: 0;\">
";

/*
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h3>{$lang['offer_99_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_99_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">{$lang['free']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('99'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
*/

$content .= "
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h3>{$lang['offer_1_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_1_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">29&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('1'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h3>{$lang['offer_2_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_2_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">99&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('2'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h3>{$lang['offer_3_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_3_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">180&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('3'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
				<tr>
					<td style=\"border: 0;\">
						<h3>{$lang['offer_4_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_4_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">320&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('4'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h3>{$lang['offer_5_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_5_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">560&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('5'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
				<tr style=\"border: 0;\">
					<td style=\"border: 0;\">
						<h3>{$lang['offer_6_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_6_desc']}</p>
					</td>
					<td style=\"border: 0;\"><span class=\"large\"><span class=\"colored\">999&euro; HT</span> / {$lang['month']}</span></td>
					<td style=\"border: 0;\"><a class=\"button classic\" href=\"#\" onclick=\"$('#plan').val('6'); $('#new').dialog('open'); return false;\">{$lang['select']}</a></td>
				</tr>
			</table>
		</div>
		<div class=\"clear\"></div><br /><br />
		
		<div id=\"new\" style=\"display: none;\" class=\"floatingdialog\">
			<h3 class=\"center\">{$lang['new']}</h3>
			<p style=\"text-align: center;\">{$lang['new_text']}</p>
			<div class=\"form-small\">		
				<form action=\"/join/pay\" method=\"post\" class=\"center\">
					<input id=\"plan\" type=\"hidden\" name=\"plan\" value=\"{$_SESSION['JOIN_PLAN']}\" />
					<fieldset>
						<input class=\"auto\" type=\"text\" value=\"".($_SESSION['JOIN_USER']?"{$_SESSION['JOIN_USER']}":"{$lang['name']}")."\" name=\"username\" onfocus=\"this.value = this.value=='{$lang['name']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['name']}' : this.value; this.value=='{$lang['name']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
						".(isset($_GET['eregisteradd'])?"<span class=\"help-block\" style=\"color: #bc0000;\">{$lang['error_user']}</span>":"<span class=\"help-block\">{$lang['tipname']}</span>")."
					</fieldset>
					<fieldset>
						<input id=\"email\" type=\"text\" value=\"{$_SESSION['JOIN_EMAIL']}\" name=\"email\" />
						<span class=\"help-block\">{$lang['tipemail']}</span>
					</fieldset>
					<fieldset autofocus>	
						<input type=\"submit\" value=\"{$lang['create']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<script>
			newDialog('new', 550, 350);
";

if( isset($_GET['eregisteradd']) )
{
	$content .= "$(document).ready(function() {
								$(\"#new\").dialog(\"open\");
								$(\".ui-dialog-titlebar\").hide();
							});";
}

$content .= "
		</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>