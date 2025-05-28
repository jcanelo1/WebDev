<?php
session_start();
require_once 'db.php';

$db = new DbConnect();
$pdo = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    if (empty($fullname) || empty($email) || empty($password) || empty($passwordRepeat)) {
        die("All fields are required.");
    }

    if ($password !== $passwordRepeat) {
        die("Passwords do not match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check for existing email
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            die("Email already registered.");
        }

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $email, $hashedPassword]);

        // Store user info in session
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;

        header("Location: welcome.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    echo "Invalid request method.";
}
?>
