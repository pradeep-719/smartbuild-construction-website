<?php
session_start();

// ✅ direct connection
$conn = mysqli_connect("localhost", "root", "", "usersss");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];
$contractor_id = $_POST['contractor_id'];
$status = $_POST['status']; // accept / reject

// insert or update
$sql = "INSERT INTO user_contractor_status (user_id, contractor_id, status,contractor_name)
        VALUES ('$user_id', '$contractor_id', '$status')
        ON DUPLICATE KEY UPDATE status='$status'";

if (mysqli_query($conn, $sql)) {
    header("Location: form.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
