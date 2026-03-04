<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = trim($_POST['AdminID']);
    $password = trim($_POST['Password']);

    // Fixed credentials
    $fixed_id = "admin001";
    $fixed_password = "admin123";

    if ($admin_id === $fixed_id && $password === $fixed_password) {
        $_SESSION['admin_id'] = $admin_id;  // Store admin id
       header("Location: /buildsmart-frontend/Admindash.php");  // ✅ correct relative path
        exit();
    } else {
        echo "<script>
            alert('❌ Invalid Admin ID or Password');
            window.location.href = 'adminlogin.php';
        </script>";
        exit();
    }
}
?>
