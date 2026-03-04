<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $delete = "DELETE FROM visit_form WHERE id=$id";
    if(mysqli_query($conn, $delete)){
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "No ID received";
}
?>
