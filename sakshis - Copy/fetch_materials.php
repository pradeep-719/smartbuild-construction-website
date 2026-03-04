<?php
$conn = mysqli_connect("localhost", "root", "", "usersss");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM materials ORDER BY id DESC");
$materials = [];

while ($row = mysqli_fetch_assoc($result)) {
    $materials[] = $row;
}

header('Content-Type: application/json');
echo json_encode($materials);
?>
