<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

$content = "
		<div class=\"panel\">
			<div class=\"top\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"clear\"></div><br /><br />
			<div class=\"container\">
				<table>
				<tr>
					<th></th>
					<th>{$lang['domain']}</th>
					<th>{$lang['arecord']}</th>
					<th>{$lang['users']}</th>
					<th>{$lang['groups']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

if( count($domains) > 0 )
{
	foreach($domains as $d)
	{
		$arecord = "";
		if( is_array($d['aRecord']) )
		{
			$i = 1;
			$max = count($d['aRecord']);
			foreach( $d['aRecord'] as $a )
			{
				if( $i == $max )
					$arecord .= "{$a}";
				else
					$arecord .= "{$a}, ";
					
				$i++;
			}
		}
		else
			$arecord = $d['aRecord'];
			
		$users = api::send('self/account/list', array('domain'=>$d['hostname'], 'count'=>1));
		$groups = api::send('self/team/list', array('domain'=>$d['hostname'], 'count'=>1));
		
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/user/list?domain={$d['hostname']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/domain.png\" /></td>
					<td><span style=\"font-weight: bold;\">{$d['hostname']}<span style=\"font-weight: bold;\"></td>
					<td><span class=\"lightlarge\">{$arecord}</span></td>
					<td>{$users['count']} {$lang['user']}</td>
					<td>{$groups['count']} {$lang['group']}</td>
					<td style=\"width: 50px; text-align: center;\">
		";
		
		if( security::hasGrant('SELF_ACCOUNT_INSERT') )
		{
			$content .= "
									<a href=\"/panel/user/list?domain={$d['hostname']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>";
		}
		
		$content .= "
								</td>
							</tr>
		";
	}
}
	
$content .= "
					</table>
				</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
