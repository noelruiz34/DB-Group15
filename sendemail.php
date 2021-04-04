<?php
$to = 'noelruiz34@gmail.com';
$subject = 'Marriage Proposal';
$message = 'Hi Jane, will you marry me?'; 
$from = 'pointofsale.group15@gmail.com';
$headers = array("From: from@example.com",
    "Reply-To: replyto@example.com",
    "X-Mailer: PHP/" . PHP_VERSION
);
 
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo 'Your mail has been sent successfully.';
} else{
    echo 'Unable to send email. Please try again.';
}
?>