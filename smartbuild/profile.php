<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['email']; 
$message = '';

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $country = mysqli_real_escape_string($conn, $_POST['Country'] ?? '');
    $state = mysqli_real_escape_string($conn, $_POST['State'] ?? '');
    $gps_location = mysqli_real_escape_string($conn, $_POST['gps_location'] ?? '');

    // Profile image handling
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
    } else {
        $profileImagePath = $existingProfileImage;
    }

    // Update with GPS location
    $stmt = $conn->prepare("UPDATE usertab 
        SET UName = ?, DOB = ?, Purpose = ?, Address = ?, Contact = ?, Country = ?, State = ?, ProfileImage = ?, GPSLocation = ? 
        WHERE Uemail = ?");
    if ($stmt) {
        $stmt->bind_param("ssssssssss", $username, $dob, $purpose, $address, $phone_no, $country, $state, $profileImagePath, $gps_location, $user_email);
        if ($stmt->execute()) {
            $message = "Profile updated successfully! ✅";
            $_SESSION['username'] = $username;
        } else $message = "Error updating profile: " . $stmt->error . " ❌";
        $stmt->close();
    } else $message = "Error preparing update statement: " . $conn->error . " ❌";
}

// Fetch User Data
$user_data = [];
$stmt = $conn->prepare("SELECT UName, Uemail, Address, Contact, DOB, ProfileImage, Purpose, Country, State, GPSLocation, createdate FROM usertab WHERE Uemail = ?");
if ($stmt) {
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user_data = $result->fetch_assoc();
    } else {
        $message .= "User data not found. Please log in again.";
        session_destroy();
        header("Location: index.php");
        exit();
    }
    $stmt->close();
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile | SmartBuild</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
:root {
  --primary-color: #0a4d68;
  --secondary-color: #ff6b6b;
  --bg-page: #f4f7f6;
  --bg-surface: #ffffff;
  --text-primary: #1a202c;
  --text-secondary: #555;
  --sidebar-bg: #1e293b;
  --sidebar-text: #cbd5e1;
  --sidebar-hover: #334155;
  --sidebar-active: var(--secondary-color);
  --shadow: 0 6px 20px rgba(0,0,0,0.1);
}

*{margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;}
body{background:var(--bg-page);color:var(--text-primary);overflow-x:hidden;}
.dashboard-container{display:flex;min-height:100vh;}

