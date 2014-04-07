<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$quotas =  api::send('self/quota/user/list');

foreach( $quotas as $q )
{
	if( $q['name'] == 'MEMORY' )
		$quota = $q;
}

if( $quota['max'] == 0 )
	template::redirect('/panel/plans');
	
$domains = api::send('self/domain/list');

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 180px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div class=\"container\">
";

if( count($domains) > 0 )
{
	$content .= "
					<table>
						<tr>
							<th style=\"text-align: center; width: 40px;\">#</th>
							<th>{$lang['domain']}</th>
							<th>{$lang['arecord']}</th>
							<th>{$lang['home']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>
	";
	
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
							<td style=\"text-align: center; width: 40px;\"><a href=\"/panel/domains/config?id={$d['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/domain.png\" /></td>
							<td><span style=\"font-weight: bold;\">{$d['hostname']}</span></td>
							<td><span class=\"lightlarge\">{$arecord}</a></td>
							<td>".($d['destination']?"{$d['destination']}":"{$d['homeDirectory']}")."</td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"/panel/domains/config?id={$d['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/settings.png\" alt=\"\" /></a>
								<a href=\"#\" onclick=\"$('#id').val('{$d['id']}'); $('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
							</td>
						</tr>
		";
	}
	
	$content .= "
					</table><br /><br />
					<a class=\"button classic\" href=\"/doc/domains\" style=\"width: 140px; float: left;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>
					<a class=\"button classic\" href=\"/panel\" style=\"width: 140px; float: left; margin-left: 20px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['app']}</span>
					</a>
	";
}
else
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['nodomain']}</span><br /><br />
					<a class=\"button classic\" href=\"/doc/domains\" style=\"width: 140px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>
";
	
}
	
$content .= "

				</div>
			</div>
			<div id=\"new\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new']}</h3>
				<p style=\"text-align: center;\">{$lang['new_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/domains/add_action\" method=\"post\" class=\"center\">
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
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/domains/del_action\" method=\"get\" class=\"center\">
						<input id=\"id\" type=\"hidden\" value=\"\" name=\"id\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<script>
				newFlexibleDialog('new', 550);
				newFlexibleDialog('delete', 550);
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
