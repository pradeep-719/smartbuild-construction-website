<?php
// submit_visit.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usersss"; // change if needed

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

function safe($conn, $v){
    return htmlspecialchars(trim($conn->real_escape_string($v)));
}

$user_id = isset($_POST['user_id']) ? safe($conn, $_POST['user_id']) : '';
$contractor_id = isset($_POST['contractor_id']) ? safe($conn, $_POST['contractor_id']) : '';
$cost = isset($_POST['cost']) ? floatval($_POST['cost']) : 0;
$agree = isset($_POST['agree']) && in_array($_POST['agree'], ['yes','no']) ? $_POST['agree'] : 'no';
$contractor_upi = isset($_POST['contractor_upi']) ? safe($conn, $_POST['contractor_upi']) : null;

$errors = [];
if ($user_id === '' || $contractor_id === '') $errors[] = "Missing IDs.";
if ($cost <= 0) $errors[] = "Please enter valid cost.";
if ($agree === 'yes' && empty($contractor_upi)) $errors[] = "UPI ID required.";
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) $errors[] = "Upload a photo.";

$photo_path = "";
if (count($errors) === 0) {
    $uploadDir = __DIR__ . '/uploads';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $file = $_FILES['photo'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp'];
    if (!in_array(strtolower($ext), $allowed)) {
        $errors[] = "Only image files allowed.";
    } else {
        $newName = 'visit_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        $dest = $uploadDir . '/' . $newName;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $photo_path = 'uploads/' . $newName;
        } else {
            $errors[] = "Upload failed.";
        }
    }
}

if (count($errors) > 0) {
    echo "<script>alert('Error: " . implode("\\n", array_map('addslashes', $errors)) . "'); window.history.back();</script>";
    exit;
}

$stmt = $conn->prepare("INSERT INTO visits (user_id, contractor_id, cost, agree, contractor_upi, photo_path) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdsss", $user_id, $contractor_id, $cost, $agree, $contractor_upi, $photo_path);

if ($stmt->execute()) {
    echo "
    <html>
    <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
      body {font-family: Arial, sans-serif; background:#f7f7f7; display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}
      .popup {
        background:#28a745; color:white; padding:20px 30px; border-radius:10px;
        font-size:18px; box-shadow:0 6px 18px rgba(0,0,0,0.3);
        animation: fadeOut 4s forwards;
      }
      @keyframes fadeOut {
        0% {opacity:1;}
        80% {opacity:1;}
        100% {opacity:0; visibility:hidden;}
      }
    </style>
    </head>
    <body>
      <div class='popup'>Your form has been submitted successfully.<br>25% of your amount will be deducted after work completion.</div>
      <script>
        setTimeout(() => { window.location.href='contractor_visit.php'; }, 4000);
      </script>
    </body>
    </html>";
} else {
    echo "<script>alert('Database insert failed.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
