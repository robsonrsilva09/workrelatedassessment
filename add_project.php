<?php
session_start();
if (!isset($_SESSION['userName'])) { header("Location: login.php"); exit; }
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $userName = $_SESSION['userName'];
    $file_name = '';
    if (!empty($_FILES['file']['name'])) {
        $file_name = uniqid() . "_" . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $file_name);
    }
    $sql = "INSERT INTO projects (userName, title, description, file) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $userName, $title, $desc, $file_name);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <?php if (isset($_SESSION['userName'])): ?>
        <p style="text-align:center; color:#1abc9c; font-weight:bold;">
            Welcome, <?= htmlspecialchars($_SESSION['userName']) ?>!
        </p>
    <?php endif; ?>
    <h2>Add New Project</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Project Title" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="file" name="file"><br>
        <button type="submit" class="btn">Add Project</button>
    </form>
    <?php include 'footer.php'; ?>    
</body>
</html>

