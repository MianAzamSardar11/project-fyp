<?php
// Include database configuration
include('admin/config.php');


header('Content-Type: application/json');
// Check the request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "type" => "danger",
        "message" => "Invalid request method. Please use POST."
    ]);
    exit;
}

// Retrieve and sanitize inputs
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode([
        "type" => "danger",
        "message" => "Please fill out all required fields."
    ]);
    exit;
}

// Prepare and execute the SQL query
$sql = "INSERT INTO users_messages (user_name, user_email, user_mobile, user_message) 
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($stmt->execute()) {
        echo json_encode([
            "type" => "success",
            "message" => "Message sent successfully!"
        ]);
    } else {
        echo json_encode([
            "type" => "danger",
            "message" => "Failed to send your message. Please try again."
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        "type" => "danger",
        "message" => "Database error: Unable to prepare the statement."
    ]);
}

$conn->close();
exit;
