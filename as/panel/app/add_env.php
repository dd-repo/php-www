<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$app = api::send('self/app/list', array('id'=>$_GET['id']));
$app = $app[0];

$content = "
	<div class=\"box rightcol\">
		<div class=\"left\">
			<div class=\"container\">
				<h2>{$lang['title']} :: <i>{$app['name']}</i></h2>
				<form action=\"/panel/app/add_env_action\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"{$_GET['id']}\" />
					<fieldset>
						<label for=\"url\">{$lang['branch']}</label>
						<input type=\"text\" name=\"branch\" />
					</fieldset>
					<fieldset>
						<label for=\"submit\">&nbsp;</label>
						<input type=\"submit\" value=\"{$lang['add']}\" />
					</fieldset>
				</form>
			</div>
		</div>
		<div class=\"right\">
			<div class=\"container\">	
			</div>
		</div>
		<div class=\"clearfix\"></div>
	</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>