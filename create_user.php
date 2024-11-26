<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit;
}

// Initialize variables for form input
$username = '';
$email = '';
$password = '';
$role_id = '';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role_id'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $role_id = $_POST['role_id'];

        // Check if the email already exists
        $checkEmailStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $checkEmailStmt->store_result();

        if ($checkEmailStmt->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email already in use."]);
        } else {
            // Prepare the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $username, $email, $password, $role_id); // "sssi" means string, string, string, integer

            // Execute the statement and check for success
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "User  created successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error creating user: " . $stmt->error]);
            }

            // Close the statement
            $stmt->close();
        }

        // Close the check email statement
        $checkEmailStmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Required fields are missing."]);
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Create User</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role ID</label>
                <input type="number" class="form-control" id="role_id" name="role_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="roles.php" class="btn btn-secondary">Cancel</a> <!-- Redirect to users page -->
        </form>
    </div>
</body>
</html>