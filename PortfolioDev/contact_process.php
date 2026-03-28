<?php
require 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $inquiry_type = trim($_POST['subject'] ?? '');
    $price_range = trim($_POST['price_range'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($full_name) || empty($email) || empty($message)) {
        header('Location: contact.php?error=empty_fields');
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO contacts (full_name, email, inquiry_type, price_range, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $email, $inquiry_type, $price_range, $message]);

    // Fetch admin email to send notification
    $admin_stmt = $pdo->query("SELECT email FROM users ORDER BY id ASC LIMIT 1");
    $admin = $admin_stmt->fetch();
    
    if ($admin && !empty($admin['email'])) {
        $to = $admin['email'];
        $subject = "New Contact from " . $full_name . " - " . $inquiry_type;
        $email_body = "You have received a new contact inquiry from your portfolio website.\n\n"
                    . "Name: " . $full_name . "\n"
                    . "Email: " . $email . "\n"
                    . "Inquiry Type: " . $inquiry_type . "\n"
                    . "Budget: " . $price_range . "\n\n"
                    . "Message: \n" . $message . "\n";
                    
        $headers = "From: noreply@" . ($_SERVER['HTTP_HOST'] ?? 'josephlab.dev') . "\r\n"
                 . "Reply-To: " . $email . "\r\n"
                 . "X-Mailer: PHP/" . phpversion();
                 
        // Suppress errors with @ in case the environment (like local XAMPP) doesn't have an SMTP server configured
        @mail($to, $subject, $email_body, $headers);
    }

    header('Location: contact.php?success=1');
    exit;
}

header('Location: contact.php');
exit;
?>
