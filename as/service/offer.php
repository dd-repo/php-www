<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">
			<h3 style=\"text-align: center;\">{$lang['description']}</h3>
			<table class=\"offer\">
				<tr>
					<td colspan=\"2\">
						<h2 class=\"dark\" style=\"text-align: center; font-size: 25px; margin: 5px 0 5px 0;\">{$lang['langserv']}</h2>
					</td>
				</tr>
				<tr>
					<td style=\"width:50%\">
						<p>{$lang['languages']}</p>
					</td>
				</td>
					<td style=\"width:50%\">
						<p>{$lang['services']}</p>
					</td>
				</tr>
			</table>
			<br />
			<table class=\"offer\">
				<tr>
					<td colspan=\"2\">
						<h2 class=\"dark\" style=\"text-align: center; font-size: 25px; margin: 5px 0 5px 0;\">{$lang['illimited']}</h2>
					</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_1_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_1_desc']}</p>
					</td>
					<td>
						<h3>{$lang['offer_2_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_2_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_3_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_3_desc']}</p>
					</td>
					<td>
						<h3>{$lang['offer_4_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_4_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['offer_5_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['offer_5_desc']}</p>
					</td>
					<td>
						<h3>{$lang['offer_6_title']}</h2>
						<p style=\"margin-bottom: 0;\">{$lang['offer_6_desc']}</p>
					</td>
				</tr>
			</table>
			<br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/join\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['signup_now']}</span>
				</a>
				<p>{$lang['help']}</p>
			</div>
			<br />
			<h3 style=\"text-align: center;\">{$lang['addons']}</h3>
			<table class=\"offer\">
				<tr>
					<th>{$lang['service']}</th>
					<th>{$lang['offer_1']}</th>
					<th>{$lang['offer_2']}</th>
					<th>{$lang['offer_3']}</th>
				</tr>
				<tr>
					<td>{$lang['domains']}</td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
				</tr>
				<tr>
					<td>{$lang['mailbox']}</td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
				</tr>
				<tr>
					<td>{$lang['agenda']}</td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
				</tr>
				<tr>
					<td>{$lang['ssl_standard']}</td>
					<td>19 &euro; / {$lang['month']}</td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
				</tr>
				<tr>
					<td>{$lang['ssl_wildcard']}</td>
					<td>79 &euro; / {$lang['month']}</td>
					<td>79 &euro; / {$lang['month']}</td>
					<td><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/notifications/yes.png\" alt=\"\" /></td>
				</tr>
				<tr>
					<td>{$lang['disk']}</td>
					<td>1Go</td>
					<td>10Go</td>
					<td>50Go</td>
				</tr>
				<tr>
					<td>{$lang['trafic']}</td>
					<td>{$lang['unlimited']}</td>
					<td>{$lang['unlimited']}</td>
					<td>{$lang['unlimited']}</td>
				</tr>
				<tr>
					<td>{$lang['repositories']}</td>
					<td>{$lang['all']}</td>
					<td>{$lang['all']}</td>
					<td>{$lang['all']}</td>
				</tr>
				<tr>
					<td>{$lang['ssh']}</td>
					<td>{$lang['scp']}</td>
					<td>{$lang['scp']}</td>
					<td>{$lang['scp']}</td>
				</tr>
				<tr>
					<td>{$lang['antiddos']}</td>
					<td>99 &euro; / {$lang['month']}</td>
					<td>99 &euro; / {$lang['month']}</td>
					<td>99 &euro; / {$lang['month']}</td>
				</tr>
				<tr>
					<td>{$lang['uptime']}</td>
					<td>99%</td>
					<td>99,5%</td>
					<td>99,9%</td>
				</tr>
				<tr>
					<td>{$lang['gti']}</td>
					<td>48 {$lang['hours']}</td>
					<td>24 {$lang['hours']}</td>
					<td>4 {$lang['hours']}</td>
				</tr>
			</table>
			<br /><br />
			<h3 style=\"text-align: center;\">{$lang['more_disk']}</h3>
			<table class=\"offer\">
				<tr>
					<td>
						<h3>{$lang['dd_1_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['dd_1_desc']}</p>
					</td>
					<td>
						<h3>{$lang['dd_2_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['dd_2_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['dd_3_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['dd_3_desc']}</p>
					</td>
					<td>
						<h3>{$lang['dd_4_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['dd_4_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h3>{$lang['dd_5_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['dd_5_desc']}</p>
					</td>
					<td>
						<h3>{$lang['dd_6_title']}</h3>
						<p style=\"margin-bottom: 0;\">{$lang['dd_6_desc']}</p>
					</td>
				</tr>
			</table>
			<br />
			<div style=\"text-align: center;\">
				<a class=\"button classic\" href=\"/service/infrastructure\" style=\"height: 22px; width: 300px; margin: 0 auto;\">
					<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['infra']}</span>
				</a>
			</div>
			<br /><br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>