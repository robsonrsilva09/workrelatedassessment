<?php
session_start();
if (!isset($_SESSION['userName'])) {
    header("Location: login.php");
    exit;
}
include "db.php";
$userName = $_SESSION['userName'];


$sql = "SELECT * FROM projects WHERE userName=? ORDER BY projectId DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();
$projects = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - My Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <?php if (isset($_SESSION['userName'])): ?>
        <p style="text-align:center; color:#1abc9c; font-weight:bold;">
            Welcome, <?= htmlspecialchars($_SESSION['userName']) ?>!
        </p>
    <?php endif; ?>
    <h1>My Projects</h1>
    <h1>Please note that your project will be visible to any user of the website. The files can also be downloaded</h1> 
    <div class="dashboard-actions">
        <a href="add_project.php" class="btn">Add New Project</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <?php while ($row = $projects->fetch_assoc()): ?>
        <div class="project">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <?php if ($row['file']): ?>
                <p><a href="uploads/<?= htmlspecialchars($row['file']) ?>" download>Download Attachment</a></p>
            <?php endif; ?>
            <a href="edit_project.php?id=<?= $row['projectId'] ?>">Edit</a> | 
            <a href="delete_project.php?id=<?= $row['projectId'] ?>" onclick="return confirm('Delete this project?');">Delete</a>
        </div>
    <?php endwhile; ?>
    <?php include 'footer.php'; ?>
    
</body>
</html>


