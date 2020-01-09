<?php
require_once('../vendor/autoload.php');

function sendEmail($clientEmail, $link) {
  // Create the Transport
  $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
    ->setUsername('test.eon.ro@gmail.com')
    ->setPassword('Passwordeon123');

  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);

  // Create a message
  $message = (new Swift_Message('Wonderful Subject'))
    ->setContentType("text/html")
    ->setFrom(['recorder@recorder.com' => 'Recorder'])
    ->setTo([$clientEmail])
    ->setBody('V-ati abonat cu succes!<br/>Pentru a va dezabona, accesati link-ul de mai jos.<br/>' . $link);

  // Send the message
  return $mailer->send($message);
}