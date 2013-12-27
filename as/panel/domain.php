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
					<div class=\"left\" style=\"padding-top: 5px;\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br /><br />
				<div class=\"container\">
					<table>
						<tr>
							<th></th>
							<th>{$lang['domain']}</th>
							<th>{$lang['arecord']}</th>
							<th>{$lang['home']}</th>
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
		
		$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/domain/config?id={$d['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/domain.png\" /></td>
							<td><span style=\"font-weight: bold;\">{$d['hostname']}</span></td>
							<td><span class=\"lightlarge\">{$arecord}</a></td>
							<td>".($d['destination']?"{$d['destination']}":"{$d['homeDirectory']}")."</td>
							<td style=\"width: 80px; text-align: center;\">
								<a href=\"/panel/domain/config?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
								<a href=\"/panel/domain/del_action?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}
}
	
$content .= "
					</table>
				</div>
			</div>
			<div id=\"new\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new']}</h3>
				<p style=\"text-align: center;\">{$lang['new_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/domain/add_action\" method=\"post\" class=\"center\">
						<fieldset>
							<input class=\"auto\" type=\"text\" value=\"{$lang['name']}\" name=\"domain\" onfocus=\"this.value = this.value=='{$lang['name']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['name']}' : this.value; this.value=='{$lang['name']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
							<span class=\"help-block\">{$lang['tipname']}</span>
						</fieldset>
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['create']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<script>
				newFlexibleDialog('new', 550);
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
