<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$grants = api::send('grant/list');

$content = "
			<script type=\"text/javascript\">
				function confirmDelete(id)
				{
					jConfirm(\"{$lang['confirm_text']}\", \"{$lang['confirm_title']}\", function(r)
					{
						if( r )
							window.location.href = window.location.protocol+'//'+window.location.host+'/admin/grant/del_action?id='+id;
					});
					return false;
				}
			</script>
			<div class=\"content\">
				<div class=\"title\"><h5>{$lang['title']}</h5></div>
				<div class=\"widgets\">
					<div class=\"left\">
						<div class=\"widget first\">
							<div class=\"head\">
								<h5 class=\"iKey\">{$lang['grant']}</h5>
							</div>
							<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"grantList\">
								<thead>
									<tr>
										<th>{$lang['name']}</th>
										<th>{$lang['action']}</th>
									</tr>
								</thead>
								<tbody>";
foreach( $grants as $g )
{
	$content .= "
									<tr class=\"gradeA\">
										<td>{$g['name']}</td>
										<td align=\"center\">
											<a href=\"/admin/grant/detail?id={$g['id']}\" title=\"{$lang['manage']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/preview.png\" alt=\"{$lang['manage']}\" /></a>";

	if( security::hasGrant('GRANT_DELETE') )
	{
		$content .= "
											<a href=\"javascript:void(0);\" onclick=\"confirmDelete({$g['id']});\" title=\"{$lang['delete']}\" class=\"btn14 mr5\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/dark/close.png\" alt=\"{$lang['delete']}\" /></a>";
	}
	
	$content .= "
										</td>
									</tr>";
}

$content .= "
								</tbody>
							</table>
						</div>
					</div>
						<script type=\"text/javascript\">
							function tablepaging()
							{
								oTable1 = \$('#grantList').dataTable({
									\"bJQueryUI\": true,
									\"sPaginationType\": \"full_numbers\",
									\"sDom\": '<\"\"f>t<\"F\"lp>'
								});
							};
						</script>";
					
if( security::hasGrant('GRANT_INSERT') )
{
	$content .= "
					<div class=\"right\">
						<form action=\"/admin/grant/add_action\" method=\"post\" class=\"mainForm\">
							<fieldset>
								<div class=\"widget first\">
									<div class=\"head\"><h5 class=\"iAdd\">{$lang['add']}</h5></div>
									<div class=\"rowElem\"><label>{$lang['name']}</label>
										<div class=\"formRight\"><input type=\"text\" name=\"name\" /></div>
										<div class=\"fix\"></div>
									</div>
									<input type=\"submit\" value=\"{$lang['add']}\" class=\"greyishBtn submitForm\" />
									<div class=\"fix\"></div>
								</div>
							</fieldset>
						</form>
					</div>";
}

$content .= "
				</div>
			</div>
<script type=\"text/javascript\">
	function postInit()
	{
		try { tablepaging(); } catch ( e ) { }
	}
</script>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>