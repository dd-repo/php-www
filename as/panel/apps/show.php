<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$backups = array();

if( !$_GET['branch'] && !$_SESSION['DATA'][$app['id']]['branch'] )
	$_SESSION['DATA'][$app['id']]['branch'] = 'master';
else if( $_GET['branch'] )
	$_SESSION['DATA'][$app['id']]['branch'] = $_GET['branch'];

$memory = 0;
$instances = 0;
$memoryone = 0;
if( count($app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances']) > 0 )
{
	foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
	{
		$memoryone = $i['memory']['quota'];
		$memory = $memory+$i['memory']['quota'];
		$instances++;
	}
}

$expl = explode('-', $app['name']);
$language = $expl[0];

$now = time();
// Last 24 hours
$data_day = array();
$dayago = mktime(date('H')+1, 0, 0, date('n'), date('j'), date('Y'))-(3600*24);
$times = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'time', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'group' => 'HOUR', 'from' => $dayago, 'to' => $now, 'start' => 0, 'limit' => 1000));
$current = $dayago;
for( $i = 1; $i <= 24; $i++ )
{
	$next = $current+3600;
	$data_day[$current]['time'] = 0;
	$data_day[$current]['date'] = date($lang['dateformathour'], $current);
	foreach( $times as $t )
	{
		if( $t['HOUR'] == date('H', $current) )
			$data_day[$current]['time'] = round($t['average']);
	}
	$current = $next;
}

// Last month
$data_month = array();
/*
$monthago = mktime(date('H'), 0, 0, date('n'), date('j')+1, date('Y'))-(3600*24*30);
$times = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'time', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'group' => 'DAY', 'from' => $monthago, 'to' => $now, 'start' => 0, 'limit' => 1000));
$current = $monthago;
for( $i = 1; $i <= 30; $i++ )
{
	$next = $current+(3600*24);
	$data_month[$current]['time'] = 0;
	$data_month[$current]['date'] = date($lang['dateformat'], $current);
	foreach( $times as $t )
	{
		if( $t['DAY'] == date('d', $current) )
			$data_month[$current]['time'] = round($t['average']);
	}
	$current = $next;
}
*/

// Last year
$data_year = array();
/*
$yearago = mktime(date('H'), 0, 0, date('n')+1, date('j'), date('Y'))-(3600*24*365);
$times = api::send('self/app/graph', array('app'=>$app['name'], 'graph'=>'time', 'branch'=>$_SESSION['DATA'][$app['id']]['branch'], 'group' => 'MONTH', 'from' => $yearago, 'to' => $now, 'start' => 0, 'limit' => 1000));
$current = $yearago;
for( $i = 1; $i <= 12; $i++ )
{
	$next = $current+(3600*24*30.3);
	$data_year[$current]['time'] = 0;
	$data_year[$current]['date'] = date($lang['dateformatmonth'], $current);
	foreach( $times as $t )
	{
		if( $t['MONTH'] == date('n', $current) )
			$data_year[$current]['time'] = round($t['average']);
	}
	$current = $next;
}
*/

$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 400px;\">
				<img style=\"display: block; float: left; margin-right: 20px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" alt=\"\" />
				<div style=\"float: left;\">
					<span style=\"font-size: 25px; display: block; margin-bottom: 4px;\">{$app['tag']}</span>
					<span style=\"font-size: 15px; color: #878787; display: block; margin-bottom: 10px;\">{$app['name']}</span>
				</div>
			</div>
			<div class=\"right\" style=\"width: 700px; float: right; text-align: right;\">
				<a class=\"action settings\" href=\"#\" onclick=\"$('#settings').dialog('open'); return false;\">
					{$lang['settings']}
				</a>
				<a class=\"action pass\" href=\"#\" onclick=\"$('#changepass').dialog('open'); return false;\">
					{$lang['changepass']}
				</a>
				<a class=\"action push\" href=\"#\" onclick=\"$('#push').dialog('open'); return false;\">
					{$lang['push']}
				</a>
				<a class=\"action log\" href=\"/panel/apps/log?id={$app['id']}\">
					{$lang['logs']}
				</a>
				<a class=\"action delete\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\">
					{$lang['delete']}
				</a>
			</div>
			<div class=\"clear\"></div><br />
		</div>
		<div class=\"container\">
			<div style=\"float: left; width: 800px;\">
