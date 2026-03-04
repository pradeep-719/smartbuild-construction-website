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
    $stmt = $conn->prepare("SELECT * FROM contractor WHERE LOWER(TRIM(Cemail)) = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['Cpassword']) {
            $_SESSION['email'] = $user['Cemail'];
            header("Location: dashboards.php");
            exit();
        } else {
            echo "<script>
                alert('Incorrect password.');
                window.location.href = 'registr.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('No user found with that email.');
            window.location.href = 'registr.php';
        </script>";
        exit();
    }

    $stmt->close();
}
mysqli_close($conn);
?>
