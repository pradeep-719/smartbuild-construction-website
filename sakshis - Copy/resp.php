<?php
session_start();

// --- DATABASE CONNECTION ---
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM admin WHERE Aemail='$email'";
$result = mysqli_query($conn, $query);
$profileImage = ($result && mysqli_num_rows($result) > 0)
    ? mysqli_fetch_assoc($result)['ProfileImage']
    : "";

$profileImageSrc = !empty($profileImage)
    ? $profileImage
    : "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$msg = "";
$showOtpForm = false;

// --- STEP 1: SEND OTP ---
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);
    $check = $conn->query("SELECT * FROM admin WHERE Aemail='$email'");
    if ($check->num_rows == 0) {
        $msg = "❌ Email not registered!";
    } else {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sakshishahu81@gmail.com';
            $mail->Password = 'lzttqvyfnxjxxgzq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('sakshishahu81@gmail.com', 'Buildsmart');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP for password reset is: <b>$otp</b>";

            $mail->send();
            $msg = "✅ OTP sent successfully to your email!";
            $showOtpForm = true;
        } catch (Exception $e) {
            $msg = "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

// --- STEP 2: VERIFY OTP & RESET PASSWORD ---
if (isset($_POST['verify_otp'])) {
    $enteredOtp = trim($_POST['otp']);
    $newPass = trim($_POST['new_password']);
    $confirmPass = trim($_POST['confirm_password']);
    $email = $_SESSION['email'] ?? '';

    if (!isset($_SESSION['otp'])) {
        $msg = "⚠️ Please send OTP again — session expired!";
        $showOtpForm = false;
    } elseif ($enteredOtp == $_SESSION['otp']) {
        if ($newPass != $confirmPass) {
            $msg = "❌ Passwords do not match!";
            $showOtpForm = true;
        } else {
            $result = $conn->query("SELECT Apassword FROM admin WHERE Aemail='$email'");
            if ($row = $result->fetch_assoc()) {
                $oldPassword = $row['Apassword'];
                if ($newPass === $oldPassword) {
                    $msg = "⚠️ New password cannot be same as old password!";
                    $showOtpForm = true;
                } else {
                    $conn->query("UPDATE admin SET Apassword='$newPass' WHERE Aemail='$email'");
                    $msg = "✅ Password reset successful!";
                    unset($_SESSION['otp']);
                    unset($_SESSION['email']);
                    $showOtpForm = false;
                }
            }
        }
    } else {
        $msg = "❌ Invalid OTP!";
        $showOtpForm = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Reset | SmartBuild Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
:root {
  --primary: #ff7b00;
  --secondary: #0b1f3b;
  --light-bg: #f6f9ff;
  --white: #fff;
}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{display:flex;background:var(--light-bg);min-height:100vh;}
/* SIDEBAR */
.sidebar{
  width:250px;background:var(--secondary);color:#fff;position:fixed;top:0;left:0;height:100%;
  display:flex;flex-direction:column;padding:30px 20px;
}
.sidebar h2{color:var(--primary);margin-bottom:30px;text-align:center;}
.sidebar a{color:#fff;text-decoration:none;padding:12px 15px;margin:6px 0;
  border-radius:8px;display:flex;align-items:center;gap:10px;font-weight:500;transition:0.3s;}
.sidebar a:hover,.sidebar a.active{background:var(--primary);}
.sidebar a.logout{margin-top:auto;}
/* MAIN */
.main{flex:1;margin-left:250px;padding:40px 30px;}
.header{
  background:var(--white);
  border-radius:14px;
  box-shadow:0 5px 15px var(--shadow);
  padding:15px 25px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:35px;
}
.header h1{color:var(--secondary);font-weight:700;font-size:1.4rem;}
.header img{width:45px;height:45px;border-radius:50%;border:2px solid var(--primary);object-fit:cover;}

/* Reset Box */
.reset-card{
  background:var(--white);
  border-radius:16px;
  box-shadow:0 8px 25px var(--shadow);
  max-width:460px;
  margin:auto;
  padding:35px;
  text-align:center;
}
.reset-card h2{
  color:var(--primary);
  font-weight:700;
  margin-bottom:15px;
}
.msg{
  background:#fff3e6;
  border-left:5px solid var(--primary);
  color:#333;
  padding:10px;
  border-radius:8px;
  margin-bottom:15px;
  font-size:0.9rem;
}
input[type="email"],input[type="text"],input[type="password"]{
  width:100%;
  padding:12px;
  border:1px solid #ccc;
  border-radius:8px;
  margin:8px 0;
  font-size:15px;
  transition:0.3s;
}
input:focus{border-color:var(--primary);box-shadow:0 0 5px rgba(230,126,0,0.3);outline:none;}
button{
  width:100%;
  background:var(--primary);
  color:#fff;
  border:none;
  padding:12px;
  border-radius:8px;
  font-weight:600;
  font-size:16px;
  margin-top:10px;
  cursor:pointer;
  transition:0.3s;
}
button:hover{background:#cc6e00;transform:scale(1.03);}
@media(max-width:900px){
  .sidebar{display:none;}
  .main{margin-left:0;padding:25px;}
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="admindash.php" ><i class='bx bx-grid-alt'></i> Profile</a>
  <a href="adform.php"><i class='bx bx-group'></i> Contractors</a>
  <a href="useer.php" ><i class='bx bx-user'></i> Users</a>
  <a href="addoc.php" ><i class='bx bx-file'></i> Documentation</a>
  <a href="resp.php"  class="active"><i class='bx bx-reset'></i> Pass Reset</a>
  <a href="pros.php" ><i class='bx bx-user-circle'></i> Profile</a>
  <a href="feed.php"><i class='bx bx-message-dots'></i> User Feedback</a>
  <a href="visitor.php"><i class='bx bx-file-find'></i> Acceptance Form</a>
  <a href="project.php"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php"><i class='bx bx-chat'></i> User Response</a>
  <a href="userlogouts.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- Main -->
<div class="main">
  <div class="header">
    <h1>🔒 Reset Password via OTP</h1>
    <img src="<?= $profileImageSrc ?>" alt="Profile Image">
  </div>

  <div class="reset-card">
    <h2>Reset Your Password</h2>
    <?php if ($msg): ?>
      <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php if (!$showOtpForm): ?>
      <form method="POST">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit" name="send_otp">Send OTP</button>
      </form>
    <?php else: ?>
      <form method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" name="verify_otp">Verify & Reset</button>
      </form>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
