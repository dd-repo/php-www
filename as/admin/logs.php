<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$logs = api::send('log/list', array());

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"padding-top: 5px;\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
							<span style=\"display: block; padding-top: 3px;\">{$lang['search']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
";

if( count($logs) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th>{$lang['user']}</th>
							<th>{$lang['method']}</th>
							<th>{$lang['date']}</th>
							<th>{$lang['ip']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>";

	foreach( $logs as $l )
	{
		$content .= "<div id=\"params{$l['id']}\" class=\"floatingdialog\"><br /><p style=\"text-align: center;\">(
		";
		
		$params = json_decode($l['params'], true);
		if( is_array($params) )
		{
			$max = count($params)-1;
			$i = 0;
			foreach( $params as $key => $value )
			{
				if( $key == 'pass' )
					$value = '*******';
					
				$content .= "'{$key}' => '{$value}'";
				
				if( $i != $max )
					$content .= ", ";
					
				$i++;
			}		
		}
		
		$content .= "
					)
					</p>
				</div>
		";
		
		$content .= "
						<tr>
							<td><a href=\"/admin/users/detail?id={$l['user']['id']}\"><img style=\"width: 30px; height: 30px; float: left; margin-right: 10px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$m['user']['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$l['user']['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /></a><a style=\"display: block; float: left; padding-top: 6px;\" href=\"/admin/users/detail?id={$l['user']['id']}\">{$l['user']['name']}</a></td>
							<td>{$l['method']}</td>
							<td>".date($lang['dateformat'], $l['date'])."</a></td>
							<td>{$l['ip']}</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"#\" onclick=\"$('#params{$l['id']}').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/preview.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}
	
	$content .= "
					</table>
					<br /><br />
	";
}
else
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['nolog']}</span><br /><br />
	";
}

$content .= "
				</div>
			</div>
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
			</div>
			<script>
				newFlexibleDialog('search', 700);
				newFlexibleDialog('delete', 550);
";
foreach( $logs as $l )
	$content .= " newFlexibleDialog('params{$l['id']}', 550);\n";

$content .= "
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
