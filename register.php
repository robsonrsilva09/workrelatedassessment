<?php
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = trim($_POST['userName']);
    $password = $_POST['password'];

    
    if (strlen($userName) < 3 || strlen($password) < 4) {
        $error = "Username and password are too short.";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE userName=?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        } else {
           
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (userName, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $userName, $hash);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Registration failed!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Project Archive</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="userName" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <div class="register-actions">
        <a href="login.php" class="btn">Already have an account? Login here</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>