";

foreach( $app['branches'] as $key => $value )
	$content .= "<a href=\"/panel/apps/show?id={$app['id']}&branch={$key}\" class=\"branch ".($key==$_SESSION['DATA'][$app['id']]['branch']?"active":"")."\">{$key}</a>";

$content .= "
					<a href=\"#\" class=\"branch\" onclick=\"$('#newbranch').dialog('open'); return false;\">+</a>
			</div>
			<div style=\"float: right; width: 300px;\">";
			
if( $_SESSION['DATA'][$app['id']]['branch'] != 'master' )
{
	$content .= "
				<a class=\"button classic\" href=\"#\" onclick=\"$('#deletebranch').dialog('open'); return false;\" style=\"width: 180px; height: 22px; float: right;\">
					<span style=\"display: block; padding-top: 3px;\">{$lang['deletebranch']}</span>
				</a>
	";
}
$content .= "
			</div>
			<div class=\"clear\"></div>
			<br />
			<div id=\"response1\"></div>
			<br /><br />
			<div style=\"float: left; width: 500px;\">
				<div style=\"float: left; width: 400px; padding-top: 8px;\">
					<h2 class=\"dark\">{$lang['services']}</h2>
				</div>
				<div style=\"float: right; width: 100px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"geturls(); $('#newservice').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div><br />
				<table>
					<tr>
						<th style=\"text-align: center; width: 50px;\">#</th>
						<th>{$lang['service']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
";

if( count($app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['services']) > 0 )
{
	foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['services'] as $s )
	{
		$content .= "
					<tr>
						<td style=\"text-align: center; width: 50px;\"><img style=\"width: 40px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/icon-{$s['service_type']}.png\" /></td>
						<td>{$s['service_description']} ({$s['branch_name']})</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"#\" onclick=\"$('#service').val('{$s['service_name']}'); $('#updateservice').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
							<a href=\"#\" onclick=\"$('#service').val('{$s['service_name']}'); $('#deleteservice').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
		";
	}
}

$content .= "
				</table>
			</div>
			<div style=\"float: right; width: 500px;\">

				<div style=\"float: left; width: 400px; padding-top: 8px;\">
					<h2 class=\"dark\">{$lang['uris']}</h2>
				</div>
				<div style=\"float: right; width: 100px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"geturls(); $('#newurl').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div><br />
				<table>
					<tr>
						<th>{$lang['url']}</th>
						<th>{$lang['actions']}</th>
					</tr>
		";
				
if( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['urls'] )
{
	foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['urls'] as $u )
	{		
		$content .= "
					<tr>
						<td><a href=\"http://{$u}\">{$u}</a></td>
						<td style=\"width: 30px; text-align: center;\">
							<a href=\"/panel/apps/del_url_action?id={$app['id']}&url={$u}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
		";
	}
}
		
