<?php
session_start();

// check session
if (!isset($_SESSION['reset_email'])) {
    header("Location:respass.php");
    exit;
}

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "usersss";
$conn = new mysqli($servername, $username, $password, $database);

$messages = [];
$email = $_SESSION['reset_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new = trim($_POST['new_password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    if (!$new || !$confirm) {
        $messages[] = ['type'=>'error','text'=>'Please fill all fields.'];
    } elseif ($new !== $confirm) {
        $messages[] = ['type'=>'error','text'=>'Passwords do not match.'];
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usertab SET Upass=? WHERE Uemail=?");
        $stmt->bind_param("ss", $hash, $email);
        if ($stmt->execute()) {
            $messages[] = ['type'=>'success','text'=>'Password reset successful! You can now log in.'];
            unset($_SESSION['reset_email']);
            $conn->query("DELETE FROM password_resets WHERE email = '{$email}'");
        } else {
            $messages[] = ['type'=>'error','text'=>'Error updating password. Try again.'];
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Set New Password</title>
<style>
body{font-family:Arial,sans-serif;padding:20px;background:#fafafa;}
.form{max-width:420px;margin:0 auto;padding:20px;border-radius:8px;background:white;box-shadow:0 2px 10px rgba(0,0,0,.1);}
input,button{width:100%;padding:12px;margin:8px 0;box-sizing:border-box;border:1px solid #ccc;border-radius:4px;}
button{background:#ff9800;color:white;border:none;cursor:pointer;font-weight:bold;}
button:hover{background:#e68900;}
.success{background:#e6ffed;padding:10px;border:1px solid #b7f0c8;margin-bottom:10px;}
.error{background:#ffe6e6;padding:10px;border:1px solid #f0b7b7;margin-bottom:10px;}
</style>
</head>
<body>
<div class="form">
  <h2 style="text-align:center; color:#ff9800;">Set New Password</h2>

  <?php foreach($messages as $m): ?>
    <div class="<?= $m['type']==='success' ? 'success' : 'error' ?>">
      <?= htmlspecialchars($m['text']) ?>
    </div>
  <?php endforeach; ?>

  <form method="post" action="">
    <label>New Password</label>
    <input type="password" name="new_password" required placeholder="Enter new password">

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required placeholder="Re-enter new password">

    <button type="submit">Reset Password</button>
  </form>
</div>
</body>
</html>
