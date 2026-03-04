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
$user_row = null;

$email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM usertab WHERE Uemail='$email'";
$result = mysqli_query($conn, $query);
$profileImage = "";

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $profileImage = $user_data['ProfileImage'];
}

$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

// --- STEP 1: SEND OTP ---
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);
    $check = $conn->query("SELECT * FROM usertab WHERE Uemail='$email'");

    if ($check->num_rows == 0) {
        $msg = "❌ Email not registered!";
    } else {
        $user_row = $check->fetch_assoc();
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

            $mail->setFrom('sakshishahu81@gmail.com', 'SmartBuild');
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
    } elseif ($enteredOtp == $_SESSION['otp']) {
        if ($newPass != $confirmPass) {
            $msg = "❌ Passwords do not match!";
            $showOtpForm = true;
        } else {
            $result = $conn->query("SELECT Upassword FROM usertab WHERE Uemail='$email'");
            if ($row = $result->fetch_assoc()) {
                if ($newPass === $row['Upassword']) {
                    $msg = "⚠️ New password cannot be same as the old password!";
                    $showOtpForm = true;
                } else {
                    $conn->query("UPDATE usertab SET Upassword='$newPass' WHERE Uemail='$email'");
                    $msg = "✅ Password reset successful!";
                    unset($_SESSION['otp'], $_SESSION['email'], $_SESSION['user_row']);
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
<title>Password Reset | SmartBuild</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
/* === Modern SmartBuild Theme (Based on Driver Page) === */
:root {
  --primary-color: #0a4d68;
  --secondary-color: #ff6b6b;
  --gradient-start: #0a4d68;
  --gradient-end: #1a7fa3;
  --bg-page: #f4f7f6;
  --bg-surface: #ffffff;
  --bg-inset: #f0f4f3;
  --text-primary: #1a202c;
  --text-secondary: #555;
  --border-color: #e2e8f0;
  --shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
  --sidebar-bg: #1e293b;
  --sidebar-text: #cbd5e1;
  --sidebar-text-hover: #fff;
  --sidebar-bg-hover: #334155;
  --sidebar-active: var(--secondary-color);
}
html[data-theme="dark"] {
  --primary-color: #1a7fa3;
  --bg-page: #121212;
  --bg-surface: #1e1e1e;
  --bg-inset: #2c2c2c;
  --text-primary: #e0e0e0;
  --text-secondary: #a0a0a0;
  --border-color: #3a3a3a;
  --sidebar-bg: #1a1a1a;
  --sidebar-text: #a0a0a0;
  --sidebar-bg-hover: #2c2c2c;
}
*{margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;transition:background-color .3s,color .3s,border-color .3s;}
body{background:var(--bg-page);color:var(--text-primary);}
.dashboard-container{display:flex;min-height:100vh;}
.sidebar{
  width:250px;flex-shrink:0;background:var(--sidebar-bg);
  color:var(--sidebar-text);padding:1.5rem;display:flex;flex-direction:column;
}
.sidebar-header{font-size:1.6rem;font-weight:700;color:#fff;margin-bottom:2rem;display:flex;align-items:center;gap:.75rem;}
.sidebar-nav a{
  display:flex;align-items:center;gap:.75rem;color:var(--sidebar-text);
  text-decoration:none;padding:.8rem 1rem;margin-bottom:.5rem;border-radius:8px;
}
.sidebar-nav a:hover{background:var(--sidebar-bg-hover);color:#fff;}
.sidebar-nav a.active{background:var(--sidebar-active);color:#fff;}
.sidebar-nav i{width:22px;text-align:center;}
.sidebar-nav .logout{margin-top:auto;}
.main-content{flex-grow:1;padding:2rem;overflow-y:auto;}
.main-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;}
.main-header h1{font-size:2rem;font-weight:700;}
#menu-toggle{display:none;background:none;border:none;font-size:1.5rem;color:var(--text-primary);}
.header-controls{display:flex;align-items:center;gap:1rem;}
.theme-switch{position:relative;width:50px;height:26px;}
.theme-switch input{opacity:0;width:0;height:0;}
.slider{position:absolute;top:0;left:0;right:0;bottom:0;background:#ccc;border-radius:26px;cursor:pointer;transition:.3s;}
.slider:before{content:"";position:absolute;height:20px;width:20px;left:4px;bottom:3px;background:white;border-radius:50%;transition:.3s;}
input:checked + .slider{background:var(--primary-color);}
input:checked + .slider:before{transform:translateX(22px);}
.slider .fa-sun,.slider .fa-moon{position:absolute;top:50%;transform:translateY(-50%);font-size:13px;color:#fff;}
.slider .fa-sun{left:6px;}
.slider .fa-moon{right:6px;opacity:0;}
input:checked + .slider .fa-sun{opacity:0;}
input:checked + .slider .fa-moon{opacity:1;}

/* === RESET FORM CARD === */
.container {
  background:#fff;border-radius:14px;box-shadow:var(--shadow);
  max-width:420px;margin:auto;padding:35px 25px;
  text-align:center;
}
.container h2 {color:var(--primary);margin-bottom:20px;}
.msg {
  background:#f3f9ff;border-left:5px solid var(--primary);
  padding:10px;margin-bottom:15px;border-radius:8px;
  font-size:14px;color:#333;
}
input[type="email"],input[type="text"],input[type="password"] {
  width:90%;padding:12px;margin:8px 0;border:1px solid #ccc;
  border-radius:6px;outline:none;font-size:15px;
  transition:all .3s;
}
input:focus {border-color:var(--primary);box-shadow:0 0 0 2px rgba(10,77,104,0.15);}
button {
  width:90%;padding:12px;margin-top:12px;border:none;border-radius:8px;
  background: #0a4d68;
  color:#fff;font-weight:600;cursor:pointer;transition:0.3s;
}
button:hover {background:#0a4d68;}
.dp img {width:45px;height:45px;border-radius:50%;object-fit:cover;border:2px solid var(--primary);}
/* --- RESPONSIVE --- */
@media(max-width:768px){
  .sidebar{position:fixed;left:-100%;top:0;z-index:1000;transition:all .3s;}
  .sidebar.open{left:0;}
  #menu-toggle{display:block;}
  .main-content{margin-left:0;}
  .profile-header img{width:100px;height:100px;}
  .details-grid{grid-template-columns:1fr;}
}
</style>
</head>

<body>
<div class="dashboard-container">
  <aside class="sidebar">
    <div class="sidebar-header"><i class="fa-solid fa-user"></i>Customer</div>
    <nav class="sidebar-nav">
      <a href="dashboard.php"><i class="fa-solid fa-gauge"></i>Profile</a>
      <a href="form.php" ><i class="fa-solid fa-briefcase"></i>Contractors</a>
      <a href="track.php"><i class="fa-solid fa-map-location-dot"></i>Track</a>
      <a href="userfroms.php"><i class="fa-solid fa-file"></i>Docs</a>
      <a href="respass.php" class="active"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i>Edit Profile</a>
              <a href="feedback.php"><i class="fa-solid fa-comment-dots"></i>Feedback</a>

      <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <h1>Customer Profile</h1>
      <div class="header-controls">
        <!-- THEME TOGGLE -->
        <label class="theme-switch">
          <input type="checkbox" id="theme-toggle">
          <span class="slider">
            <i class="fa-solid fa-sun"></i>
            <i class="fa-solid fa-moon"></i>
          </span>
        </label>
        <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
      </div>
    </header>

    <div class="container">
      <h2>Reset Your Password</h2>

      <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
      <?php endif; ?>

      <?php if (!$showOtpForm): ?>
        <!-- STEP 1 -->
        <form method="POST">
          <input type="email" name="email" placeholder="Enter your registered email" required>
          <button type="submit" name="send_otp"><i class="fa-solid fa-paper-plane"></i> Send OTP</button>
        </form>
      <?php else: ?>
        <!-- STEP 2 -->
        <form method="POST">
          <input type="text" name="otp" placeholder="Enter OTP" required>
          <input type="password" name="new_password" placeholder="New Password" required>
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
          <button type="submit" name="verify_otp"><i class="fa-solid fa-check"></i> Verify & Reset</button>
        </form>
      <?php endif; ?>
    </div>
  </main>
</div>

<script>
const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.querySelector(".sidebar");
const themeToggle = document.getElementById("theme-toggle");

// Sidebar toggle for mobile
menuToggle.addEventListener("click",()=>{sidebar.classList.toggle("open");});

// Theme toggle with localStorage
document.addEventListener("DOMContentLoaded",()=>{
  const currentTheme = localStorage.getItem("theme");
  if(currentTheme==="dark"){document.documentElement.setAttribute("data-theme","dark");themeToggle.checked=true;}
});
themeToggle.addEventListener("change",(e)=>{
  if(e.target.checked){document.documentElement.setAttribute("data-theme","dark");localStorage.setItem("theme","dark");}
  else{document.documentElement.setAttribute("data-theme","light");localStorage.setItem("theme","light");}
});
</script>
</body>
</html>
