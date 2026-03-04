<?php
session_start();

if (isset($_POST['submit'])) {
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password']; // ⚠️ Raw password, not hashed

    $con = mysqli_connect('localhost', 'root', '', 'usersss');
    if (!$con) {
        die("❌ Could not connect: " . mysqli_connect_error());
    }

    $stmt = $con->prepare("INSERT INTO admin (AName, Aemail, Apassword) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $Name, $Email, $Password);

    if ($stmt->execute()) {
        // ✅ Set session here
        $_SESSION['email'] = $Email;

        // ✅ Redirect to dashboard
        header("Location: Admindash.php");
        exit();
    } else {
        echo "❌ Could not insert record: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($con);
} else {
    echo "⚠️ No form data submitted.";
}
?>