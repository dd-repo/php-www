<?php

if( isset($GLOBALS['lang']) && is_object($GLOBALS['lang']) )
	$GLOBALS['lang']->import(__DIR__ . '/menu.lang');

$menu = "		
						<ul>
							<a href=\"/doc\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc', '/'))===0?"active":"")."\">{$lang['index']}</li></a>
							<li style=\"cursor: auto;\">{$lang['started']}</li>
							<ul>
								<a href=\"/doc/what\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/what', '/'))===0?"active":"")."\">{$lang['what']}</li></a>
								<a href=\"/doc/techno\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/techno', '/'))===0?"active":"")."\">{$lang['techno']}</li></a>
								<a href=\"/doc/info\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/info', '/'))===0?"active":"")."\">{$lang['infos']}</li></a>
								<a href=\"/doc/first\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/first', '/'))===0?"active":"")."\">{$lang['first']}</li></a>
							</ul>
							<li style=\"cursor: auto;\">{$lang['features']}</li>
							<ul>
								<a href=\"/doc/apps\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/apps', '/'))===0?"active":"")."\">{$lang['apps']}</li></a>
								<a href=\"/doc/domains\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/domains', '/'))===0?"active":"")."\">{$lang['domains']}</li></a>
								<a href=\"/doc/services\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/services', '/'))===0?"active":"")."\">{$lang['services']}</li></a>
								<a href=\"/doc/users\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/users', '/'))===0?"active":"")."\">{$lang['users']}</li></a>
							</ul>
							<li style=\"cursor: auto;\">{$lang['advanced']}</li>
							<ul>
								<a href=\"/doc/env\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/env', '/'))===0?"active":"")."\">{$lang['env']}</li></a>
								<a href=\"/doc/process\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/process', '/'))===0?"active":"")."\">{$lang['process']}</li></a>
								<a href=\"/doc/repositories\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/repositories', '/'))===0?"active":"")."\">{$lang['repositories']}</li></a>
								<a href=\"/doc/cloud\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/cloud', '/'))===0?"active":"")."\">{$lang['cloud']}</li></a>
							</ul>							
							<li style=\"cursor: auto;\">{$lang['account']}</li>
							<ul>
								<a href=\"/doc/tools\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/tools', '/'))===0?"active":"")."\">{$lang['tools']}</li></a>
								<a href=\"/doc/backups\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/backups', '/'))===0?"active":"")."\">{$lang['backups']}</li></a>
								<a href=\"/doc/quotas\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/quotas', '/'))===0?"active":"")."\">{$lang['quotas']}</li></a>
								<a href=\"/doc/tokens\"><li class=\"".(strpos(rtrim($GLOBALS['CONFIG']['PAGE'], '/'), rtrim('/doc/tokens', '/'))===0?"active":"")."\">{$lang['tokens']}</li></a>
							</ul>	
						</ul>
";