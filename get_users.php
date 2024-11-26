<?php
include 'db.php';

$query = "SELECT users.id, username, email, status, roles.role_name 
          FROM users 
          LEFT JOIN roles ON users.role_id = roles.id";
$result = mysqli_query($conn, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);
?>
