<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if( $_POST['name'] )
{
	$user = api::send('user/select', array('user'=>$_POST['name']));
	
	if( count($user) > 1 )
	{
		$content = "
		<div class=\"box nocol\">
			<div class=\"container\">
				<h2>{$lang['title']}</h2>
				<br />
				<table>
					<tr>
						<th>{$lang['name']}</th>
						<th>{$lang['email']}</th>
						<th>{$lang['date']}</th>
						<th>{$lang['ip']}</th>
						<th>{$lang['actions']}</th>
					</tr>";

		foreach( $user as $u )
		{
			$content .= "
					<tr>
						<td>{$u['name']}</td>
						<td>{$u['email']}</td>
						<td>".date('Y-m-d', $u['date'])."</td>
						<td>{$u['ip']}</td>
						<td>
							<a href=\"/admin/user/detail?id={$u['id']}\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
						</td>
					</tr>
	";
		}
	
		$content .= "
				</table>
			</div>
		</div>
		";

		$template->output($content);
	}	
	else
		$template->redirect('/admin/user/detail?id='.$user[0]['id']);
}
elseif( $_POST['domain'] )
{
	$domain = api::send('domain/select', array('domain'=>$_POST['domain']));
	$template->redirect('/admin/user/detail?id='.$domain[0]['user']['id']);
}
else
	template::redirect('/admin');

?>