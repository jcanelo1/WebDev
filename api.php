<?php
require_once 'db.php';

class API {
    public $param;
    private $conn;

    public function __construct() {
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function registerUser() {
        // Validate required fields
        if (!isset($this->param['name']) || !isset($this->param['email'])) {
            echo json_encode(['response' => ['status' => 400, 'message' => 'Name and email are required']]);
            exit;
        }

        $name = trim($this->param['name']);
        $email = trim($this->param['email']);
        $password = trim($this->param['password']);

        // Check for empty values
        if (empty($name) || empty($email) || empty($password)) {
            echo json_encode(['response' => ['status' => 400, 'message' => 'Fields cannot be empty']]);
            exit;
        }

        try {
            // Check for existing email
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                echo json_encode(['response' => ['status' => 409, 'message' => 'Email already exists']]);
                return;
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // Insert user
            $stmt = $this->conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$name, $email]);

            echo json_encode(['response' => ['status' => 201, 'message' => 'User registered successfully']]);
        } catch (PDOException $e) {
            echo json_encode(['response' => ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()]]);
        }
    }
}
?>
