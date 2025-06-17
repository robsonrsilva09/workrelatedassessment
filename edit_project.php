<?php
session_start();
if (!isset($_SESSION['userName'])) { header("Location: login.php"); exit; }
include "db.php";

$id = intval($_GET['id'] ?? 0);
$userName = $_SESSION['userName'];


$sql = "SELECT * FROM projects WHERE projectId=? AND userName=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $userName);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    echo "Project not found or access denied.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $file_name = $project['file'];
    if (!empty($_FILES['file']['name'])) {
        $file_name = uniqid() . "_" . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $file_name);
    }
    $sql = "UPDATE projects SET title=?, description=?, file=? WHERE projectId=? AND userName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $title, $desc, $file_name, $id, $userName);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h2>Edit Project</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required><br>
        <textarea name="description" required><?= htmlspecialchars($project['description']) ?></textarea><br>
        <label>Current file: <?= htmlspecialchars($project['file']) ?></label><br>
        <input type="file" name="file"><br>
        <button type="submit">Update Project</button>
    </form>
    <a href="dashboard.php">Back</a>
</body>
</html>

