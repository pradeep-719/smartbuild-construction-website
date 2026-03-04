<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Database Connection
$con = new mysqli("localhost", "root", "", "usersss");
if ($con->connect_error) die("Connection failed: " . $con->connect_error);

$email = $_SESSION['email'];
$stmt = $con->prepare("SELECT UName, Uemail, Address, Contact, Country, State, DOB, Purpose, createdate, ProfileImage FROM usertab WHERE Uemail=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc() ?? [];

$con->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($user['UName'] ?? 'User'); ?> - Profile</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
/* --- THEME VARIABLES --- */
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
  --sidebar-hover: #334155;
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
  --shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  --sidebar-bg: #1a1a1a;
  --sidebar-text: #a0a0a0;
  --sidebar-hover: #2c2c2c;
}

/* --- GLOBAL RESET --- */
* {margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;transition:background-color .3s,color .3s,border-color .3s;}
body {background:var(--bg-page);color:var(--text-primary);}

/* --- MAIN STRUCTURE --- */
.dashboard-container {display:flex;min-height:100vh;}
.sidebar {
  width:250px;background:var(--sidebar-bg);color:var(--sidebar-text);
  padding:1.5rem;display:flex;flex-direction:column;position:fixed;height:100vh;
}
.sidebar-header {
  font-size:1.6rem;font-weight:700;color:#fff;margin-bottom:2rem;
  display:flex;align-items:center;gap:.75rem;
}
.sidebar-nav a {
  display:flex;align-items:center;gap:.75rem;text-decoration:none;
  color:var(--sidebar-text);padding:.8rem 1rem;margin-bottom:.5rem;border-radius:8px;
}
.sidebar-nav a:hover {background:var(--sidebar-hover);color:#fff;}
.sidebar-nav a.active {background:var(--secondary-color);color:#fff;}
.sidebar-nav .logout {margin-top:auto;}
.sidebar-nav i {width:22px;text-align:center;}

.main-content {
  flex-grow:1;padding:2rem;margin-left:250px;transition:margin .3s;
}

/* --- HEADER --- */
.main-header {
  display:flex;justify-content:space-between;align-items:center;
  margin-bottom:1.5rem;
}
.main-header h1 {font-size:2rem;font-weight:700;color:var(--text-primary);}
#menu-toggle {display:none;background:none;border:none;font-size:1.5rem;color:var(--text-primary);cursor:pointer;}
.header-controls {display:flex;align-items:center;gap:1rem;}

/* --- PROFILE CARD --- */
.profile-card {
  background:var(--bg-surface);
  border-radius:12px;box-shadow:var(--shadow);overflow:hidden;
}
.profile-header {
  background:linear-gradient(135deg,var(--gradient-start),var(--gradient-end));
  color:white;text-align:center;padding:3rem 1rem 5rem;position:relative;
}
.profile-header img {
  width:120px;height:120px;border-radius:50%;
  border:4px solid white;object-fit:cover;
  position:absolute;left:50%;transform:translateX(-50%);bottom:-60px;
  box-shadow:0 5px 15px rgba(0,0,0,.3);
}
.profile-header h2 {font-size:1.8rem;margin-bottom:.3rem;}
.profile-header p {opacity:.9;}

.profile-body {padding:5rem 2rem 2rem;}
.details-grid {
  display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
  gap:1.5rem;
}
.detail-item {
  display:flex;align-items:center;gap:1rem;background:var(--bg-inset);
  padding:1.2rem;border-radius:8px;border:1px solid var(--border-color);
  box-shadow:var(--shadow);
}
.detail-item i {font-size:1.4rem;color:var(--primary-color);}
.detail-item .label {font-size:.85rem;color:var(--text-secondary);text-transform:uppercase;font-weight:600;}
.detail-item .value {font-size:1.05rem;color:var(--text-primary);font-weight:500;}

/* --- THEME SWITCH --- */
.theme-switch {position:relative;width:50px;height:26px;}
.theme-switch input {opacity:0;width:0;height:0;}
.slider {
  position:absolute;top:0;left:0;right:0;bottom:0;background:#ccc;
  border-radius:26px;cursor:pointer;transition:.3s;
}
.slider:before {
  content:"";position:absolute;height:20px;width:20px;left:4px;bottom:3px;
  background:white;border-radius:50%;transition:.3s;
}
input:checked + .slider {background:var(--primary-color);}
input:checked + .slider:before {transform:translateX(22px);}
.slider .fa-sun,.slider .fa-moon {
  position:absolute;top:50%;transform:translateY(-50%);font-size:13px;color:#fff;transition:.3s;
}
.slider .fa-sun {left:6px;opacity:1;}
.slider .fa-moon {right:6px;opacity:0;}
input:checked + .slider .fa-sun {opacity:0;}
input:checked + .slider .fa-moon {opacity:1;}

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
      <a href="dashboard.php" class="active"><i class="fa-solid fa-gauge"></i>Profile</a>
      <a href="form.php"><i class="fa-solid fa-briefcase"></i>Contractors</a>
      <a href="track.php"><i class="fa-solid fa-map-location-dot"></i>Track</a>
      <a href="userfroms.php"><i class="fa-solid fa-file"></i>Docs</a>
      <a href="respass.php"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i>Edit Profile</a>
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

    <div class="profile-card">
      <div class="profile-header">
        <h2><?php echo htmlspecialchars($user['UName'] ?? 'Customer'); ?></h2>
        <p>Welcome to your profile</p>
        <img src="<?php echo htmlspecialchars($user['ProfileImage'] ?? 'https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png'); ?>" alt="Profile">
      </div>

      <div class="profile-body">
        <div class="details-grid">
          <div class="detail-item"><i class="fa-solid fa-envelope"></i><div><div class="label">Email</div><div class="value"><?php echo htmlspecialchars($user['Uemail'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-phone"></i><div><div class="label">Contact</div><div class="value"><?php echo htmlspecialchars($user['Contact'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-map-marker-alt"></i><div><div class="label">Address</div><div class="value"><?php echo htmlspecialchars($user['Address'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-earth-asia"></i><div><div class="label">Country</div><div class="value"><?php echo htmlspecialchars($user['Country'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-city"></i><div><div class="label">State</div><div class="value"><?php echo htmlspecialchars($user['State'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-calendar"></i><div><div class="label">Date of Birth</div><div class="value"><?php echo htmlspecialchars($user['DOB'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-briefcase"></i><div><div class="label">Purpose</div><div class="value"><?php echo htmlspecialchars($user['Purpose'] ?? 'N/A'); ?></div></div></div>
          <div class="detail-item"><i class="fa-solid fa-clock"></i><div><div class="label">Created Date</div><div class="value"><?php echo htmlspecialchars($user['createdate'] ?? 'N/A'); ?></div></div></div>
        </div>
      </div>
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
