<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$backups = api::send('self/backup/list');

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
";

if( count($backups) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th style=\"text-align: center; width: 40px;\">#</th>
							<th>{$lang['type']}</th>
							<th>{$lang['name']}</th>
							<th>{$lang['date']}</th>
							<th>{$lang['mode']}</th>
							<th style=\"width: 130px; text-align: center;\">{$lang['actions']}</th>
						</tr>";

	foreach( $backups as $b )
	{		
		$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/{$b['type']}.png\" /></td>
							<td>".$lang['type_' . $b['type']]."</td>
							<td><span style=\"font-weight: bold;\">{$b['title']}</span></td>
							<td>".date($lang['dateformat'], $b['date'])."</td>
							<td>".($b['auto']==1?"{$lang['auto']}":"{$lang['manual']}")."</td>
							<td style=\"width: 130px; text-align: center;\">
								<a href=\"{$b['url']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/download2.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#restore{$b['id']}').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/arrowLeft.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#id').val('{$b['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}
	
	$content .= "
					</table>
	";
}
else
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['nobackup']}</span><br /><br />
					<a class=\"button classic\" href=\"/doc/backups\" style=\"width: 140px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>";
	
}

$content .= "
					<br /><br />
				</div>
			</div>
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/backups/del_action\" method=\"get\" class=\"center\">
						<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
";

foreach( $backups as $b )
{
	$content .= "
			<div id=\"restore{$b['id']}\" class=\"floatingdialog\">
				<br />
				<h3 class=\"center\">{$lang['restore']}</h3>
				<p style=\"text-align: center;\">{$lang['restore_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/backups/restore_action\" method=\"get\" class=\"center\">
						<input type=\"hidden\" value=\"{$b['id']}\" name=\"id\" />
	";
	if( $b['type'] != 'app' && $b['type'] != 'full' )
	{		
		$branches = explode('-', $b['service_name']);
		$branch = $branches[2];
		
		$service = api::send('self/service/list', array('service'=>$branches[0] . '-' . $branches[1]));
		$service = $service[0];

		$content .= "
							<fieldset>	
								<select name=\"branch\">
									<option ".($branch=='master'?"selected":"")." value=\"master\">master</option>
		";
		if( count($service['branches']) > 0  )
		{
			foreach( $service['branches'] as $b )
			{
				$content .= "
										<option ".($branch==$b['branch']?"selected":"")." value=\"{$b['branch']}\">{$b['branch']}</option>
				";
			}
		}
		$content .= "
		
								</select>
							</fieldset>
		";
	}
	$content .= "
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['restore_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
	";
}
$content .= "
			<script>
				newFlexibleDialog('delete', 550);
";
foreach( $backups as $b )
{
	$content .= "
				newFlexibleDialog('restore{$b['id']}', 550);";
}
$content .= "
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>