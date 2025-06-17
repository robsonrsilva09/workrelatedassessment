<?php
include "db.php";

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $description = trim($_POST['description']);

    if ($name && $email && $description) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $description);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Could not submit your message - Try again.";
        }
    } else {
        $error = "Please all required fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="contact-page-wrapper">
        <h2>Contact Us</h2>
        <form method="POST" class="contact-form">
            <input type="text" name="name" placeholder="Your Name*" required><br>
            <input type="text" name="phone" placeholder="Phone"><br>
            <input type="email" name="email" placeholder="Email*" required><br>
            <textarea name="description" placeholder="Message / Description*" required></textarea><br>
            <button type="submit" class="btn">Send Message</button>
        </form>
        <?php if ($success): ?>
            <p style="color: green;">Message sent successfully!</p>
        <?php elseif ($error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
