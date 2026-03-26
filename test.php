<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
      .accordion {
        max-width: 600px;
        margin: auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .accordion-item {
        border-bottom: 1px solid #ddd;
    }

    .accordion-header {
        background: #007BFF;
        color: white;
        padding: 15px;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s ease;
    }

    .accordion-header:hover {
        background: #0056b3;
    }

    .accordion-header span {
        font-weight: bold;
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 15px;
        background: #f1f1f1;
    }

    .accordion-content p {
        margin: 15px 0;
    }

    .accordion-item.active .accordion-content {
        max-height: 200px; /* Adjust based on content */
        padding: 15px;
    }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        form { background: #fff; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #2195F2; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0EBBFF; }
        .error { color: red; }
        .success { color: #0EBBFF; }
    </style>
</head>
<body>

<h2>Support / FAQ / Contact Form</h2>
  <div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header">
            <span>How do I reset my password?</span>
            <strong>+</strong>
        </div>
        <div class="accordion-content">
            <p>To reset your password, go to the login page, click "Forgot Password", and follow the instructions sent to your email.</p>
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header">
            <span>What are the best browsers for using version 1.0?</span>
            <strong>+</strong>
        </div>
        <div class="accordion-content">
            <p>The platform works best on modern browsers like Microsoft Edge, Safari etc. Please make sure that you are using browsers that work with current operating systems for Windows, Mac and for Web.</p>
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header">
            <span>How do I contact customer support?</span>
            <strong>+</strong>
        </div>
        <div class="accordion-content">
            <p>You can contact our support team via the "Contact Us" form at this time.</p>
        </div>
    </div>
</div>
 <br><br><br/>
<form action="contact.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="message">Message:</label>
    <textarea name="message" rows="5" required></textarea>

    <button type="submit">Send</button>
</form>
<script>
    // Select all accordion headers
    const headers = document.querySelectorAll('.accordion-header');

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const isActive = item.classList.contains('active');

            // Close all items
            document.querySelectorAll('.accordion-item').forEach(i => i.classList.remove('active'));

            // Toggle current item
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
</script>
</body>
</html>

PHP (contact.php)

<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        echo "<p class='error'>All fields are required.</p>";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='error'>Invalid email format.</p>";
        exit;
    }

    // Email settings
    $to = "marketing@chopsueymedia.com"; // Change to your email
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "<p class='success'>Thank you, $name. Your message has been sent.</p>";
    } else {
        echo "<p class='error'>Sorry, your message could not be sent. Please try again later.</p>";
    }
} else {
    echo "<p class='error'>Invalid request.</p>";
}
?>
