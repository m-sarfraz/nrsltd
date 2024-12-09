<!-- Query to use  -->


<!-- CREATE DATABASE contact_form_db;

USE contact_form_db;

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->


<?php
// Database credentials
$host = 'localhost';
$db = 'contact_form_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_messages (full_name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullName, $email, $phone, $subject, $message);
    if ($stmt->execute()) {
        $response = "success";
    } else {
        $response = "error";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the form page with a response message
    header("Location: index.php?response=$response");
    exit;
} else {
    echo "Invalid request.";
}
?>