/* === SIDEBAR === */
.sidebar{
  width:250px;background:var(--sidebar-bg);color:var(--sidebar-text);
  padding:1.5rem;display:flex;flex-direction:column;
  position:fixed;top:0;left:0;height:100%;z-index:1000;
  transform:translateX(0);transition:all .3s ease;
}
.sidebar.closed{transform:translateX(-100%);}
.sidebar.open{transform:translateX(0);}
.sidebar-header{font-size:1.6rem;font-weight:700;color:#fff;margin-bottom:2rem;display:flex;align-items:center;gap:.75rem;}
.sidebar-nav a{
  display:flex;align-items:center;gap:.75rem;color:var(--sidebar-text);
  text-decoration:none;padding:.8rem 1rem;margin-bottom:.5rem;border-radius:8px;
}
.sidebar-nav a:hover{background:var(--sidebar-hover);color:#fff;}
.sidebar-nav a.active{background:var(--sidebar-active);color:#fff;}
.sidebar-nav i{width:22px;text-align:center;}
.sidebar-nav .logout{margin-top:auto;}

/* === OVERLAY === */
.overlay{
  display:none;position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.5);z-index:999;
}
.overlay.show{display:block;}

/* === MAIN CONTENT === */
.main-content{
  flex-grow:1;margin-left:250px;padding:2rem;
  transition:margin-left 0.3s ease;
}
.main-header{
  display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;
}
.main-header h1{font-size:1.8rem;font-weight:700;}
#menu-toggle{
  display:none;background:none;border:none;font-size:1.8rem;color:var(--text-primary);cursor:pointer;
}
.header-controls{display:flex;align-items:center;gap:1rem;}

/* === THEME SWITCH === */
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

/* === PROFILE FORM === */
.profile-container{
  background:var(--bg-surface);border-radius:16px;box-shadow:var(--shadow);
  padding:30px;max-width:950px;margin:auto;margin-top:30px;
}
.profile-header{text-align:center;margin-bottom:25px;}
.profile-header h2{color:var(--sidebar-bg);}
.message-box{text-align:center;padding:12px;border-radius:8px;margin-bottom:20px;font-weight:500;}
.message-box.success{background:#dcfce7;color:#166534;border-left:4px solid #16a34a;}
.message-box.error{background:#fee2e2;color:#991b1b;border-left:4px solid #ef4444;}

.profile-form{display:flex;flex-wrap:wrap;gap:30px;}
.profile-photo-section{
  flex:0 0 250px;display:flex;flex-direction:column;align-items:center;
  border-right:1px solid #e5e7eb;padding-right:20px;
}
.profile-photo{width:140px;height:140px;border-radius:50%;overflow:hidden;border:4px solid var(--primary-color);margin-bottom:15px;}
.profile-photo img{width:100%;height:100%;object-fit:cover;}
.upload-btn{background:var(--primary-color);color:#fff;border:none;padding:8px 15px;border-radius:6px;font-size:14px;cursor:pointer;}
.upload-btn:hover{background:#125678;}

.profile-content{flex:1;display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;}
.form-group{display:flex;flex-direction:column;}
.form-group label{font-weight:600;color:var(--text-primary);margin-bottom:5px;}
.form-group input,.form-group textarea{padding:10px;border:1px solid #cbd5e1;border-radius:6px;font-size:15px;transition:0.3s;}
.form-group input:focus,.form-group textarea:focus{border-color:var(--primary-color);outline:none;box-shadow:0 0 0 2px rgba(14,165,233,0.15);}
textarea{resize:vertical;min-height:70px;}
.form-buttons{grid-column:1 / -1;text-align:right;margin-top:20px;}
.btn{padding:10px 25px;border:none;border-radius:6px;font-weight:600;cursor:pointer;}
.update-btn{background:var(--primary-color);color:#fff;}
.update-btn:hover{background:#125678;}
.cancel-btn{background:#94a3b8;color:#fff;margin-left:10px;}
.cancel-btn:hover{background:#64748b;}

/* === RESPONSIVE === */
@media(max-width:900px){
  #menu-toggle{display:block;}
  .sidebar{transform:translateX(-100%);}
  .sidebar.open{transform:translateX(0);}
  .main-content{margin-left:0;padding:1.2rem;}
  .profile-form{flex-direction:column;}
  .profile-photo-section{border-right:none;border-bottom:1px solid #e5e7eb;padding-bottom:15px;margin-bottom:15px;}
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
      <a href="respass.php"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"class="active"><i class="fa-solid fa-user"></i>Edit Profile</a>
        <a href="feedback.php"><i class="fa-solid fa-comment-dots"></i>Feedback</a>
      <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
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

    <div class="profile-container">
      <div class="profile-header">
        <h2>User Profile</h2>
      </div>

      <?php if (!empty($message)): ?>
        <div class="message-box <?php echo (strpos($message, 'Error') !== false || strpos($message, 'failed') !== false) ? 'error' : 'success'; ?>">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form class="profile-form" method="POST" enctype="multipart/form-data">
        <div class="profile-photo-section">
          <div class="profile-photo">
            <img id="profile-image" src="<?php echo htmlspecialchars($user_data['ProfileImage'] ?? 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png'); ?>" alt="Profile">
          </div>
          <input type="hidden" name="existing_profile_image" value="<?php echo htmlspecialchars($user_data['ProfileImage'] ?? ''); ?>">
          <label for="photo-upload" class="upload-btn"><i class="fa-solid fa-upload"></i> Upload New Photo</label>
          <input type="file" id="photo-upload" name="photo_upload" accept="image/*" style="display:none;">
        </div>

        <div class="profile-content">
          <div class="form-group"><label>Username *</label><input type="text" name="username" value="<?php echo htmlspecialchars($user_data['UName']); ?>" required></div>
          <div class="form-group"><label>Date of Birth *</label><input type="date" name="dob" value="<?php echo htmlspecialchars($user_data['DOB']); ?>" required></div>
          <div class="form-group"><label>Requirements *</label><textarea name="purpose" required><?php echo htmlspecialchars($user_data['Purpose']); ?></textarea></div>
          <div class="form-group"><label>Address *</label><textarea name="address" required><?php echo htmlspecialchars($user_data['Address']); ?></textarea></div>
          <div class="form-group"><label>Email</label><input type="email" value="<?php echo htmlspecialchars($user_data['Uemail']); ?>" readonly></div>
          <div class="form-group"><label>Phone *</label><input type="tel" name="phone_no" value="<?php echo htmlspecialchars($user_data['Contact']); ?>" pattern="[0-9]{10}" maxlength="10" required></div>
          <div class="form-group"><label>Country *</label><input type="text" name="Country" value="<?php echo htmlspecialchars($user_data['Country']); ?>" required></div>
          <div class="form-group"><label>State *</label><input type="text" name="State" value="<?php echo htmlspecialchars($user_data['State']); ?>" required></div>

          <div class="form-buttons">
            <button type="submit" class="btn update-btn"><i class="fa-solid fa-save"></i> Update</button>
            <button type="button" class="btn cancel-btn" onclick="window.location.href='dashboard.php'">Cancel</button>
          </div>
        </div>
      </form>
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
