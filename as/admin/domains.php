<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domains = api::send('domain/list');

$content = "
	<div class=\"admin\">
		<div class=\"top\">
			<div class=\"left\" style=\"padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">
			<table>
				<tr>
					<th style=\"width: 40px; text-align: center;\">#</th>
					<th>{$lang['domain']}</th>
					<th>{$lang['arecord']}</th>
					<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
				</tr>
";

foreach( $domains as $d )
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
			
	$content .= "
				<tr>
					<td style=\"width: 40px; text-align: center;\"><img style=\"width: 40px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/domain.png\" /></a></td>
					<td><a href=\"http://{$d['hostname']}\">{$d['hostname']}</a></td>
					<td>{$arecord}</td>
					<td style=\"width: 100px; text-align: center;\">
						<a href=\"/admin/users/detail?id={$d['user']['id']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/preview.png\" alt=\"{$lang['manage']}\" /></a>
						<a href=\"#\" onclick=\"$('#id').val('{$d['id']}'); $('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"{$lang['delete']}\" /></a>
					</td>
				</tr>
	";
}

$content .= "
			</table>
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/admin/domains/del_action\" method=\"get\" class=\"center\">
				<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<script>
		newFlexibleDialog('delete', 550);
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>