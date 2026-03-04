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

// --- DEFAULTS ---
$msg = "";
$showOtpForm = false;
$profileImageSrc = "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";

// --- SAFE FETCH PROFILE IMAGE (ONLY IF LOGGED IN) ---
$profileImage = "";
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT ProfileImage FROM usertab WHERE Uemail='$email'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $profileImage = $user_data['ProfileImage'];
    }
    if (!empty($profileImage)) {
        $profileImageSrc = $profileImage;
    }
}

// --- STEP 1: SEND OTP ---
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);

    $check = $conn->query("SELECT * FROM usertab WHERE Uemail='$email'");
    if ($check->num_rows == 0) {
        $msg = "❌ Email not registered!";
    } else {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email_reset'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sakshishahu81@gmail.com';   // Your Gmail
            $mail->Password = 'lzttqvyfnxjxxgzq';          // App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('sakshishahu81@gmail.com', 'SmartBuild');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'SmartBuild';
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
    $email = $_SESSION['email_reset'] ?? '';

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
                    $msg = "⚠️ New password cannot be same as old password!";
                    $showOtpForm = true;
                } else {
                    $conn->query("UPDATE usertab SET Upassword='$newPass' WHERE Uemail='$email'");
                    $msg = "✅ Password reset successful!";
                    unset($_SESSION['otp'], $_SESSION['email_reset']);
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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
<style>
  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
   
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .container {
    background: #fff;
    width: 400px;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: fadeIn 0.5s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  h2 {
    color: #0072ff;
    margin-bottom: 25px;
    font-weight: 700;
  }

  .msg {
    background: #f8f9fa;
    border-left: 5px solid #0072ff;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 14px;
  }

  input {
    width: 90%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    transition: 0.3s;
  }

  input:focus {
    border-color: #0072ff;
    box-shadow: 0 0 5px rgba(0,114,255,0.3);
    outline: none;
  }

  button {
    width: 90%;
    padding: 12px;
    background: linear-gradient(135deg, #0072ff, #00c6ff);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    margin-top: 10px;
    cursor: pointer;
    transition: 0.3s;
  }

  button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0,114,255,0.25);
  }

  p {
    margin-top: 15px;
    font-size: 0.9rem;
    color: #555;
  }

  p a {
    color: #0072ff;
    text-decoration: none;
    font-weight: 600;
  }

  p a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

  <div class="container">
    <h2>🔐 Reset User Password</h2>

    <?php if ($msg): ?>
      <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php if (!$showOtpForm): ?>
      <!-- STEP 1 -->
      <form method="POST">
        <input type="email" name="email" placeholder="Enter registered email" required>
        <button type="submit" name="send_otp">Send OTP</button>
      </form>
    <?php else: ?>
      <!-- STEP 2 -->
      <form method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" name="verify_otp">Verify & Reset</button>
      </form>
    <?php endif; ?>

    <p><a href="index.php">⬅ Back to Login</a></p>
  </div>

</body>
</html>
