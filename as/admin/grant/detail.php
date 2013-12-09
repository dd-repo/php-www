<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$grant = api::send('grant/list', array('id'=>$_GET['id']));
if( count($grant) == 0 )
	template::redirect('/admin/grant');
$grant = $grant[0];
	
$content = "
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['title']} : {$grant['name']}</h5></div>
				<div class=\"widgets\">
					<div class=\"left\">";

if( security::hasGrant('GRANT_USER_SELECT') )
{
	$grantusers = api::send('grant/user/list', array('grant'=>$_GET['id']));
	
	$content .= "
						<script type=\"text/javascript\">
							function confirmRevoke(id)
							{
								jConfirm(\"{$lang['confirm_text']}\", \"{$lang['confirm_title']}\", function(r)
								{
									if( r )
										window.location.href = window.location.protocol+'//'+window.location.host+'/admin/user/revoke_action?user='+id+'&grant={$grant['id']}&redirect=/admin/grant/detail%3Fid%3D{$_GET['id']}';
								});
								return false;
							}
						</script>
						<div class=\"widget\">
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

	foreach( $grantusers as $u )
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
	
		if( security::hasGrant('GRANT_USER_DELETE') )
		{
			$content .= "
											<a href=\"javascript:void(0);\" onclick=\"confirmRevoke({$u['id']});\" title=\"{$lang['revoke']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/close.png\" alt=\"{$lang['revoke']}\" /></a>";
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
	$grantgroups = api::send('grant/group/list', array('grant'=>$_GET['id']));
	
	$content .= "
						<script type=\"text/javascript\">
							function confirmRevoke2(id)
							{
								jConfirm(\"{$lang['confirm_text']}\", \"{$lang['confirm_title']}\", function(r)
								{
									if( r )
										window.location.href = window.location.protocol+'//'+window.location.host+'/admin/group/revoke_action?group='+id+'&grant={$grant['id']}&redirect=/admin/grant/detail%3Fid%3D{$_GET['id']}';
								});
								return false;
							}
						</script>
						<div class=\"widget\">
							<div class=\"head\">
								<h5 class=\"iList\">{$lang['groups']}</h5>
							</div>
							<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"tableStatic\" id=\"groupList\">
								<thead>
									<tr>
										<td align=\"center\">{$lang['groupname']}</td>
										<td align=\"center\">{$lang['action']}</td>
									</tr>
								</thead>
								<tbody>";

	foreach( $grantgroups as $g )
	{
		$content .= "
									<tr class=\"gradeA\">
										<td>{$g['name']}</td>
										<td align=\"center\">";

		if( security::hasGrant('GROUP_SELECT') )
		{
			$content .= "
											<a href=\"/admin/group/detail?id={$g['id']}\" title=\"{$lang['detail']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/preview.png\" alt=\"{$lang['detail']}\" /></a>";
		}
	
		if( security::hasGrant('GRANT_GROUP_DELETE') )
		{
			$content .= "
											<a href=\"javascript:void(0);\" onclick=\"confirmRevoke2({$g['id']});\" title=\"{$lang['revoke']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/close.png\" alt=\"{$lang['revoke']}\" /></a>";
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
								oTable2 = \$('#groupList').dataTable({
									\"bJQueryUI\": true,
									\"sPaginationType\": \"full_numbers\",
									\"sDom\": '<\"\"f>t<\"F\"lp>'
								});
							});
						</script>";
}

$content .= "
					</div>
					
					<div class=\"right\">";
					
if( security::hasGrant('GRANT_UPDATE') )
{
	$content .= "
						<form action=\"/admin/grant/update_action\" method=\"post\" class=\"mainForm\">
							<fieldset>
								<div class=\"widget first\">
									<div class=\"head\"><h5 class=\"iRefresh3\">{$lang['rename']}</h5></div>
									<div class=\"rowElem\"><label>{$lang['name']}</label>
										<div class=\"formRight\"><input type=\"text\" name=\"name\" /></div>
										<div class=\"fix\"></div>
									</div>
									<input type=\"hidden\" name=\"id\" value=\"{$grant['id']}\" />
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