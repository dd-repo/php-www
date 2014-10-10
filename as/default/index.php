<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$content = "
			<div class=\"head\">
				<br /><br />
				<h1 style=\"margin: 15px 0 5px 0;\">{$lang['intro']}</h1>
				<h2 style=\"margin: 20px 0 10px 0; color: #ffffff; letter-spacing: 1px;\">{$lang['intro_text']}</h2>
				<br /><br />
";

if( !isset($_SESSION['ANTISPAM']) )
	$_SESSION['ANTISPAM'] = md5(time().'anotherservice');

$content .= "
			</div>
			<div class=\"content\">
				<div style=\"text-align: center;\">
					<a href=\"/hosting\">
						<div class=\"box\">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/hosting.png\" alt=\"\" style=\"width: 150px;\" /><br /><br />
							<span style=\"color: #53bfed; text-transform: uppercase; font-size: 1.9em; display: block; margin: 0 auto; padding-bottom: 5px;\">{$lang['mutu']}</span><br />
							<span style=\"color: #949494;\">{$lang['mutu_text']}</span>
							<br /><br />
							<span style=\"font-size: .8em; color: #a3a3a3;\">{$lang['mutu_price']}</span>		
						</div>
					</a>
					<a href=\"/paas\">
						<div class=\"box\">
							<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/illu/paas.png\" alt=\"\"  style=\"width: 150px;\" /><br /><br />
							<span style=\"color: #53bfed; text-transform: uppercase; font-size: 1.9em; display: block; margin: 0 auto; padding-bottom: 5px;\">{$lang['paas']}</span><br />
							<span style=\"color: #949494;\">{$lang['paas_text']}</span>
							<br /><br />
							<span style=\"font-size: .8em; color: #a3a3a3;\">{$lang['paas_price']}</span>
						</div>
					</a>
					<br /><br />
					<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/services/services.png\" alt=\"\" /><br />
				</div>
			</div>			
			<div class=\"grey\">
				<div class=\"content\">
					<div id=\"stats\" style=\"text-align: center;\"></div>
				</div>
			</div>
			<div class=\"content\">
				<div style=\"text-align: center;\">
					<div style=\"display: inline-block; margin-right: 50px; opacity: 0.6;\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/references/bnpparibas.png\" alt=\"\" />
					</div>
					<div style=\"display: inline-block; margin-right: 50px; opacity: 0.6;\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/references/bpce.png\" alt=\"\" />
					</div>
					<div style=\"display: inline-block; margin-right: 50px; opacity: 0.6;\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/references/orlane.png\" alt=\"\" />
					</div>
					<div style=\"display: inline-block; opacity: 0.6;\">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/references/lafourchette.png\" alt=\"\" />
					</div>
				</div>
			</div>
			<div class=\"grey\">
				<div class=\"content\">
					<div class=\"left\">
						<h3>{$lang['mutu_title']}</h3>
						<p>{$lang['mutu_explain']}</p>
					</div>
					<div class=\"right\" style=\"text-align: center;\">
						<div class=\"terminal\">
							<div class=\"indicators\">
								<span class=\"circle\"></span>
								<span class=\"circle\"></span>
								<span class=\"circle\"></span>
							</div>
							<div class=\"terminal-text\">
								<a href='/hosting'><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/screen1.png\" alt=\"map\" style=\"display: block; padding: 5px 0 0 5px; width: 430px; margin: 0 auto;\" /></a>
							</div>
						</div>
					</div>
					<div class=\"clear\"></div><br /><br />		
					<div class=\"left\" style=\"text-align: center;\">
						<div class=\"terminal\">
							<div class=\"indicators\">
								<span class=\"circle\"></span>
								<span class=\"circle\"></span>
								<span class=\"circle\"></span>
							</div>
							<div class=\"terminal-text\">
								<a href='/paas'><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/screen2.png\" alt=\"map\" style=\"display: block; padding: 10px 0 0 10px;\" /></a>
							</div>
						</div>
					</div>
					<div class=\"right\">
						<h3>{$lang['paas_title']}</h3>
						<p>{$lang['paas_explain']}</p>
					</div>
					<div class=\"clear\"></div><br /><br />
				</div>
			</div>
			<div class=\"content\">
				<div style=\"text-align: center;\">
					<a class=\"button classic\" href=\"#\" onclick=\"$('#signup').dialog('open'); return false;\" style=\"height: 22px; width: 200px; margin: 0 auto;\">
						<span style=\"display: block; font-size: 18px; padding-top: 3px;\">{$lang['signup_now']}</span>
					</a>
					<p>{$lang['help']}</p>
					<br />
				</div>
			</div>
			<script>
				$(\"#stats\").html(\"<img src='/{$GLOBALS['CONFIG']['SITE']}/images/anim_loading_16x16.gif' />\");
				$(\"#stats\").load(\"/default/stats\");

				function showLogin()
				{
					if( $(\"#signupform\").css('display') != 'none' )
						$(\"#signupform\").css('display', 'none');
						
					var options = { direction: \"up\"};
					$(\"#loginform\").toggle(\"blind\", options, 200);
				}
				function showSignup()
				{
					if( $(\"#loginform\").css('display') != 'none' )
						$(\"#loginform\").css('display', 'none');
						
					var options = { direction: \"up\"};
					$(\"#signupform\").toggle(\"blind\", options, 200);
				}
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>