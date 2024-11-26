<?php
include 'db.php';

$sql = "SELECT * FROM permissions";
$result = $conn->query($sql);

$permissions = [];
while ($row = $result->fetch_assoc()) {
    $permissions[] = $row;
}

echo json_encode($permissions);
?>
