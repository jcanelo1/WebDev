<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    // Validate fields
    if (empty($fullname) || empty($email) || empty($password) || empty($passwordRepeat)) {
        die("All fields are required.");
    }

    if ($password !== $passwordRepeat) {
        die("Passwords do not match.");
    }

    // Hash the password (you would save this to a DB in a real app)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $db = new DbConnect();
        $pdo = $db->connect();

        // Optional: check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM registration WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            die("Email already exists.");
        }

        // Insert into the database in mySQL
        $stmt = $pdo->prepare("INSERT INTO registration (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$fullname, $email, $hashedPassword]);

    // Store user data in the session
    $_SESSION['fullname'] = $fullname;
    $_SESSION['email'] = $email;

    // Redirect to a welcome page
    header("Location: welcome.php");
    exit();

    // Invalid access
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method not allowed.";
}
?>

