<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower(trim($_POST['Email']));
    $password = trim($_POST['Password']);

    // Prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM admin WHERE LOWER(TRIM(Aemail)) = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['Apassword']) {
            $_SESSION['email'] = $user['Aemail'];
            header("Location: Admindash.php");
            exit();
        } else {
            echo "<script>
                alert('Incorrect password.');
                window.location.href = 'adminlogin.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('No user found with that email.');
            window.location.href = 'adminlogin.php';
        </script>";
        exit();
    }

    $stmt->close();
}
mysqli_close($conn);
?>
