<?php
// Database connection settings
$host = 'localhost';
$dbname = 'jaircanelo_';            // Change if needed
$username = 'jair.canelo';        // Your MySQL username
$password = 'EK8GVB6F';           // Your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['response' => ['status' => 500, 'message' => 'Database connection failed.']]);
    exit;
}

// Handle JSON or regular POST
$input = json_decode(file_get_contents("php://input"), true);
$name = trim($input['name'] ?? $_POST['name'] ?? '');
$email = trim($input['email'] ?? $_POST['email'] ?? '');
$message = trim($input['message'] ?? $_POST['message'] ?? '');

// Validate
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['response' => ['status' => 400, 'message' => 'Please fill in all fields.']]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['response' => ['status' => 400, 'message' => 'Invalid email address.']]);
    exit;
}

try {
    // Save to DB
    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    echo json_encode(['response' => ['status' => 200, 'message' => 'Thank you, ' . htmlspecialchars($name) . '! Your message has been received.']]);
} catch (PDOException $e) {
    echo json_encode(['response' => ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()]]);
}
?>
