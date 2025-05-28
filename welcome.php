<?php
session_start();

if (!isset($_SESSION['fullname'])) {
    header("Location: LoginPage.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
    <p>You are signed in with <?php echo htmlspecialchars($_SESSION['email']); ?>.</p>
    <a href="logout.php">Log Out</a>
</body>
</html>
