<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$token = api::send('self/token/list', array('token'=>$_GET['token']));
$token = $token[0];

$content = "
				<h1>{$lang['title']} : {$token['name']} ({$token['token']})</h1>
";
		
$tokengrants = api::send('self/token/grant/list', array('token'=>$_GET['token']));

if( security::hasGrant('SELF_GRANT_SELECT') )
	$grants = api::send('self/grant/user/list', array('overall'=>true));
else
	$grants = $tokengrants;

$content .= "
			<div class=\"column-2-1\">
				<h2>{$lang['grants']}</h2>
				<form action=\"/panel/settings/token_grant_action\" method=\"post\" id=\"tokens\">
					<table cellpadding=\"0\" cellspacing=\"0\" id=\"grantList\">
						<tr>
							<th align=\"center\">{$lang['grantname']}</th>
							<th align=\"center\">{$lang['granted']}</th>
						</tr>
";

foreach( $grants as $g )
{
	$checked = '';
	foreach( $tokengrants as $k )
	{
		if( $g['id'] == $k['id'] )
		{
			$checked = 'checked';
			break;
		}
	}
		
	$content .= "
						<tr>
							<td>{$g['name']}</td>
							<td align=\"center\">
								<input type=\"checkbox\" name=\"grant[]\" value=\"{$g['id']}\" {$disabled} {$checked} />
							</td>
						</tr>
	";
}

	$content .= "
					</table>
					<input type=\"hidden\" name=\"token\" value=\"{$_GET['token']}\" />
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} class=\"greyishBtn submitForm\" />
				</form>
			</div>
			<div class=\"column-2-2\">
";

$tokendate = '';
if( $token['lease'] > 0 )
	$tokendate = date('j-n-Y', $token['lease']);

$content .= "
				<h2>{$lang['tokeninfo']}</h2>
				<form action=\"/panel/settings/token_update_action\" method=\"post\">
					<input type=\"hidden\" name=\"user\" value=\"{$_GET['user']}\" />
					<input type=\"hidden\" name=\"token\" value=\"{$_GET['token']}\" />
					<fieldset>
						<label>{$lang['tokenname']}</label>
						<input type=\"text\" name=\"name\" value=\"{$token['name']}\" />
					</fieldset>
					<fieldset>
						<label>{$lang['tokenlease']}</label>
						<input type=\"text\" name=\"lease\" id=\"lease\" value=\"{$tokendate}\" class=\"datepicker\" />
					</fieldset>
					<fieldset>
						<label for=\"submit\">&nbsp;</label>
						<input type=\"submit\" value=\"{$lang['update']}\" ".(security::hasGrant('TOKEN_UPDATE')?'':'disabled')." />
					</fieldset>							
				</form>				
			</div>
			<div class=\"clearfix\"></div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>