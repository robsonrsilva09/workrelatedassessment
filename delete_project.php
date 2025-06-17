<?php
session_start();
if (!isset($_SESSION['userName'])) { header("Location: login.php"); exit; }
include "db.php";

$id = intval($_GET['id'] ?? 0);
$userName = $_SESSION['userName'];


$sql = "SELECT file FROM projects WHERE projectId=? AND userName=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $userName);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if ($project) {
    
    if (!empty($project['file']) && file_exists("uploads/" . $project['file'])) {
        unlink("uploads/" . $project['file']);
    }
    
    $sql = "DELETE FROM projects WHERE projectId=? AND userName=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $userName);
    $stmt->execute();
}
header("Location: dashboard.php");
exit;
?>

