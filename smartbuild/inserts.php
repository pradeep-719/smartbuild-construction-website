<?php
session_start();

if (isset($_POST['submit'])) {
    $Name     = $_POST['UName'];
    $Email    = $_POST['Uemail'];
    $Password = $_POST['Upassword']; // plain password
    $Address  = $_POST['Address'];
    $Contact  = $_POST['Contact'];
    $Purpose  = $_POST['Purpose'];
    $DOB      = $_POST['DOB'];
    $Country  = $_POST['Country'];
    $State    = $_POST['State'];

    // ✅ Database connection
    $con = mysqli_connect('localhost', 'root', '', 'usersss');
    if (!$con) {
        die("❌ Could not connect: " . mysqli_connect_error());
    }

    // ✅ Prepare Insert Query
    $stmt = $con->prepare("INSERT INTO Usertab (UName, Uemail, Upassword, Address, Contact, Purpose, DOB, Country, State, createdate) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("sssssssss", $Name, $Email, $Password, $Address, $Contact, $Purpose, $DOB, $Country, $State);

    // ✅ Execute and handle result
    if ($stmt->execute()) {
        $_SESSION['email'] = $Email;
        echo "
        <script>
            alert('🎉 Registration Successful!');
            window.location.href = 'index.php';
        </script>
        ";
        exit();
    } else {
        echo "
        <script>
            alert('❌ Registration Failed: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>
        ";
    }

    $stmt->close();
    mysqli_close($con);

} else {
    echo "⚠️ No form data submitted.";
}
?>
