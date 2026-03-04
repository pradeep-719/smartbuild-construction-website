<?php
session_start();

// --- DATABASE CONNECTION ---
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// --- PHPMailer (via Composer) ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$msg = "";
$showOtpForm = false;

$contractor_email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM contractor WHERE Cemail='$contractor_email'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $profileImage = $user_data['ProfileImage'];
} else {
    $profileImage = "";
}
$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

// --- STEP 1: SEND OTP ---
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);
    $check = $conn->query("SELECT * FROM contractor WHERE Cemail='$email'");
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
            $result = $conn->query("SELECT Cpassword FROM contractor WHERE Cemail='$email'");
            if ($row = $result->fetch_assoc()) {
                $oldPassword = $row['Cpassword'];
                if ($newPass === $oldPassword) {
                    $msg = "⚠️ New password cannot be same as old password!";
                    $showOtpForm = true;
                } else {
                    $conn->query("UPDATE contractor SET Cpassword='$newPass' WHERE Cemail='$email'");
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
<title>SmartBuild | Password Reset</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
    --primary-color: #ff6b4a;
    --secondary-color: #2c3e50;
    --light-gray: #f4f7f6;
    --white: #ffffff;
}

/* BASE */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:var(--light-gray);color:#333;overflow-x:hidden;}

/* SIDEBAR */
.sidebar{
  width:250px;height:100vh;background:var(--secondary-color);
  color:white;position:fixed;top:0;left:0;padding:30px 20px;
  display:flex;flex-direction:column;z-index:1001;
  transition:transform 0.3s ease;
}
.sidebar h2{color:var(--primary-color);font-size:24px;margin-bottom:30px;}
.sidebar a{
  color:white;text-decoration:none;display:flex;align-items:center;
  gap:10px;padding:12px 10px;margin-bottom:8px;border-radius:6px;transition:0.3s;
}
.sidebar a:hover,.sidebar a.active{background:var(--primary-color);}
.sidebar a.logout{margin-top:auto;}

/* OVERLAY */
.overlay{
  display:none;position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.4);z-index:1000;
}
.overlay.show{display:block;}

/* TOPBAR */
.topbar{
  position:fixed;top:0;left:250px;width:calc(100% - 250px);
  height:60px;background:var(--white);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);
  z-index:900;transition:left 0.3s ease,width 0.3s ease;
}
.topbar h1{font-size:1.2rem;color:var(--secondary-color);font-weight:700;}
#menu-toggle{
  background:none;border:none;font-size:1.6rem;
  color:var(--secondary-color);cursor:pointer;display:none;
}

/* MAIN */
.main{
  padding:100px 30px;margin-left:250px;display:flex;justify-content:center;align-items:center;
  transition:margin-left 0.3s ease;
}

/* RESET BOX */
.reset-box{
  background:var(--white);border-radius:14px;
  box-shadow:0 5px 20px rgba(0,0,0,0.1);
  padding:40px 35px;width:100%;max-width:420px;text-align:center;
}
.reset-box h2{color:var(--primary-color);margin-bottom:20px;font-size:1.6rem;}
.msg{
  background:#f9f9f9;border-left:5px solid var(--primary-color);
  padding:10px 15px;margin-bottom:15px;border-radius:6px;text-align:left;
}
input[type=email],input[type=text],input[type=password]{
  width:100%;padding:12px;margin:8px 0;border:1.5px solid #ddd;border-radius:8px;font-size:0.95rem;
}
input:focus{border-color:var(--primary-color);outline:none;}
button{
  width:100%;padding:12px;border:none;background:var(--primary-color);
  color:white;border-radius:8px;font-size:1rem;font-weight:600;margin-top:10px;
  cursor:pointer;transition:background 0.3s;
}
button:hover{background:#e65a3c;}

/* RESPONSIVE */
@media(max-width:900px){
  #menu-toggle{display:block;}
  .sidebar{transform:translateX(-100%);}
  .sidebar.open{transform:translateX(0);}
  .overlay.show{display:block;}
  .topbar{left:0;width:100%;}
  .main{margin-left:0;padding:90px 20px;}
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h2>SmartBuild</h2>
    <a href="dashboards.php"><i class="fa-solid fa-chart-line"></i> Profile</a>
    <a href="response.php"><i class="fa-solid fa-comments"></i> User Response</a>
    <a href="upload.php"><i class="fa-solid fa-upload"></i> Upload Daily Status</a>
    <a href="docu.php"><i class="fa-solid fa-file-lines"></i> Documentation</a>
    <a href="conres.php" class="active"><i class="fa-solid fa-key"></i> Pass Reset</a>
    <a href="pro.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
    <a href="feedview.php"><i class="fa-solid fa-message"></i> Feedback View</a>
    <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay" id="overlay"></div>

<!-- TOPBAR -->
<div class="topbar">
  <h1>🔐 Contractor Password Reset</h1>
  <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
</div>

<!-- MAIN -->
<div class="main">
  <div class="reset-box">
    <h2><i class="fa-solid fa-lock"></i> Reset Password</h2>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php if (!$showOtpForm): ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your registered email" required>
            <button type="submit" name="send_otp"><i class="fa-solid fa-paper-plane"></i> Send OTP</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="verify_otp"><i class="fa-solid fa-check"></i> Verify & Reset</button>
        </form>
    <?php endif; ?>
  </div>
</div>

<script>
const sidebar=document.getElementById("sidebar");
const overlay=document.getElementById("overlay");
const menuToggle=document.getElementById("menu-toggle");

menuToggle.addEventListener("click",()=>{
    sidebar.classList.toggle("open");
    overlay.classList.toggle("show");
});
overlay.addEventListener("click",()=>{
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
});
</script>

</body>
</html>
