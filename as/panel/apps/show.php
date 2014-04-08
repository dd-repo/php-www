<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

if( !$_GET['branch'] && !$_SESSION['DATA'][$app['id']]['branch'] )
	$_SESSION['DATA'][$app['id']]['branch'] = 'master';
else if( $_GET['branch'] )
	$_SESSION['DATA'][$app['id']]['branch'] = $_GET['branch'];

$memory = 0;
$instances = 0;
$memoryone = 0;
foreach( $app['branches'][$_SESSION['DATA'][$app['id']]['branch']]['instances'] as $i )
{
	$memoryone = $i['memory']['quota'];
	$memory = $memory+$i['memory']['quota'];
	$instances++;
}

$expl = explode('-', $app['name']);
$language = $expl[0];
	
$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 400px;\">
				<img style=\"display: block; float: left; margin-right: 20px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/languages/icon-{$language}.png\" alt=\"\" />
				<div style=\"float: left;\">
					<span style=\"font-size: 25px; display: block; margin-bottom: 4px;\">{$app['tag']}</span>
					<span style=\"font-size: 15px; color: #878787; display: block; margin-bottom: 10px;\">{$app['name']}</span>
";

foreach( $app['branches'] as $key => $value )
	$content .= "<a href=\"/panel/apps/show?id={$app['id']}&branch={$key}\" class=\"branch ".($key==$_SESSION['DATA'][$app['id']]['branch']?"active":"")."\">{$key}</a>";

$content .= "
					<a href=\"#\" class=\"branch\" onclick=\"$('#newbranch').dialog('open'); return false;\">+</a>
				</div>
			</div>
			<div class=\"right\" style=\"width: 700px; float: right; text-align: right;\">
				<a class=\"action settings big\" href=\"#\" onclick=\"$('#settings').dialog('open'); return false;\">
					{$lang['settings']}
				</a>
				<a class=\"action pass big\" href=\"#\" onclick=\"$('#changepass').dialog('open'); return false;\">
					{$lang['changepass']}
				</a>
				<a class=\"action push big\" href=\"#\" onclick=\"$('#push').dialog('open'); return false;\">
					{$lang['push']}
				</a>
				<a class=\"action delete big\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\">
					{$lang['delete']}
				</a>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
		<div class=\"container\">
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
						<th>{$lang['actions']}</th>
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
			<div id=\"instances\">
			
			</div>
		</div>
	</div>
	<br />
	<div id=\"newurl\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['newurl_title']}</h3>
		<p style=\"text-align: center;\">{$lang['newurl_text']}</p>
		<div class=\"form-small\" id=\"urls\"></div>
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
						<option value=\"tests\">tests</option>
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
	<div id=\"alert\" class=\"floatingdialog\">
		<h3 class=\"center\" style=\"padding-top: 5px;\">{$lang['alert']}</h3>
		<p style=\"text-align: center;\" id=\"alertcontent\"></p>
		<a style=\"width: 150px; margin: 0 auto;\" href=\"#\" onclick=\"$('#alert').dialog('close'); return false;\" class=\"button classic\">{$lang['close']}</a>
		<br />
	</div>
	<div id=\"recipe\" style=\"display: none;\"></div>
	<script>
		memory = {$memoryone};
		instances = {$instances};
		
		$('#loading').show();
		$('#instances').load('/panel/apps/ajax_instances?id={$app['id']}', function()
		{
			$('#loading').hide();
			setTimeout(function() { getinstances(); }, 2000);
		});

		newFlexibleDialog('newurl', 550);
		newFlexibleDialog('newbranch', 550);
		newFlexibleDialog('settings', 550);
		newFlexibleDialog('changepass', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('push', 700);
		newFlexibleDialog('alert', 550);
		
		function getinstances()
		{
			$('#instances').load('/panel/apps/ajax_instances?id={$app['id']}', function()
			{
				setTimeout(function() { getinstances(); }, 2000);
			});
		}
		
		function geturls()
		{
			$('#loading').show();
			$('#urls').load('/panel/apps/ajax_urls?id={$app['id']}', function()
			{
				$('#loading').hide();
			});
		}

		function increaseInstances()
		{
			if( instances == 0 )
				memory = 128;
				
			instances = instances+1;
			$('#instancescount').html(instances);
			$('#memorycount').html(memory*instances);
			
			$('#loading').show();
			$('#recipe').load('/panel/apps/instance_increase_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&instances=' + instances, function()
			{
				$('#loading').hide();
			});
		}
		
		function decreaseInstances()
		{
			if( instances > 0 )
			{
				instances = instances-1;
				$('#instancescount').html(instances);
				$('#memorycount').html(memory*instances);
				
				$('#loading').show();
				$('#recipe').load('/panel/apps/instance_decrease_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&instances=' + instances, function()
				{
					$('#loading').hide();
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
				
				$('#loading').show();
				$('#recipe').load('/panel/apps/memory_decrease_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&memory=' + memory, function()
				{
					$('#loading').hide();
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
				memory = memory*2;
				$('#memorycount').html(memory*instances);
				
				$('#loading').show();
				$('#recipe').load('/panel/apps/memory_increase_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."&memory=' + memory, function()
				{
					$('#loading').hide();
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
			$('#loading').show();
			$('#recipe').load('/panel/apps/start_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				$('#loading').hide();
			});	
		}
		
		function stop()
		{
			$('#loading').show();
			$('#recipe').load('/panel/apps/stop_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				$('#loading').hide();
			});	
		}

		function restart()
		{
			$('#loading').show();
			$('#recipe').load('/panel/apps/restart_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				$('#loading').hide();
				success();
			});	
		}

		function rebuild()
		{
			$('#loading').show();
			$('#recipe').load('/panel/apps/rebuild_action?id={$app['id']}&branch=".security::encode($_SESSION['DATA'][$app['id']]['branch'])."', function()
			{
				$('#loading').hide();
				
			});	
		}
		
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>