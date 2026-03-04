<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: adminlogin.php");
    exit();
}

$user_email = $_SESSION['email']; 
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $country = mysqli_real_escape_string($conn, $_POST['Country'] ?? '');
    $state = mysqli_real_escape_string($conn, $_POST['State'] ?? '');
    $gps_location = mysqli_real_escape_string($conn, $_POST['gps_location'] ?? '');

    $profileImagePath = '';
    $existingProfileImage = mysqli_real_escape_string($conn, $_POST['existing_profile_image'] ?? '');

    if (isset($_FILES['photo_upload']) && $_FILES['photo_upload']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "profile_uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $imageFileType = strtolower(pathinfo($_FILES["photo_upload"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid('profile_') . '.' . $imageFileType;
        $target_file = $target_dir . $newFileName;

        $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if ($_FILES["photo_upload"]["size"] <= 5 * 1024 * 1024) {
                if (move_uploaded_file($_FILES["photo_upload"]["tmp_name"], $target_file)) {
                    $profileImagePath = $target_file;
                    if (!empty($existingProfileImage) && file_exists($existingProfileImage) && $existingProfileImage !== $profileImagePath) {
                        unlink($existingProfileImage);
                    }
                } else $message .= "Error uploading new photo.<br>";
            } else $message .= "File too large (max 5MB).<br>";
        } else $message .= "Only JPG, JPEG, PNG, GIF allowed.<br>";
    } else $profileImagePath = $existingProfileImage;

    $stmt = $conn->prepare("UPDATE admin 
        SET AName=?, DOB=?, Purpose=?, Address=?, Contact=?, Country=?, State=?, ProfileImage=?, GPSLocation=? 
        WHERE Aemail=?");
    if ($stmt) {
        $stmt->bind_param("ssssssssss", $username, $dob, $purpose, $address, $phone_no, $country, $state, $profileImagePath, $gps_location, $user_email);
        if ($stmt->execute()) {
            $message = "✅ Profile updated successfully!";
            $_SESSION['username'] = $username;
        } else $message = "❌ Error updating profile: " . $stmt->error;
        $stmt->close();
    }
}

$user_data = [];
$stmt = $conn->prepare("SELECT AName, Aemail, Address, Contact, DOB, ProfileImage, Purpose, Country, State, GPSLocation, createdate FROM admin WHERE Aemail=?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) $user_data = $result->fetch_assoc();
else { session_destroy(); header("Location: adminlogin.php"); exit(); }
$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartBuild | Profile</title>
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
  background:var(--secondary);color:#fff;padding:20px 30px;border-radius:14px;
  display:flex;justify-content:space-between;align-items:center;box-shadow:0 4px 15px var(--shadow);
}
.header h1{font-size:1.6rem;font-weight:600;}
.header img{width:50px;height:50px;border-radius:50%;border:2px solid var(--primary);object-fit:cover;}

/* Profile Card */
.profile-card{
  background:var(--white);padding:40px;border-radius:20px;
  margin-top:30px;box-shadow:0 10px 30px var(--shadow);
}
.profile-card h2{
  color:var(--primary);text-align:center;margin-bottom:30px;font-size:1.5rem;font-weight:700;
}
.msg{
  background:#fff3e6;border-left:5px solid var(--primary);padding:10px 15px;
  border-radius:8px;color:#333;margin-bottom:15px;text-align:center;font-weight:500;
}

