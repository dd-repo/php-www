<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"header\">
			<div class=\"container\">
				<div class=\"head\">{$lang['title']}</div>
			</div>
		</div>
		<div class=\"container\">
			<h2>{$lang['description']}</h2>
			<br />
			<table class=\"offer\">
				<tr>
					<td colspan=\"2\">
						<h2>{$lang['illimited']}</h2>
					</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_1_title']}</h2>
						<p>{$lang['offer_1_desc']}</p>
					</td>
					<td>
						<h2>{$lang['offer_2_title']}</h2>
						<p>{$lang['offer_2_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_3_title']}</h2>
						<p>{$lang['offer_3_desc']}</p>
					</td>
					<td>
						<h2>{$lang['offer_4_title']}</h2>
						<p>{$lang['offer_4_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['offer_5_title']}</h2>
						<p>{$lang['offer_5_desc']}</p>
					</td>
					<td>
						<h2>{$lang['offer_6_title']}</h2>
						<p>{$lang['offer_6_desc']}</p>
					</td>
				</tr>
			</table>
			<br />
			<p class=\"large\">{$lang['explain']}</p>
			<br />
			<h2>{$lang['addons']}</h2>
			<br />
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
			<h2>{$lang['more_disk']}</h2>
			<br />
			<table class=\"offer\">
				<tr>
					<td>
						<h2>{$lang['dd_1_title']}</h2>
						<p>{$lang['dd_1_desc']}</p>
					</td>
					<td>
						<h2>{$lang['dd_2_title']}</h2>
						<p>{$lang['dd_2_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['dd_3_title']}</h2>
						<p>{$lang['dd_3_desc']}</p>
					</td>
					<td>
						<h2>{$lang['dd_4_title']}</h2>
						<p>{$lang['dd_4_desc']}</p>
					</td>
				</tr>
				<tr>
					<td>
						<h2>{$lang['dd_5_title']}</h2>
						<p>{$lang['dd_5_desc']}</p>
					</td>
					<td>
						<h2>{$lang['dd_6_title']}</h2>
						<p>{$lang['dd_6_desc']}</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>