<?php
session_start();

if (isset($_SESSION['fullname']) && isset($_SESSION['email'])) {
    echo json_encode([
        'fullname' => $_SESSION['fullname'],
        'email' => $_SESSION['email']
    ]);
} else {
    echo json_encode([
        'error' => 'User not logged in'
    ]);
}
?>