$content .= "
				</table>
			</div>
			<div class=\"clear\"></div><br />
			<br />
			<div style=\"float: left; width: 500px;\">
				<div style=\"float: left; width: 200px; padding-top: 8px;\">
					<h2 class=\"dark\">{$lang['infos']}</h2>
				</div>
				<div style=\"float: right; width: 300px;\">
					
				</div>
				<div class=\"clear\"></div><br />
				<table>
					<tr>
						<th>{$lang['info']}</th>
						<th>{$lang['data']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
					<tr>
						<td>{$lang['memory']}</td>
						<td><span class=\"large\" id=\"memorycount\">{$memory}</span> {$lang['mb']}</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"#\" onclick=\"decreaseMemory(); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/less.png\" alt=\"\" /></a>
							<a href=\"#\" onclick=\"increaseMemory(); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/add.png\" alt=\"\" /></a>
						</td>
					</tr>
					<tr>
						<td>{$lang['number']}</td>
						<td><span class=\"large\" id=\"instancescount\">{$instances}</span> {$lang['instances']}</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"#\" onclick=\"decreaseInstances(); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/less.png\" alt=\"\" /></a>
							<a href=\"#\" onclick=\"increaseInstances(); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/add.png\" alt=\"\" /></a>
						</td>
					</tr>
					<tr>
						<td>{$lang['disk_persistant']}</td>
						<td><span class=\"large\">{$app['size']}Mo</span></td>
						<td align=\"center\">
						</td>
					</tr>
				</table>
			</div>
			<div style=\"float: right; width: 500px;\">
				<div style=\"float: left; width: 400px; padding-top: 8px;\">
					<h2 class=\"dark\">{$lang['backups']}</h2>
				</div>
				<div style=\"float: right; width: 100px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"geturls(); $('#backup').dialog('open'); return false;\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div><br />
				<table>
					<tr>
						<th>{$lang['date']}</th>
						<th>{$lang['type']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
";

foreach( $backups as $b )
{
	$content .= "
					<tr>
						<td><a href=\"http://{$u}\">{$u}</a></td>
						<td>Auto</td>
						<td  style=\"width: 70px; text-align: center;\">
							<a href=\"\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/download.png\" alt=\"\" /></a>
							<a href=\"\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>
	";
}
		
$content .= "
				</table>
			</div>
			<div class=\"clear\"></div><br />
			<br />
			<div style=\"float: left; width: 500px; padding-top: 8px;\">
				<h2 class=\"dark\">{$lang['branchinstances']}</h2>
			</div>
			<div style=\"float: right; width: 500px;\">
				<a class=\"button classic\" href=\"#\" onclick=\"rebuild(); return false;\" style=\"width: 80px; height: 20px; float: right;\">
					{$lang['rebuild']}
				</a>
				<a class=\"button classic orange\" href=\"#\" onclick=\"restart(); return false;\" style=\"margin-right: 10px; width: 80px; height: 20px; float: right;\">
					{$lang['restart']}
				</a>
				<a class=\"button classic red\" href=\"#\" onclick=\"stop(); return false;\" style=\"margin-right: 10px; width: 80px; height: 20px; float: right;\">
					{$lang['stop']}
				</a>
				<a class=\"button classic green\" href=\"#\" onclick=\"start(); return false;\" style=\"margin-right: 10px; width: 80px; height: 20px; float: right;\">
					{$lang['start']}
				</a>
			</div>
			<div class=\"clear\"></div><br />
			<div id=\"instances\" style=\"text-align: center; padding: 10px;\"></div>
			<div class=\"clear\"></div><br />
			<br />
			<h2 class=\"dark\">{$lang['graphinstances']}</h2>
			<div id=\"graphs\" style=\"text-align: center; padding: 10px;\"></div>
		</div>
	</div>
	<br />
	<div id=\"newurl\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['newurl_title']}</h3>
		<p style=\"text-align: center;\">{$lang['newurl_text']}</p>
		<div class=\"form-small\" id=\"urls\" style=\"text-align: center;\">
		
		</div>
	</div>
	<div id=\"newbranch\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['newbranch_title']}</h3>
		<p style=\"text-align: center;\">{$lang['newbranch_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/add_env_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<fieldset>
					<select name=\"branch\">
						<option value=\"production\">production</option>
						<option value=\"develop\">develop</option>
						<option value=\"recipe\">recipe</option>
						<option value=\"staging\">staging</option>
						<option value=\"testing\">testing</option>
					</select>
					<span class=\"help-block\">{$lang['help_branch']}</span>
				</fieldset>
				<fieldset>
					<input autofocus type=\"submit\" value=\"{$lang['add_branch']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"settings\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['settings_title']}</h3>
		<p style=\"text-align: center;\">{$lang['settings_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/update_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<fieldset>
					<input style=\"width: 400px;\" type=\"text\" name=\"tag\" value=\"{$app['tag']}\" />
					<span class=\"help-block\">{$lang['tag_help']}</span>
				</fieldset>
				<fieldset>
					<select style=\"width: 420px;\" name=\"cache\" style=\"text-align: center;\">
						<option ".($app['cache']!=1?"selected":"")." value=\"0\" style=\"text-align: center;\">{$lang['inactive']}</option>
						<option ".($app['cache']==1?"selected":"")." value=\"1\" style=\"text-align: center;\">{$lang['active']}</option>
					</select>
					<span class=\"help-block\">{$lang['cache_help']}</span>
				</fieldset>
				<fieldset>
					<input disabled style=\"width: 400px;\" type=\"text\" name=\"tag\" value=\"".($app['binary']?"{$lang['command']} {$app['binary']}":str_replace('{BRANCH}', security::encode($_SESSION['DATA'][$app['id']]['branch']), $lang['binary_' . $language]))."\" />
					<span class=\"help-block\">{$lang['binary_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"changepass\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['changepassword_title']}</h3>
		<p style=\"text-align: center;\">{$lang['changepassword_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/update_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<fieldset>
					<input type=\"password\" name=\"newpassword\" />
					<span class=\"help-block\">{$lang['pass_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"confirm\" />
					<span class=\"help-block\">{$lang['confirm_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"updateservice\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['updateservice_title']}</h3>
		<p style=\"text-align: center;\">{$lang['updateservice_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/update_service_action\" method=\"post\" class=\"center\">
				<input id=\"service\" type=\"hidden\" name=\"service\" value=\"\" />
				<fieldset>
					<input type=\"password\" name=\"newpassword\" />
					<span class=\"help-block\">{$lang['pass_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"confirm\" />
					<span class=\"help-block\">{$lang['confirm_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"push\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['push_title']}</h3>
		<p style=\"text-align: center;\">{$lang['push_text']}</p>
		<br />
		<table>
			<tr>
				<th>{$lang['type']}</th>
				<th>{$lang['infos']}</th>
				<th>{$lang['user']}</th>
				<th>{$lang['port']}</th>
			</tr>
			<tr>
				<td><span class=\"large\">GIT</span></td>
				<td>ssh://git.as/~".security::get('USER')."/{$app['name']}.git</td>
				<td>{$app['name']}</td>
				<td>22</td>
			</tr>
			<tr>
				<td><span class=\"large\">SFTP</span></td>
				<td>sftp://ftp.anotherservice.com</td>
				<td>{$app['name']}</td>
				<td>22</td>
			</tr>				
			<tr>
				<td><span class=\"large\">FTP</span></td>
				<td>ftp://ftp.anotherservice.com</td>
				<td>{$app['name']}</td>
				<td>21</td>
			</tr>
		</table>
		<br />
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['delete_title']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<a style=\"width: 150px; margin: 0 auto;\" href=\"/panel/apps/del_action?id={$app['id']}\" class=\"button classic\">{$lang['delete_now']}</a>
		<br />
	</div>
	<div id=\"deletebranch\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['deletebranch_title']}</h3>
		<p style=\"text-align: center;\">{$lang['deletebranch_text']}</p>
		<a style=\"width: 150px; margin: 0 auto;\" href=\"/panel/apps/del_env_action?id={$app['id']}&branch={$_SESSION['DATA'][$app['id']]['branch']}\" class=\"button classic\">{$lang['delete_now']}</a>
		<br />
	</div>
	<div id=\"alert\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['alert']}</h3>
		<p style=\"text-align: center;\" id=\"alertcontent\"></p>
		<a style=\"width: 150px; margin: 0 auto;\" href=\"#\" onclick=\"$('#alert').dialog('close'); return false;\" class=\"button classic\">{$lang['close']}</a>
		<br />
	</div>
	<div id=\"newservice\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['newservice']}</h3>
		
