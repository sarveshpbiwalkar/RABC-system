<?php
include 'db.php';

$user_id = $_POST['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$role_id = $_POST['role_id'];
$status = $_POST['status'];

$sql = "UPDATE users SET 
        username = '$username',
        email = '$email',
        role_id = $role_id,
        status = '$status'
        WHERE id = $user_id";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "User updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update user"]);
}
?>
