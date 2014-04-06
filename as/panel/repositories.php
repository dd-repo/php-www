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
	
$repos = api::send('self/repo/list');

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px; padding-top: 5px;\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
			<div class=\"right\">
				<a class=\"button classic\" href=\"/panel/repositories/add\" style=\"width: 200px; height: 22px; float: right;\">
					<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
				</a>
			</div>
		</div>
		<div class=\"clear\"></div><br />
		<div class=\"container\">";

if( count($repos) == 0 )
{
	$content .= "
					<span style=\"font-size: 16px;\">{$lang['norepo']}</span><br /><br />
					<a class=\"button classic\" href=\"/doc/repositories\" style=\"width: 140px;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['doc']}</span>
					</a>";";
	";
}

$j = 1;
foreach( $repos as $r )
{
	$content .= "
			<div class=\"service ".($j==1?"first":"")."\" onclick=\"window.location.href='/panel/repositories/config?id={$r['id']}'; return false;\">
				<img style=\"float: left; margin: 10px 15px 0 0;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-{$r['type']}.png\" />
				<span class=\"name\" style=\"margin: 5px 0 0px 0; display: block;\">{$r['description']}</span><br />
				<span class=\"subname\">{$r['name']}</span>
			</div>
	";
	
	$j++;
	
	if( $j == 4 )
		$j = 1;
}

	$content .= "
		</div>		
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
