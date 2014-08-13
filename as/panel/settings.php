<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$userinfo = api::send('self/user/list');
$userinfo = $userinfo[0];

$month = date('F', $userinfo['date']);
$month_translate = $lang[$month];
	
$content = "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px;\">
				<h1 class=\"dark\" style=\"padding-top: 7px;\">{$lang['settings']}</h1>
				<blockquote style=\"width: 100%;\"><p>{$lang['registered']} <span style=\"font-weight: bold;\">".str_replace($month, $month_translate, date($lang['DATEFORMAT'], $userinfo['date']))."</span>.</p></blockquote>
			</div>
			<div class=\"right\" style=\"width: 550px; float: right; text-align: right;\">
				<a class=\"action pass big\" href=\"#\" onclick=\"$('#changepass').dialog('open'); return false;\">
					{$lang['pass']}
				</a>
				<a class=\"action apps big\" href=\"/panel/settings/tokens\">
					{$lang['apps']}
				</a>
				<a class=\"action delete big\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\">
					{$lang['delete']}
				</a>					
			</div>
			<div class=\"clear\"></div>
		</div>
		<div class=\"container\">
			<div class=\"left\" style=\"width: 600px; margin-top: 20px;\">
				<h2 class=\"dark thin\">{$lang['config']}</h2>
				<form action=\"/panel/settings/update_action\" method=\"post\">
					<div style=\"float: left;\">
						<fieldset>
							<input type=\"text\" name=\"firstname\" value=\"{$userinfo['firstname']}\" style=\"width: 250px;\"/>
							<span class=\"help-block\">{$lang['firstname_help']}</span>
						</fieldset>
						<fieldset>
							<input type=\"text\" name=\"email\" value=\"{$userinfo['email']}\" style=\"width: 250px;\" />
							<span class=\"help-block\">{$lang['mail_help']}</span>
						</fieldset>
						<fieldset>
							<select name=\"report\" style=\"width: 270px;\">
								<option ".($userinfo['report']=='1'?"selected":"")." value=\"1\">{$lang['reportactive']}</option>
								<option ".($userinfo['report']!='1'?"selected":"")." value=\"0\">{$lang['reportinactive']}</option>
							</select>
							<span class=\"help-block\">{$lang['report_help']}</span>
						</fieldset>			
					</div>
					<div style=\"float: right;\">
						<fieldset>
							<input type=\"text\" name=\"lastname\" value=\"{$userinfo['lastname']}\" style=\"width: 250px;\" />
							<span class=\"help-block\">{$lang['lastname_help']}</span>
						</fieldset>
						<fieldset>
							<select name=\"language\" style=\"width: 270px;\">
								<option ".($userinfo['language']=='EN'?"selected":"")." value=\"EN\">English</option>
								<option ".($userinfo['language']=='FR'?"selected":"")." value=\"FR\">Fran&ccedil;ais</option>
								<option ".($userinfo['language']=='ES'?"selected":"")." value=\"ES\">Espa&ntilde;ol</option>
							</select>
							<span class=\"help-block\">{$lang['lang_help']}</span>
						</fieldset>
					</div>
					<div style=\"float: right;\">
					    <fieldset>
				    		<input type=\"submit\" value=\"{$lang['update']}\" />
			    		</fieldset>		
					</div>
				</form>
				<div class=\"clear\"></div>
				<br />
				<div style=\"float: left; width: 300px; padding-top: 5px;\">
					<h2 class=\"dark thin\">{$lang['keys']}</h2>
				</div>
				<div style=\"float: right; width: 200px;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#new-key').dialog('open');\" style=\"width: 22px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
					</a>
				</div>
				<div class=\"clear\"></div>
				<br />
				<table>
					<tr>
						<th>{$lang['key']}</th>
						<th style=\"width: 70px; text-align: center;\">{$lang['actions']}</th>
					</tr>
	";
	
	if( !is_array($userinfo['keys']) && $userinfo['keys'] )
		$userinfo['keys'] = array($userinfo['keys']);
	
	if( $userinfo['keys'] )
	{
		$i = 0;
		foreach( $userinfo['keys'] as $k )
		{
			$k = trim(str_replace("'", "\\'", $k));
			
			$content .= "
					<tr>
						<td style=\"white-space: nowrap; overflow: hidden; text-overflow: ellipsis; \">".substr($k, 0, 40)."...</td>
						<td style=\"width: 70px; text-align: center;\">
							<a href=\"#\"onclick=\"$('#keyvalue').html('{$k}'); $('#key').dialog('open');\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/preview.png\" alt=\"\" /></a>
							<a href=\"/panel/settings/del_key_action?key={$i}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
						</td>
					</tr>";
			$i++;
		}
	}
	
	$content .= "		
				</table>
			</div>
			<div class=\"right border\" style=\"width: 370px; padding-left: 60px; margin-left: 40px; margin-top: 20px;\">
				<h2 class=\"dark thin\">{$lang['avatar']}</h1>
				<br />
				<form action=\"/panel/settings/upload_action\" method=\"post\" enctype=\"multipart/form-data\">
					<fieldset>
						<img style=\"width: 140px; height: 140px;\" src=\"".(file_exists("{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png")?"/{$GLOBALS['CONFIG']['SITE']}/images/users/{$userinfo['id']}.png":"/{$GLOBALS['CONFIG']['SITE']}/images/users/user.png")."\" /><br /><br />
						<input type=\"file\" name=\"avatar\" />
						<span class=\"help-block\">{$lang['avatar_100']}</span>
					</fieldset>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>		
				</form>		
			</div>
			<div class=\"right border\" style=\"width: 370px; padding-left: 60px; margin-left: 40px; margin-top: 20px;\">
				<h2 class=\"dark thin\">{$lang['billing']}</h1>
				<br />
				<form action=\"/panel/settings/update_action\" method=\"post\" enctype=\"multipart/form-data\">
					<fieldset>
						<input type=\"text\" name=\"organisation\" value=\"{$userinfo['organisation']}\" style=\"width: 250px;\"/>
						<span class=\"help-block\">{$lang['organisation_help']}</span>
					</fieldset>
					<fieldset>
						<textarea name=\"postal_address\" style=\"width: 250px; height: 50px;\">{$userinfo['postal_address']}</textarea>
						<span class=\"help-block\">{$lang['postal_address_help']}</span>
					</fieldset>
					<div style=\"float: left;\">
					<fieldset>
						<input type=\"text\" name=\"postal_code\" value=\"{$userinfo['postal_code']}\" style=\"width: 50px;\"/>
						<span class=\"help-block\">{$lang['postal_code_help']}</span>
					</fieldset>
                    </div>
					<div style=\"float: left; padding-left: 30px; \">
					<fieldset>
						<input type=\"text\" name=\"locality\" value=\"{$userinfo['locality']}\" style=\"width: 150px;\"/>
						<span class=\"help-block\">{$lang['locality_help']}</span>
					</fieldset>
                    </div>
					<fieldset>
						<input type=\"submit\" value=\"{$lang['update']}\" />
					</fieldset>		
				</form>		
			</div>
			<div class=\"clear\"></div>
		</div>
	</div>
	<div id=\"changepass\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['changepass']}</h3>
		<p style=\"text-align: center;\">{$lang['changepass_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/settings/update_action\" method=\"post\" class=\"center\">
				<fieldset>
					<input type=\"password\" name=\"pass\" />
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
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/settings/del_action\" method=\"post\" class=\"center\">
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"new-key\" style=\"display: none;\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['new_key']}</h3>
		<p style=\"text-align: center;\">{$lang['new_key_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/settings/add_key_action\" method=\"post\" class=\"center\">
				<fieldset>
					<textarea class=\"auto\" style=\"width: 300px;\" rows=\"10\" name=\"key\" onfocus=\"this.value = this.value=='{$lang['key']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['key']}' : this.value; this.value=='{$lang['key']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\">{$lang['key']}</textarea>
					<span class=\"help-block\">{$lang['key_help']}</span>
				</fieldset>
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['create']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"key\" style=\"display: none;\" class=\"floatingdialog\">
		<br />
		<p id=\"keyvalue\"></p>
	</div>
	<script>
		newFlexibleDialog('changepass', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('new-key', 550);
		newFlexibleDialog('key', 550);
	</script>	
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
