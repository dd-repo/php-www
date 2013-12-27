<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('self/domain/list');

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<table>
				<tr>
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
					<td><a href=\"/panel/user/list?domain={$d['hostname']}\"><strong>{$d['hostname']}</strong></a></td>
					<td><span class=\"lightlarge\">{$arecord}</span></td>
					<td>{$users['count']} {$lang['user']}</td>
					<td>{$groups['count']} {$lang['group']}</td>
					<td align=\"center\">
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
						</tbody>
					</table>
				</div>
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
