<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$repo = api::send('self/repo/list', array('id'=>$_GET['id']));
$repo = $repo[0];

$content .= "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} :: {$repo['name']}</h2>
			<p class=\"large\">{$lang['intro']}</p>
			<br />
			<h2>{$lang['apps']}</h2>
			<p class=\"large\">{$lang['app_intro']}</p>
			<br />
			<table>
				<tr>
					<th>{$lang['app']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

if( $repo['apps'] )
{
	foreach( $repo['apps'] as $a )
	{
		$content .= "
				<tr>
					<td>{$a['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/repo/deny_action?id={$_GET['id']}&member={$a['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
	}
}
	
$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/repo/permit_app?id={$_GET['id']}\">{$lang['permit_app']}</a>
			<br /><br />
			<h2>{$lang['users']}</h2>
			<p class=\"large\">{$lang['user_intro']}</p>
			<br />
			<table>
				<tr>
					<th>{$lang['user']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

if( $repo['users'] )
{
	foreach( $repo['users'] as $u )
	{
		$content .= "
				<tr>
					<td>{$u['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/repo/deny_action?id={$_GET['id']}&member={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
	}
}
	
$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/repo/permit_user?id={$_GET['id']}\">{$lang['permit_user']}</a>
			<br /><br />
			<h2>{$lang['groups']}</h2>
			<p class=\"large\">{$lang['group_intro']}</p>
			<br />
			<table>
				<tr>
					<th>{$lang['group']}</th>
					<th>{$lang['actions']}</th>
				</tr>
";

if( $repo['groups'] )
{
	foreach( $repo['groups'] as $g )
	{
		$content .= "
				<tr>
					<td>{$g['name']}</td>
					<td align=\"center\">
						<a href=\"/panel/repo/deny_action?id={$_GET['id']}&member={$g['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
					</td>
				</tr>";
	}
}
	
$content .= "		
			</table>
			<br />
			<a class=\"btn\" href=\"/panel/repo/permit_group?id={$_GET['id']}\">{$lang['permit_group']}</a>
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
