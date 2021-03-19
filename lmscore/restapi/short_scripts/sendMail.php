<?php
require_once 'src/Mandrill.php'; //Not required with Composer
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
echo 'sending email';
$mandrill = new Mandrill('nBzzc7slBBQ5uEMAPWU50g');
echo 'mandrill library loaded';

$message = new stdClass();
$message->html = "html message";
$message->text = "text body";
$message->subject = "email subject";
$message->from_email = "nikhil.mishra@zinghr.com";
$message->from_name  = "From Name";
$message->to = array(array("email" => "n4niks@gmail.com"));
$message->track_opens = true;

$response = $mandrill->messages->send($message);
echo 'mail sent';
// $mandrill = new Mandrill('nBzzc7slBBQ5uEMAPWU50g');

// $template_name = 'activation';
//     $template_content = array(
//         array(
//             'name' => 'example name',
//             'content' => 'example content'
//         )
//     );
//     $message = array(
//         'html' => '<p>Example HTML content</p>',
//         'text' => 'Example text content',
//         'subject' => 'example subject',
//         'from_email' => 'n4niks@gmail.com',
//         'from_name' => 'Example Name',
//         'to' => array(
//             array(
//                 'email' => 'n4niks@gmail.com',
//                 'name' => 'Recipient Name',
//                 'type' => 'to'
//             )
//         ),
//         'headers' => array('Reply-To' => 'n4niks@gmail.com'),
//         'important' => false,
//         'track_opens' => null,
//         'track_clicks' => null,
//         'auto_text' => null,
//         'auto_html' => null,
//         'inline_css' => null,
//         'url_strip_qs' => null,
//         'preserve_recipients' => null,
//         'view_content_link' => null,
//         'bcc_address' => 'n4niks@gmail.com',
//         'tracking_domain' => null,
//         'signing_domain' => null,
//         'return_path_domain' => null,
//         'merge' => true,
//         'merge_language' => 'mailchimp',
//         'global_merge_vars' => array(
//             array(
//                 'name' => 'merge1',
//                 'content' => 'merge1 content'
//             )
//         ),
//         'merge_vars' => array(
//             array(
//                 'rcpt' => 'n4niks@gmail.com',
//                 'vars' => array(
//                     array(
//                         'name' => 'merge2',
//                         'content' => 'merge2 content'
//                     )
//                 )
//             )
//         )
//         'recipient_metadata' => array(
//             array(
//                 'rcpt' => 'n4niks@gmail.com',
//                 'values' => array('user_id' => 123456)
//             )
//         )
//     );
//     $async = false;
//     $ip_pool = 'Main Pool';
//     $send_at = 'example send_at';
//     $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
//     print_r($result);
    ?>