<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$token = api::send('token/list', array('user'=>$_GET['user'], 'token'=>$_GET['token']));
if( count($token) == 0 )
	template::redirect('/admin/user/detail?id='.$_GET['user']);
$token = $token[0];

$content = "
	<div class=\"box nocol\">
		<div class=\"container\">
			<h2>{$lang['title']} : {$token['name']} ({$token['token']})</h2>
			<br />
			<div style=\"width: 48%; float: left; margin-right: 20px;\">
				<h3 class=\"colored\">{$lang['grants']}</h3>
";

if( security::hasGrant('GRANT_TOKEN_SELECT') )
{
	$tokengrants = api::send('grant/token/list', array('user'=>$_GET['user'], 'token'=>$_GET['token']));
	if( security::hasGrant('GRANT_USER_SELECT') )
		$grants = api::send('grant/user/list', array('user'=>$_GET['user'], 'overall'=>true));
	else
		$grants = $tokengrants;

	$content .= "
				<br />
				<form action=\"/admin/token/grant_action\" method=\"post\">
					<table>
						<tr>
							<th>{$lang['grantname']}</th>
							<th>{$lang['granted']}</th>
						</tr>
	";
	
	if( security::hasGrant(array('GRANT_TOKEN_INSERT','GRANT_TOKEN_DELETE')) )
		$disabled = '';
	else
		$disabled = 'disabled';

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
						</tr>";
	}

	$content .= "
					</table>
					<input type=\"hidden\" name=\"user\" value=\"{$_GET['user']}\" />
					<input type=\"hidden\" name=\"token\" value=\"{$_GET['token']}\" />
					<br />
					<input type=\"submit\" value=\"{$lang['update']}\" {$disabled} />
				</form>
";
}

$content .= "
			</div>
			<div style=\"width: 48%; float: left;\">
				<h3 class=\"colored\">{$lang['tokeninfo']}</h3>
";

$tokendate = '';
if( $token['lease'] > 0 )
	$tokendate = date('j-n-Y', $token['lease']);

$content .= "
				<br />
				<form action=\"/admin/token/update_action\" method=\"post\">
					<input type=\"hidden\" name=\"user\" value=\"{$_GET['user']}\" />
					<input type=\"hidden\" name=\"token\" value=\"{$_GET['token']}\" />
					<fieldset>
						<label>{$lang['tokenname']}</label>
						<input type=\"text\" name=\"name\" value=\"{$token['name']}\" />
					</fieldset>					
					<fieldset>
						<label>{$lang['tokenlease']}</label>
						<input type=\"text\" name=\"lease\" id=\"lease\" value=\"{$tokendate}\" />
					</fieldset>
					<fieldset>
						<label></label>
						<input type=\"submit\" value=\"{$lang['update']}\" ".(security::hasGrant('TOKEN_UPDATE')?'':'disabled')." />
					</fieldset>
				</form>
			</div>
			<div class=\"clearfix\"></div>
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>