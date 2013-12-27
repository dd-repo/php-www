<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']}</h2>
			<br />
			<a href=\"/panel/repo/add2?type=git\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-git.png\" alt=\"git\"><span class=\"large\">GIT</span><br /><span style=\"color: #000000;\" class=\"small\">Git Repository</span></p>
					<div class=\"overline\">{$lang['access']} SSH</div>
					<br />		
				</div>
			</a>
			<a href=\"/panel/repo/add2?type=hg\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-hg.png\" alt=\"hg\"><span class=\"large\">HG</span><br /><span style=\"color: #000000;\" class=\"small\">Mercurial Repository</span></p>
					<div class=\"overline\">{$lang['access']} SSH</div>
					<br />		
				</div>
			</a>
			<a href=\"/panel/repo/add2?type=svn\">
				<div class=\"app\">
					<p><img class=\"icon\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/repos/icon-svn.png\" alt=\"git\"><span class=\"large\">SVN</span><br /><span style=\"color: #000000;\" class=\"small\">Subversion Repository</span></p>
					<div class=\"overline\">{$lang['access']} SSH</div>
					<br />
				</div>
			</a>
			<div class=\"clearfix\"></div>
		</div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>