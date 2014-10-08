<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head-light\">
				<div class=\"container\">
					<h1 class=\"dark\">{$lang['title']}</h1>
				</div>
			</div>	
			<div class=\"content\">
				<div class=\"left\">
					<h4>{$lang['send']}</h4>
					<p>{$lang['send_text']}</p>
					<br />
					<form action=\"/about/contact_action\" method=\"post\">
						<fieldset>
							<input class=\"large\" type=\"text\" name=\"name\" placeholder=\"{$lang['name']}\" />
						</fieldset>
						<fieldset>
							<input class=\"large\" type=\"text\" name=\"email\" placeholder=\"{$lang['email']}\"/>
						</fieldset>
						<fieldset>
							<input class=\"large\" type=\"text\" name=\"subject\" placeholder=\"{$lang['subject']}\" />
						</fieldset>
						<fieldset>
							<textarea class=\"large\" rows=\"10\" name=\"message\" placeholder=\"{$lang['message']}\"></textarea>
						</fieldset>
						<fieldset>
							<input type=\"submit\" value=\"{$lang['send_now']}\" />
						</fieldset>
					</form>
				</div>
				<div class=\"right border\">
					<h4>{$lang['infos']}</h4>
					<p>Paris, France</p>
					<p><a href=\"mailto: contact@anotherservice.com\">contact@anotherservice.com</a></p>
					<p>+33.953.935.953</p>
					<p>#anotherservice@irc.freenode.net</p>
					<br />
					<h4>{$lang['meet']}</h4>
					<p>{$lang['meet_text']}</p>
					<div style=\"width: 330px; height: 330px;\">
						<iframe width=\"330\" height=\"330\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=19%2BRue%2BPierre%2BLescot%2BParis&ie=UTF8&z=5&t=m&iwloc=near&output=embed\"></iframe>
					</div>
				</div>
				<div class=\"clear\"></div>
				<br /><br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>