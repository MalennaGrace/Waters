<?php
require 'config.php';

header('Content-Type: application/json');

try {
    // Get approved feedback
    $sql = "SELECT name, rating, message, created_at 
            FROM feedback 
            WHERE status = 'approved' 
            ORDER BY created_at DESC 
            LIMIT 10";
            
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception('Database error: ' . $conn->error);
    }

    $feedback = [];
    while ($row = $result->fetch_assoc()) {
        $feedback[] = [
            'name' => htmlspecialchars($row['name']),
            'rating' => (int)$row['rating'],
            'message' => htmlspecialchars($row['message']),
            'date' => date('F j, Y', strtotime($row['created_at']))
        ];
    }

    echo json_encode([
        'success' => true,
        'feedback' => $feedback
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 