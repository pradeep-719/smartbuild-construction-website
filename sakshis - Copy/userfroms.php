<?php
session_start();

// --- 1. Check if user is logged in ---
if (!isset($_SESSION['email'])) {
    echo "User not logged in!";
    exit();
}

// --- 2. Database Connection ---
$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// --- 3. Get Logged In User Info ---
$user_email = $_SESSION['email'];
$user_email_escaped = mysqli_real_escape_string($con, $user_email);

$user_query = mysqli_query($con, "SELECT id, ProfileImage, UName FROM usertab WHERE Uemail = '$user_email_escaped'");
if ($user_query && mysqli_num_rows($user_query) > 0) {
    $user_row = mysqli_fetch_assoc($user_query);
    $user_id = $user_row['id'];
    $user_name = $user_row['UName'];
} else {
    $user_row = [];
    $user_id = 0;
    $user_name = "Guest User";
}

// --- PROFILE IMAGE ---
$profileImageSrc = !empty($user_row['ProfileImage'])
    ? htmlspecialchars($user_row['ProfileImage'])
    : 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png';

// --- 4. Handle PDF Upload ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file'])) {
    $contractor_id = $_POST['contractor_id'];
    $file = $_FILES['pdf_file'];

    if ($file['error'] == 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($file['name']);
        $file_path = $upload_dir . time() . "_" . $file_name;

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            $insert = mysqli_query($con, "INSERT INTO documents (user_id, contractor_id, file_path) VALUES ('$user_id', '$contractor_id', '$file_path')");
            echo $insert
                ? "<script>alert('✅ Signed PDF uploaded successfully!');</script>"
                : "<script>alert('❌ Database insert failed!');</script>";
        } else {
            echo "<script>alert('❌ File upload failed!');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Error uploading file!');</script>";
    }
}

// --- 5. Fetch Contractors ---
$contractors = mysqli_query($con, "SELECT id, CName FROM contractor");
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Documentation Upload | SmartBuild</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

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

/* === GLOBAL === */
*{margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;}
body{background:var(--bg-page);color:var(--text-primary);overflow-x:hidden;}
.dashboard-container{display:flex;min-height:100vh;width:100%;}