";

$services = api::send('self/service/list');

if( count($services) > 0 )
{
	$content .= "
		<p style=\"text-align: center;\">{$lang['newservice_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/link_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<input type=\"hidden\" name=\"branch\" value=\"{$_SESSION['DATA'][$app['id']]['branch']}\" />
				<fieldset>
					<select name=\"service\" style=\"width: 320px;\">
	";
	foreach( $services as $s )
	{
		$content .= "			<option value=\"{$s['name']}\">{$s['description']} ({$s['name']})</option>
		";
	}

	$content .= "
					</select>
					<span class=\"help-block\">{$lang['service_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"password\"  style=\"width: 300px;\"/>
					<span class=\"help-block\">{$lang['pass_help2']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['link']}\" />
				</fieldset>
			</form>
	";
}
else
{
	$content .= "<p style=\"text-align: center;\">{$lang['noservice']}</p>
	";
}

$content .= "
		</div>
	</div>
	<div id=\"deleteservice\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['deleteservice']}</h3>
		<p style=\"text-align: center;\">{$lang['deleteservice_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/apps/unlink_action\" method=\"get\" class=\"center\">
				<input id=\"service\" type=\"hidden\" value=\"\" name=\"service\" />
				<input type=\"hidden\" name=\"branch\" value=\"{$_SESSION['DATA'][$app['id']]['branch']}\" />
				<input type=\"hidden\" name=\"id\" value=\"{$app['id']}\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"sequence\" class=\"floatingdialog\"></div>
	<div id=\"recipe\" style=\"display: none;\"></div>
	<script>
		memory = {$memoryone};
		instances = {$instances};
		
		$(\"#instances\").html(\"<img src='/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif' />\");
		$('#instances').load('/panel/apps/ajax_instances?id={$app['id']}', function()
		{
			setTimeout(function() { getinstances(); }, 2000);
		});

		$(\"#graphs\").html(\"<img src='/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif' />\");
		$('#graphs').load('/panel/apps/ajax_graphs?id={$app['id']}', function()
		{
		});

		newFlexibleDialog('newurl', 550);
		newFlexibleDialog('newbranch', 550);
		newFlexibleDialog('settings', 550);
		newFlexibleDialog('changepass', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('deletebranch', 550);
		newFlexibleDialog('push', 700);
		newFlexibleDialog('alert', 550);
		newFlexibleDialog('newservice', 550);
		newFlexibleDialog('deleteservice', 550);
		newFlexibleDialog('updateservice', 550);
		newDialog('sequence', 300, 320);
		
		function initSequence(id, message)
		{
			if( id == 1 )
			{
				$('#sequence').html('');
				$('#sequence').dialog('open');
			}
			$('#sequence').append(\"<br /><div style='margin: 0;  padding: 0; clear: left;'><img id='wait\" + id + \"' src='/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif' style='float: left; margin-right: 15px; display: block;' /><span style='font-size: 12px;'>\" + message + \"</span></div>\");
		}
		
		function successSeq(id)
		{
			 $('#wait' + id).attr(\"src\", \"/{$GLOBALS['CONFIG']['SITE']}/images/icons/status_2.png\");
		}

		function failSeq(id)
		{
			 $('#wait' + id).attr(\"src\", \"/{$GLOBALS['CONFIG']['SITE']}/images/icons/status_4.png\");
		}
		
		function resetSeq()
		{
			$('#sequence').html('');
		}
		
		function getinstances()
		{
			$('#instances').load('/panel/apps/ajax_instances?id={$app['id']}', function()
			{
				setTimeout(function() { getinstances(); }, 2000);
			});
		}
		
		function geturls()
		{
			$(\"#urls\").html(\"<img src='/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif' />\");
			$('#urls').load('/panel/apps/ajax_urls?id={$app['id']}', function()	{});
		}

		function increaseInstances()
		{
			if( instances == 0 )
				memory = 128;
				
			instances = instances+1;
			$('#instancescount').html(instances);
			$('#memorycount').html(memory*instances);
			
			initSequence(1, \"{$lang['init']}\");
			successSeq(1);
			initSequence(2, \"{$lang['seq_increase_instance']}\");
			$('#recipe').load('/panel/apps/instance_increase_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&instances=' + instances, function()
			{
				successSeq(2);
				initSequence(3, \"{$lang['seq_end']}\");
				successSeq(3);
				setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
			});
		}
		
		function decreaseInstances()
		{
			if( instances > 0 )
			{
				instances = instances-1;
				$('#instancescount').html(instances);
				$('#memorycount').html(memory*instances);
				
				initSequence(1, \"{$lang['init']}\");
				successSeq(1);
				initSequence(2, \"{$lang['seq_decrease_instance']}\");
				$('#recipe').load('/panel/apps/instance_decrease_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&instances=' + instances, function()
				{
					successSeq(2);
					initSequence(3, \"{$lang['seq_end']}\");
					successSeq(3);
					setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
				});
			}
			else
			{
				$('#alertcontent').html(\"{$lang['stupid']}\");
				$('#alert').dialog('open');
			}
		}
		
		function decreaseMemory()
		{
			if( memory > 128 )
			{
				memory = memory/2;
				$('#memorycount').html(memory*instances);
				
				initSequence(1, \"{$lang['init']}\");
				successSeq(1);
				initSequence(2, \"{$lang['seq_decrease_memory']}\");
				$('#recipe').load('/panel/apps/memory_decrease_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&memory=' + memory, function()
				{
					successSeq(2);
					initSequence(3, \"{$lang['seq_end']}\");
					successSeq(3);
					setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
				});
			}
			else
			{
				$('#alertcontent').html(\"{$lang['not_less']}\");
				$('#alert').dialog('open');
			}
		}
		
		function increaseMemory()
		{
			if( memory < 1024 )
			{
				initSequence(1, \"{$lang['init']}\");
				successSeq(1);
				initSequence(2, \"{$lang['seq_increase_memory']}\");
				initSequence(3, \"{$lang['seq_restart']}\");
				memory = memory*2;
				$('#memorycount').html(memory*instances);
				
				$('#recipe').load('/panel/apps/memory_increase_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&memory=' + memory, function()
				{
					successSeq(2);
					successSeq(3);
					initSequence(4, \"{$lang['seq_end']}\");
					successSeq(4);
					setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
				});
			}
			else
			{
				$('#alertcontent').html(\"{$lang['not_more']}\");
				$('#alert').dialog('open');
			}
		}
		
		function start()
		{
			initSequence(1, \"{$lang['init']}\");
			successSeq(1);
			initSequence(2, \"{$lang['seq_start']}\");
			$('#recipe').load('/panel/apps/start_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				successSeq(2);
				initSequence(3, \"{$lang['seq_end']}\");
				successSeq(3);
				setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
			});	
		}
		
		function stop()
		{
			initSequence(1, \"{$lang['init']}\");
			successSeq(1);
			initSequence(2, \"{$lang['seq_stop']}\");
			$('#recipe').load('/panel/apps/stop_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				successSeq(2);
				initSequence(3, \"{$lang['seq_end']}\");
				successSeq(3);
				setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
			});	
		}

		function restart()
		{
			initSequence(1, \"{$lang['init']}\");
			successSeq(1);
			initSequence(2, \"{$lang['seq_restart']}\");
			$('#recipe').load('/panel/apps/restart_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				successSeq(2);
				initSequence(3, \"{$lang['seq_end']}\");
				successSeq(3);
				setTimeout(function() { $('#sequence').dialog('close'); resetSeq(); }, 2000);
			});	
		}

		function rebuild()
		{
			initSequence(1, \"{$lang['init']}\");
			successSeq(1);
			initSequence(2, \"{$lang['seq_rebuild']}\");
			$('#recipe').load('/panel/apps/rebuild_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				successSeq(2);
				initSequence(3, \"{$lang['seq_end']}\");
				successSeq(3);
				restart();
			});	
		}

		$(function()
		{
			var dataSourceDay = [";

foreach( $data_day as $key => $value )
{
	$content .= "
			{ hour: '".date($lang['dateformathour'], $key)."', responsetime: {$value['time']} },
	";
}

$content .= "
			];
			
			var dataSourceMonth = [";

foreach( $data_month as $key => $value )
{
	$content .= "
			{ day: '".date($lang['dateformat'], $key)."', responsetime: {$value['time']} },
	";
}

$content .= "
			];

			var dataSourceYear = [";

foreach( $data_year as $key => $value )
{
	$content .= "
			{ month: '".date($lang['dateformatmonth'], $key)."', responsetime: {$value['time']} },
	";
}

$content .= "
			];
			
			$(\"#response1\").dxChart({
				dataSource: dataSourceDay,
				commonSeriesSettings: {
					argumentField: \"hour\"
				},
				series: [
					{ valueField: \"responsetime\", name: \"{$lang['responsetime']}\", type: 'splineArea', 'color': '#65aadb' }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + 'ms'
						}
				}},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart1_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\",
					visible: false
				},
				size: {
					width: 1100,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});

			$(\"#response2\").dxChart({
				dataSource: dataSourceMonth,
				commonSeriesSettings: {
					argumentField: \"day\"
				},
				series: [
					{ valueField: \"responsetime\", name: \"{$lang['responsetime']}\", type: 'splineArea', 'color': '#65aadb' }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + 'ms'
						}
				}},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart2_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\",
					visible: false
				},
				size: {
					width: 1100,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});
			
			$(\"#response3\").dxChart({
				dataSource: dataSourceYear,
				commonSeriesSettings: {
					argumentField: \"month\"
				},
				series: [
					{ valueField: \"responsetime\", name: \"{$lang['responsetime']}\", type: 'splineArea', 'color': '#65aadb' }
				],
				argumentAxis:{
					grid:{
						visible: true
					},
					label: {
						overlappingBehavior: { mode: 'rotate', rotationAngle: 50 }
					}
				},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart3_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\",
					visible: false
				},
				size: {
					width: 800,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});
		});			
		
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
