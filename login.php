<?php
session_start();
require_once 'db.php';

// Connect to the database
$db = new DbConnect();
$pdo = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['response' => ['status' => 400, 'message' => 'Please fill in both fields.']]);
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT fullname, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            echo json_encode(['response' => ['status' => 200, 'message' => 'Login successful']]);
        } else {
            echo json_encode(['response' => ['status' => 401, 'message' => 'Invalid email or password']]);
        }
    } catch (PDOException $e) {
        echo json_encode(['response' => ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()]]);
    }
} else {
    echo json_encode(['response' => ['status' => 405, 'message' => 'Invalid request method.']]);
}
?>