<?php
include "db.php";
$sql = "SELECT projects.*, users.userName 
        FROM projects 
        JOIN users ON projects.userName = users.userName 
        ORDER BY projects.projectId DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Project Archive</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>Student Project Archive</h1>
    <h2>All Projects</h2>
    <h2>This website aims to post students' projects to measure their level of learning. Use it as a research source and remember not to plagiarize.</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="project">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <small>By: <?= htmlspecialchars($row['userName']) ?></small>
            <?php if ($row['file']): ?>
                <p><a href="uploads/<?= htmlspecialchars($row['file']) ?>" download>Download Attachment</a></p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
    <?php include 'footer.php'; ?>
</body>
</html>

