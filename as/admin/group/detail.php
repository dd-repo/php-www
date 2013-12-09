<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$group = api::send('group/list', array('id'=>$_GET['id']));
if( count($group) == 0 )
	template::redirect('/admin/group');
$group = $group[0];

$content = "
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['title']} : {$group['name']}</h5></div>
				<div class=\"widgets\">
					<div class=\"left\">";
					
if( security::hasGrant('GROUP_USER_SELECT') )
{
	$groupusers = api::send('group/user/list', array('group'=>$_GET['id']));

	$content .= "
						<script type=\"text/javascript\">
							function confirmQuit(id)
							{
								jConfirm(\"{$lang['confirm_text']}\", \"{$lang['confirm_title']}\", function(r)
								{
									if( r )
										window.location.href = window.location.protocol+'//'+window.location.host+'/admin/user/quit_action?user='+id+'&group={$group['id']}&redirect=/admin/group/detail%3Fid%3D{$_GET['id']}';
								});
								return false;
							}
						</script>
						<div class=\"widget first\">
							<div class=\"head\">
								<h5 class=\"iList\">{$lang['users']}</h5>
							</div>
							<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"tableStatic\" id=\"userList\">
								<thead>
									<tr>
										<td align=\"center\">{$lang['username']}</td>
										<td align=\"center\">{$lang['action']}</td>
									</tr>
								</thead>
								<tbody>";

	foreach( $groupusers as $u )
	{
		$content .= "
									<tr class=\"gradeA\">
										<td>{$u['name']}</td>
										<td align=\"center\">";

		if( security::hasGrant('USER_SELECT') )
		{
			$content .= "
											<a href=\"/admin/user/detail?id={$u['id']}\" title=\"{$lang['detail']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/preview.png\" alt=\"{$lang['detail']}\" /></a>";
		}
	
		if( security::hasGrant('GROUP_USER_DELETE') )
		{
			$content .= "
											<a href=\"javascript:void(0);\" onclick=\"confirmQuit({$u['id']});\" title=\"{$lang['quit']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/close.png\" alt=\"{$lang['quit']}\" /></a>";
		}
	
		$content .= "
										</td>
									</tr>";
	}
	
	$content .= "
								</tbody>
							</table>
						</div>
						<script type=\"text/javascript\">
							\$(function() {
								oTable1 = \$('#userList').dataTable({
									\"bJQueryUI\": true,
									\"sPaginationType\": \"full_numbers\",
									\"sDom\": '<\"\"f>t<\"F\"lp>'
								});
							});
						</script>";
}

if( security::hasGrant('GRANT_GROUP_SELECT') )
{
	$groupgrants = api::send('grant/group/list', array('group'=>$_GET['id']));
	if( security::hasGrant('GRANT_SELECT') )
		$grants = api::send('grant/list');
	else
		$grants = $groupgrants;
	
	$content .= "
						<form action=\"/admin/group/grant_action\" method=\"post\" class=\"mainForm\">
							<fieldset>
								<div class=\"widget\">
									<div class=\"head\">
										<h5 class=\"iKey\">{$lang['grants']}</h5>
										<div class=\"icon\"><input type=\"checkbox\" name=\"foo\" value=\"bar\" /></div>
									</div>
									<div style=\"max-height: 350px; overflow-y: auto;\">
									<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"tableStatic\" id=\"grantList\">
										<thead>
											<tr>
												<td align=\"center\">{$lang['grantname']}</td>
												<td align=\"center\">{$lang['granted']}</td>
											</tr>
										</thead>
										<tbody>";

	if( security::hasGrant(array('GRANT_GROUP_INSERT','GRANT_GROUP_DELETE')) )
		$disabled = '';
	else
		$disabled = 'disabled';

	foreach( $grants as $g )
	{
		$checked = '';
		foreach( $groupgrants as $k )
		{
			if( $g['id'] == $k['id'] )
			{
				$checked = 'checked';
				break;
			}
		}
		
		$content .= "
											<tr class=\"gradeA\">
												<td>{$g['name']}</td>
												<td align=\"center\">
													<input type=\"checkbox\" name=\"grant[]\" value=\"{$g['id']}\" {$disabled} {$checked} />
												</td>
											</tr>";
	}

	$content .= "
										</tbody>
									</table>
									</div>
									<div class=\"fix\"></div>
									<input type=\"hidden\" name=\"id\" value=\"{$group['id']}\" />
									<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} class=\"greyishBtn submitForm\" />
									<div class=\"fix\"></div>
								</div>
							</fieldset>
						</form>";
}

$content .= "
					</div>
					
					<div class=\"right\">";
					
if( security::hasGrant('GROUP_UPDATE') )
{
	$content .= "
						<form action=\"/admin/group/update_action\" method=\"post\" class=\"mainForm\">
							<fieldset>
								<div class=\"widget first\">
									<div class=\"head\"><h5 class=\"iRefresh3\">{$lang['rename']}</h5></div>
									<div class=\"rowElem\"><label>{$lang['name']}</label>
										<div class=\"formRight\"><input type=\"text\" name=\"name\" /></div>
										<div class=\"fix\"></div>
									</div>
									<input type=\"hidden\" name=\"id\" value=\"{$group['id']}\" />
									<input type=\"submit\" value=\"{$lang['rename']}\" class=\"greyishBtn submitForm\" />
									<div class=\"fix\"></div>
								</div>
							</fieldset>
						</form>";
}

$content .= "
					</div>
				</div>
			</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>