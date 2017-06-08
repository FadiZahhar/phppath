<?php
require_once '../../includes/config.php';

try {
    // prepare email message
    $message = Swift_Message::newInstance()
        ->setSubject('Swift Mailer Headers Test')
        ->setFrom($from)
        ->setTo($test1)
        ->setBody('This email was sent with highest priority and requests a receipt');

    // create the transport
    $transport = Swift_SmtpTransport::newInstance($smtp_server, 465, 'ssl')
        ->setUsername($username)
        ->setPassword($password);
    $mailer = Swift_Mailer::newInstance($transport);
    $result = $mailer->send($message);
    if ($result) {
        echo "Number of emails sent: $result";
    } else {
        echo "Couldn't send email";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}