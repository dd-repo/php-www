<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$message = "
Name: {$_POST['name']}
Email: {$_POST['email']}
Société: {$_POST['company']}
Téléphone: {$_POST['phone']}
Subjet: {$_POST['subject']}

Message: {$_POST['message']}
";

mail("contact@anotherservice.com", "[AS] {$_POST['subject']}", $message, "From: {$_POST['email']}");

$message = "{$lang['success']}

<!-- Google Code for Envoi d&#39;un email Conversion Page -->
<script type=\"text/javascript\">
/* <![CDATA[ */
var google_conversion_id = 998104197;
var google_conversion_language = \"en\";
var google_conversion_format = \"3\";
var google_conversion_color = \"ffffff\";
var google_conversion_label = \"Bvm0CJv26AMQhbn32wM\";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type=\"text/javascript\" src=\"https://www.googleadservices.com/pagead/conversion.js\">
</script>
<noscript>
<div style=\"display:inline;\">
<img height=\"1\" width=\"1\" style=\"border-style:none;\" alt=\"\" src=\"https://www.googleadservices.com/pagead/conversion/998104197/?value=0&amp;label=Bvm0CJv26AMQhbn32wM&amp;guid=ON&amp;script=0\"/>
</div>
</noscript>";

$_SESSION['MESSAGE']['TYPE'] = 'success';
$_SESSION['MESSAGE']['TEXT']= $message;
			
template::redirect('/about/contact');

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>