/* Form Layout */
form{
  display:flex;flex-wrap:wrap;justify-content:space-between;gap:40px;
}
.profile-img{
  flex:1 1 250px;text-align:center;
}
.profile-img img{
  width:160px;height:160px;border-radius:50%;object-fit:cover;
  box-shadow:0 0 0 4px var(--primary),0 0 0 8px #fff;margin-bottom:15px;
}
.upload-btn{
  background:var(--primary);color:white;padding:8px 16px;border:none;
  border-radius:6px;font-weight:600;cursor:pointer;transition:0.3s;
}
.upload-btn:hover{background:#e67e00;}

/* Inputs */
.inputs{
  flex:2 1 500px;
  display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;
}
.inputs label{font-weight:600;color:#444;margin-bottom:4px;}
.inputs input,.inputs textarea{
  width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;
  font-size:15px;transition:0.3s;
}
.inputs input:focus,.inputs textarea:focus{
  border-color:var(--primary);box-shadow:0 0 0 2px rgba(255,123,0,0.2);
}
textarea{resize:vertical;min-height:80px;}

/* Buttons */
.actions{
  grid-column:1/-1;display:flex;justify-content:center;gap:15px;margin-top:25px;
}
button{
  padding:12px 28px;border:none;border-radius:8px;font-weight:600;cursor:pointer;
  transition:0.3s;font-size:15px;
}
.update{background:var(--primary);color:#fff;}
.update:hover{background:#e67e00;}
.cancel{background:#6c757d;color:#fff;}
.cancel:hover{background:#5a6268;}

@media(max-width:900px){
  .sidebar{display:none;}
  .main{margin-left:0;padding:25px;}
  form{flex-direction:column;align-items:center;}
  .inputs{grid-template-columns:1fr;width:100%;}
}
</style>
</head>

<body>
<!-- Sidebar -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="admindash.php"><i class='bx bx-grid-alt'></i> Dashboard</a>
  <a href="adform.php"><i class='bx bx-user'></i> Contractors</a>
  <a href="useer.php"><i class='bx bx-group'></i> Users</a>
  <a href="addoc.php"><i class='bx bx-file'></i> Documentation</a>
  <a href="resp.php"><i class='bx bx-reset'></i> Pass Reset</a>
  <a href="pros.php" class="active"><i class='bx bx-user-circle'></i> Profile</a>
  <a href="feed.php"><i class='bx bx-message-dots'></i> Feedback</a>
  <a href="visitor.php"><i class='bx bx-file-find'></i> Acceptance</a>
  <a href="project.php"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php"><i class='bx bx-chat'></i> User Response</a>
  <a href="logs.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- Main -->
<div class="main">
  <div class="header">
    <h1><i class='bx bxs-user-circle'></i> Admin Profile</h1>
    <img src="<?= htmlspecialchars($user_data['ProfileImage'] ?? 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png'); ?>" alt="Profile">
  </div>

  <div class="profile-card">
    <h2>Update Your Details</h2>
    <?php if (!empty($message)): ?><p class="msg"><?= $message ?></p><?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="profile-img">
        <img id="profile-image" src="<?= htmlspecialchars($user_data['ProfileImage'] ?? 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png'); ?>" alt="Profile">
        <input type="hidden" name="existing_profile_image" value="<?= htmlspecialchars($user_data['ProfileImage']); ?>">
        <label for="photo-upload" class="upload-btn">Upload New</label>
        <input type="file" id="photo-upload" name="photo_upload" accept="image/*" style="display:none;">
      </div>

      <div class="inputs">
        <div><label>Username</label><input type="text" name="username" value="<?= htmlspecialchars($user_data['AName']); ?>"></div>
        <div><label>DOB</label><input type="date" name="dob" value="<?= htmlspecialchars($user_data['DOB']); ?>"></div>
        <div><label>Purpose</label><input type="text" name="purpose" value="<?= htmlspecialchars($user_data['Purpose']); ?>"></div>
        <div><label>Address</label><textarea name="address"><?= htmlspecialchars($user_data['Address']); ?></textarea></div>
        <div><label>Email</label><input type="email" value="<?= htmlspecialchars($user_data['Aemail']); ?>" readonly></div>
        <div><label>Phone</label><input type="tel" name="phone_no" value="<?= htmlspecialchars($user_data['Contact']); ?>"></div>
        <div><label>Country</label><input type="text" name="Country" value="<?= htmlspecialchars($user_data['Country']); ?>"></div>
        <div><label>State</label><input type="text" name="State" value="<?= htmlspecialchars($user_data['State']); ?>"></div>

        <div class="actions">
          <button type="submit" class="update">Update</button>
          <button type="button" class="cancel" onclick="window.location.href='admindash.php'">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
const photoUpload=document.getElementById('photo-upload');
const profileImage=document.getElementById('profile-image');
photoUpload.addEventListener('change',e=>{
  const file=e.target.files[0];
  if(file){
    const reader=new FileReader();
    reader.onload=()=>profileImage.src=reader.result;
    reader.readAsDataURL(file);
  }
});
if(navigator.geolocation){
  navigator.geolocation.getCurrentPosition(pos=>{
    document.getElementById('latitude').value=pos.coords.latitude;
    document.getElementById('longitude').value=pos.coords.longitude;
  });
}
</script>
</body>
</html>
