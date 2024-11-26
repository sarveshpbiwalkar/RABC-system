<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['role_name']) && !empty($_POST['role_name'])) {
        $role_name = $_POST['role_name'];

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO roles (role_name) VALUES (?)");
        $stmt->bind_param("s", $role_name); // "s" means the parameter is a string

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Role added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error adding role: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Role name is required"]);
    }
}

$conn->close();
?>