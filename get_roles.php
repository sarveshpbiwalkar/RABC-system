<?php
include 'db.php';

$query = "SELECT * FROM roles";
$result = mysqli_query($conn, $query);

$roles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $roles[] = $row;
}

echo json_encode($roles);
?>
