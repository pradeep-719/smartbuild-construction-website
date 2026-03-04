<?php
session_start();

// --- Database Connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usersss";

define('UPLOAD_DIR', 'uploads/');

// --- Check if user logged in ---
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['email'];

// --- Connect to DB ---
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// --- Step 1: Get Logged-in User ID ---
$user_id = null;
$user_row = null;
$stmt = $conn->prepare("SELECT id, ProfileImage FROM usertab WHERE Uemail = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $user_id = $row['id'];
    $user_row = $row;
}
$stmt->close();

if (!$user_id) {
    die("⚠️ User not found in 'usertab' table.");
}

// --- Profile Image ---
$profileImageSrc = !empty($user_row['ProfileImage'])
    ? htmlspecialchars($user_row['ProfileImage'])
    : 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png';

// --- Fetch Uploads ---
$sql = "
    SELECT 
        t.worker_id,
        t.contractor_email,
        t.description,
        t.image_filename, 
        t.log_datetime
    FROM track_updates t
    INNER JOIN user_contractor_status ucs 
        ON (
            t.worker_id = ucs.contractor_name
            OR t.contractor_id = ucs.contractor_id
        )
    WHERE 
        ucs.user_id = ?
        AND ucs.status = 'accept'
        AND t.user_email = ?
    ORDER BY t.log_datetime DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $user_email);
$stmt->execute();
$result = $stmt->get_result();

$track_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $track_data[] = $row;
    }
} else {
    $error_message = "No uploads found for your accepted contractors yet.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Updates | SmartBuild</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<style>
/* === THEME VARIABLES === */
:root {
  --primary-color: #0a4d68;
  --secondary-color: #ff6b6b;
  --gradient-start: #0a4d68;
  --gradient-end: #1a7fa3;
  --bg-page: #f4f7f6;
  --bg-surface: #ffffff;
  --text-primary: #1a202c;
  --text-secondary: #555;
  --sidebar-bg: #1e293b;
  --sidebar-text: #cbd5e1;
  --sidebar-hover: #334155;
  --sidebar-active: var(--secondary-color);
  --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* === GLOBAL === */
* {margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body {background:var(--bg-page);color:var(--text-primary);}

/* === LAYOUT === */
.dashboard-container {display:flex;min-height:100vh;}
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

/* OVERLAY */
.overlay{
  display:none;position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.5);z-index:900;
}
.overlay.show{display:block;}
/* === TRACK GRID === */
.track-grid {
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
  gap:20px;
}
.track-card {
  background:var(--bg-surface);
  border-radius:12px;
  box-shadow:var(--shadow);
  padding:1.5rem;
  transition:transform .2s,box-shadow .2s;
}
.track-card:hover {
  transform:translateY(-4px);
  box-shadow:0 8px 16px rgba(0,0,0,.15);
}
.track-card img {
  width:30%;
  border-radius:10px;
  margin-top:10px;
  transition:.3s;
}
.track-card img:hover {transform:scale(1.02);}
.track-info h3 {font-size:1.1rem;color:var(--primary-color);}
.track-info p {font-size:.9rem;color:var(--text-secondary);margin:.4rem 0;}
.timestamp {font-size:.85rem;color:#64748b;margin-top:.5rem;}

/* === NO DATA BOX === */
.no-data {
  background:var(--bg-surface);
  border-radius:12px;
  padding:30px;
  box-shadow:var(--shadow);
  text-align:center;
  color:var(--text-secondary);
}
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
      <a href="form.php"><i class="fa-solid fa-briefcase"></i>Contractors</a>
      <a href="track.php"  class="active"><i class="fa-solid fa-map-location-dot"></i>Track</a>
      <a href="userfroms.php"><i class="fa-solid fa-file"></i>Docs</a>
      <a href="respass.php"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i>Edit Profile</a>
              <a href="feedback.php"><i class="fa-solid fa-comment-dots"></i>Feedback</a>

      <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </nav>
  </aside>
  <!-- MAIN -->
 
     <main class="main-content">
    <header class="main-header">
      <h1>My Contractor Tracking Updates</h1>
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


    <?php if (!empty($error_message)): ?>
      <div class="no-data"><?= htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <?php if (!empty($track_data)): ?>
      <div class="track-grid">
        <?php foreach ($track_data as $row): ?>
          <div class="track-card">
            <div class="track-info">
              <h3><?= htmlspecialchars($row['worker_id']); ?></h3>
              <p><i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($row['contractor_email']); ?></p>
              <p><i class="fa-solid fa-clipboard"></i> <?= htmlspecialchars($row['description']); ?></p>
            </div>
            <a href="<?= htmlspecialchars(UPLOAD_DIR . $row['image_filename']); ?>" data-fancybox="gallery">
              <img src="<?= htmlspecialchars(UPLOAD_DIR . $row['image_filename']); ?>" alt="Proof Image">
            </a>
            <p class="timestamp"><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($row['log_datetime']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
Fancybox.bind("[data-fancybox]");
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
