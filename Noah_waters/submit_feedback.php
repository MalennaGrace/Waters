<?php
require 'config.php';

header('Content-Type: application/json');

// Function to validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if user has previous orders
function hasPreviousOrders($conn, $email, $user_id = null) {
    $sql = "SELECT COUNT(*) as order_count FROM orders WHERE ";
    $params = [];
    $types = "";
    
    if ($user_id) {
        $sql .= "user_id = ?";
        $params[] = $user_id;
        $types .= "i";
    } else {
        $sql .= "email = ?";
        $params[] = $email;
        $types .= "s";
    }
    
    $stmt = $conn->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['order_count'] > 0;
}

try {
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get and validate input
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';

    // Validate required fields
    if (empty($name)) {
        throw new Exception('Name is required');
    }
    if (empty($email)) {
        throw new Exception('Email is required');
    }
    if (!isValidEmail($email)) {
        throw new Exception('Invalid email format');
    }
    if ($rating < 1 || $rating > 5) {
        throw new Exception('Invalid rating value');
    }
    if (empty($message)) {
        throw new Exception('Message is required');
    }

    // Check if user is logged in
    session_start();
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Check if user has previous orders
    if (!hasPreviousOrders($conn, $email, $user_id)) {
        throw new Exception('Only customers with previous orders can submit feedback. Please make a purchase first.');
    }

    // Check if user has already submitted feedback
    $stmt = $conn->prepare("SELECT COUNT(*) as feedback_count FROM feedback WHERE email = ? OR (user_id IS NOT NULL AND user_id = ?)");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row['feedback_count'] > 0) {
        throw new Exception('You have already submitted feedback. Thank you for your input!');
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, rating, message, created_at, status, user_id) VALUES (?, ?, ?, ?, NOW(), 'approved', ?)");
    
    if (!$stmt) {
        throw new Exception('Database error: ' . $conn->error);
    }

    $stmt->bind_param("ssisi", $name, $email, $rating, $message, $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception('Error saving feedback: ' . $stmt->error);
    }

    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your feedback!'
    ]);

} catch (Exception $e) {
    // Error response
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    // Close statement and connection
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?> 