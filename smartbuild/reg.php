<?php
session_start();

if (isset($_POST['submit'])) {
    // Collect form data
    $Name     = $_POST['CName'];
    $Email    = $_POST['Cemail'];
    $Password = $_POST['Cpassword']; // plain password
    $Address  = $_POST['Address'];
    $Contact  = $_POST['Contact'];
    $Purpose  = $_POST['Purpose'];
    $DOB      = $_POST['DOB'];
    $Country  = $_POST['Country'];
    $State    = $_POST['State'];

    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'usersss');
    if (!$con) {
        die("❌ Could not connect: " . mysqli_connect_error());
    }

    // Prepare SQL Query (excluding ProfileImage)
    $stmt = $con->prepare("INSERT INTO contractor (CName, Cemail, Cpassword, Address, Contact, Purpose, DOB, Country, State, createDate) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssssss", $Name, $Email, $Password, $Address, $Contact, $Purpose, $DOB, $Country, $State);

    // Execute and check
    if ($stmt->execute()) {
        $_SESSION['email'] = $Email;

        echo "
        <script>
            alert('🎉 Registration Successful! Welcome to SmartBuild Contractor Panel.');
            window.location.href = 'registr.php';
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
