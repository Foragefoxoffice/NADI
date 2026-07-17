<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize the form fields.
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $name = str_replace(["\r", "\n"], [" ", " "], $name);
    
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject_input = strip_tags(trim($_POST["subject"] ?? 'General Inquiry'));
    $message = strip_tags(trim($_POST["message"] ?? ''));
    
    // Additional fields for contact-us.html
    $company = strip_tags(trim($_POST["company"] ?? 'N/A'));
    $phone = strip_tags(trim($_POST["phone"] ?? 'N/A'));
    $location = strip_tags(trim($_POST["location"] ?? 'N/A'));

    // Validate required fields.
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and provide a valid email.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'info@nadiaksis.com';                   // SMTP username
        $mail->Password   = 'vrjz wwmf kzsy ghtx';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
        $mail->Port       = 465;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('info@nadiaksis.com', 'NADI Aksis Contact Form');
        $mail->addAddress('info@nadiaksis.com');                    // Add a recipient (where emails are sent)
        $mail->addReplyTo($email, $name);                           // Set the reply-to to the sender's email

        // Content
        $mail->isHTML(false);                                       // Set email format to plain text
        $mail->Subject = "New Message: $subject_input";
        
        $email_content = "You have received a new message from your website contact form.\n\n";
        $email_content .= "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Company: $company\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Location: $location\n\n";
        $email_content .= "Subject: $subject_input\n\n";
        $email_content .= "Message:\n$message\n";
        
        $mail->Body    = $email_content;

        $mail->send();
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Not a POST request.
    http_response_code(403);
    echo "Invalid request method.";
}
?>
