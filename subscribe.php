<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please provide a valid email.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@nadiaksis.com';
        $mail->Password   = 'vrjz wwmf kzsy ghtx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('info@nadiaksis.com', 'NADI Aksis Subscription');
        $mail->addAddress('info@nadiaksis.com');
        $mail->addReplyTo($email);

        $mail->isHTML(false);
        $mail->Subject = "New Newsletter Subscription";
        
        $email_content = "You have a new newsletter subscriber!\n\n";
        $email_content .= "Subscriber Email: $email\n";
        
        $mail->Body = $email_content;

        $mail->send();
        http_response_code(200);
        echo "Thank You! You have been subscribed.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Something went wrong.";
    }
} else {
    http_response_code(403);
    echo "Invalid request method.";
}
?>
