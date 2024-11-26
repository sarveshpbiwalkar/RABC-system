<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$role_id = $_GET['id'];
$sql = "DELETE FROM roles WHERE id = $role_id";
if (mysqli_query($conn, $sql)) {
    header('Location: roles.php');
} else {
    echo "Error deleting role: " . mysqli_error($conn);
}
?>