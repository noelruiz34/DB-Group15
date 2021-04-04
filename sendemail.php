<?php
    $to      = 'noelruiz34@gmail.com';
    $subject = 'Testing';
    $message = 'Testing testing';
    $headers = 'From: webmaster@example.com'       . "\r\n" .
                 'Reply-To: webmaster@example.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
?>