/* === SIDEBAR === */
.sidebar{
  width:250px;background:var(--sidebar-bg);color:var(--sidebar-text);
  padding:1.5rem;display:flex;flex-direction:column;position:fixed;
  top:0;left:0;height:100vh;z-index:1000;transition:all .3s ease;
}
.sidebar-header{font-size:1.6rem;font-weight:700;color:#fff;margin-bottom:2rem;display:flex;align-items:center;gap:.75rem;}
.sidebar-nav a{
  display:flex;align-items:center;gap:.75rem;color:var(--sidebar-text);
  text-decoration:none;padding:.8rem 1rem;margin-bottom:.5rem;border-radius:8px;
}
.sidebar-nav a:hover{background:var(--sidebar-hover);color:#fff;}
.sidebar-nav a.active{background:var(--sidebar-active);color:#fff;}
.sidebar-nav i{width:22px;text-align:center;}
.sidebar-nav .logout{margin-top:auto;}

/* === OVERLAY FOR MOBILE === */
.overlay{
  display:none;position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.5);z-index:900;
}
.overlay.show{display:block;}

/* === MAIN CONTENT === */
.main-content{
  flex-grow:1;margin-left:250px;padding:2rem;transition:margin-left 0.3s ease;
}
.main-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;}
.main-header h1{font-size:1.8rem;font-weight:700;}
#menu-toggle{display:none;background:none;border:none;font-size:1.7rem;color:var(--text-primary);cursor:pointer;}
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

/* === UPLOAD CONTAINER === */
.containe{
  background:#f9fcff;
  border-radius:16px;
  padding:30px;
  box-shadow:0 8px 20px rgba(10,77,104,0.15);
  max-width:750px;
  margin:auto;
}
.user-info{
  display:flex;align-items:center;gap:1rem;margin-bottom:20px;
}
.user-info img{
  width:60px;height:60px;border-radius:50%;object-fit:cover;
  border:3px solid var(--primary-color);
}
.user-info div{font-weight:600;color:var(--primary-color);}
.note{
  background:#e7f7ff;border-left:5px solid var(--primary-color);
  padding:12px 15px;border-radius:8px;margin-bottom:20px;
  font-size:14px;color:#0a4d68;
}
.download-btn{
  display:inline-block;width:100%;padding:12px;text-align:center;
  background:#1e293b;color:#fff;border-radius:8px;text-decoration:none;
  font-weight:600;margin-bottom:20px;transition:0.3s;
}
.download-btn:hover{background:var(--primary-color);}
form label{font-weight:600;display:block;margin-top:10px;}
form select,form input[type="file"]{
  width:100%;padding:12px;margin-top:8px;border-radius:8px;
  border:1px solid #ccc;outline:none;font-size:15px;transition:0.3s;
}
form select:focus,form input[type="file"]:focus{
  border-color:var(--primary-color);
  box-shadow:0 0 0 2px rgba(10,77,104,0.2);
}
form button{
  width:100%;padding:12px;margin-top:20px;border:none;
  border-radius:8px;background:#1a202c;color:#fff;
  font-weight:600;cursor:pointer;transition:0.3s;
}
form button:hover{background:var(--primary-color);}
.footer-text{text-align:center;margin-top:20px;color:#666;font-size:14px;}

/* === RESPONSIVE FIXES === */
@media(max-width:900px){
  .sidebar{left:-100%;position:fixed;transition:all .3s;}
  .sidebar.open{left:0;}
  .main-content{margin-left:0;padding:1.2rem;}
  #menu-toggle{display:block;}
  .main-header{flex-direction:row;gap:1rem;}
  .containe{padding:20px;}
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
      <a href="userfroms.php" class="active"><i class="fa-solid fa-file"></i>Docs</a>
      <a href="respass.php"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i>Edit Profile</a>
              <a href="feedback.php"><i class="fa-solid fa-comment-dots"></i>Feedback</a>

      <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <h1>Upload Document</h1>
      <div class="header-controls">
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

    <div class="containe">
      <div class="user-info">
        <img src="<?= $profileImageSrc ?>" alt="Profile">
        <div><?= htmlspecialchars($user_name) ?></div>
      </div>

      <div class="note">
        Please download the documentation file, sign it, and re-upload the signed copy.
        <br><b>⚠️ This step is mandatory before proceeding.</b>
      </div>

      <a href="buildsmart.pdf" class="download-btn" download><i class="fa-solid fa-download"></i> Download Template</a>

      <form method="POST" enctype="multipart/form-data">
        <label>Select Contractor:</label>
        <select name="contractor_id" required>
          <option value="">-- Select Contractor --</option>
          <?php while ($row = mysqli_fetch_assoc($contractors)) { ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['CName']) ?></option>
          <?php } ?>
        </select>

        <label>Upload Signed PDF:</label>
        <input type="file" name="pdf_file" accept=".pdf" required>

        <button type="submit"><i class="fa-solid fa-upload"></i> Upload PDF</button>
      </form>

      <p class="footer-text">SmartBuild © 2025 — Secure File Documentation Portal</p>
    </div>
  </main>
</div>

<script>
const menuToggle=document.getElementById("menu-toggle");
const sidebar=document.querySelector(".sidebar");
const themeToggle=document.getElementById("theme-toggle");
menuToggle.addEventListener("click",()=>{sidebar.classList.toggle("open");});
document.addEventListener("DOMContentLoaded",()=>{
  const theme=localStorage.getItem("theme");
  if(theme==="dark"){document.documentElement.setAttribute("data-theme","dark");themeToggle.checked=true;}
});
themeToggle.addEventListener("change",(e)=>{
  if(e.target.checked){document.documentElement.setAttribute("data-theme","dark");localStorage.setItem("theme","dark");}
  else{document.documentElement.setAttribute("data-theme","light");localStorage.setItem("theme","light");}
});
</script>
</body>
</html>
