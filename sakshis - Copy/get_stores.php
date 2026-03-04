<?php
header('Content-Type: application/json');

// Connect to database
$conn = new mysqli("localhost", "root", "", "store_locator");
if ($conn->connect_error) {
    die(json_encode([]));
}

// Get search query
$search = $_GET['search'] ?? '';
$search = $conn->real_escape_string($search);

// Fetch stores matching search
$sql = "SELECT * FROM stores WHERE name LIKE '%$search%' OR city LIKE '%$search%'";
$result = $conn->query($sql);

$stores = [];
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $stores[] = $row;
    }
}

// Return as JSON
echo json_encode($stores);
?>
