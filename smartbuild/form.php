<?php
session_start();

// --- DATABASE CONNECTION ---
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// --- VERIFY LOGIN ---
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['email'];
$user_id = 0;
$user_country = '';
$user_state = '';
$admin_action = '';

// --- Step 1: Fetch User Details ---
$user_email_safe = $conn->real_escape_string($user_email);
$user_sql = "SELECT id, Country, State, ProfileImage, admin_action FROM usertab WHERE Uemail = '$user_email_safe'";
$user_res = $conn->query($user_sql);

if ($user_res->num_rows > 0) {
    $user_row = $user_res->fetch_assoc();
    $user_id = $user_row['id'];
    $user_country = $user_row['Country'];
    $user_state = $user_row['State'];
    $admin_action = strtolower($user_row['admin_action']);
} else {
    die("<b>Error:</b> User details not found for email: " . htmlspecialchars($user_email));
}

// --- Step 2: Handle Request Accept ---
if (isset($_GET['accept_id'])) {
    if ($admin_action === 'rejected') {
        echo "<script>
            alert('Access Denied! Your profile was rejected by the admin.');
            window.location.href='" . $_SERVER['PHP_SELF'] . "';
        </script>";
        exit();
    }

    $contractor_id = intval($_GET['accept_id']);
    $status = 'accept';

    // Only one contractor can be accepted per user
    $check_accept_sql = "SELECT * FROM user_contractor_status WHERE user_id='$user_id' AND status='accept'";
    $check_accept_res = $conn->query($check_accept_sql);
    if ($check_accept_res->num_rows > 0) {
        echo "<script>alert('You have already accepted one contractor.'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    }

    $name_sql = "SELECT CName FROM contractor WHERE id = $contractor_id";
    $name_res = $conn->query($name_sql);
    $contractor_name = 'Unknown Contractor';
    if ($name_res && $name_res->num_rows > 0) {
        $name_row = $name_res->fetch_assoc();
        $contractor_name = $conn->real_escape_string($name_row['CName']);
    }

    $check_sql = "SELECT * FROM user_contractor_status WHERE user_id='$user_id' AND contractor_id='$contractor_id'";
    $check_res = $conn->query($check_sql);

    if ($check_res->num_rows > 0) {
        $conn->query("UPDATE user_contractor_status 
                      SET status='$status', contractor_name='$contractor_name'
                      WHERE user_id='$user_id' AND contractor_id='$contractor_id'");
    } else {
        $conn->query("INSERT INTO user_contractor_status (user_id, contractor_id, status, contractor_name) 
                      VALUES ('$user_id', '$contractor_id', '$status', '$contractor_name')");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// --- PROFILE IMAGE LOGIC ---
if (!empty($user_row['ProfileImage'])) {
    $profileImageSrc = htmlspecialchars($user_row['ProfileImage']);
} else {
    $profileImageSrc = 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png';
}

// --- Step 3: Fetch Contractors with Experience ---
$sql = "
SELECT 
    c.id, c.CName, c.Cemail, c.Contact, c.Address, c.Purpose, c.DOB, c.Country, c.State, 
    c.ProfileImage, c.ExperienceYears, c.ExperienceProof,
    IFNULL(ucs.status, 'pending') AS status,
    COALESCE(cur.request_status, 'not sent') AS request_status
FROM contractor c
LEFT JOIN user_contractor_status ucs
    ON ucs.contractor_id = c.id
   AND ucs.user_id = ?
LEFT JOIN contractor_user_response cur
    ON cur.contractor_id = c.id
   AND cur.user_id = ?
WHERE 
    TRIM(LOWER(c.Country)) = TRIM(LOWER(?))
    AND TRIM(LOWER(c.State)) = TRIM(LOWER(?))
    AND (
        c.id IN (
            SELECT contractor_id 
            FROM contractor_user_response 
            WHERE user_id = ?
        )
        OR c.id NOT IN (
            SELECT DISTINCT contractor_id 
            FROM contractor_user_response
        )
    )
ORDER BY 
    CASE 
        WHEN c.id IN (
            SELECT contractor_id 
            FROM contractor_user_response 
            WHERE user_id = ?
        ) THEN 0
        ELSE 1
    END,
    c.id DESC
";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param('iissii', $user_id, $user_id, $user_country, $user_state, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contractor List - SmartBuild</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
  --primary-color: #0a4d68;
  --secondary-color: #ff6b6b;
  --gradient-start: #0a4d68;
  --gradient-end: #1a7fa3;
  --bg-page: #f4f7f6;
  --bg-surface: #ffffff;
  --text-primary: #1a202c;
  --text-secondary: #555;
  --border-color: #e2e8f0;
  --shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
  --sidebar-bg: #1e293b;
  --sidebar-text: #cbd5e1;
  --sidebar-bg-hover: #334155;
  --sidebar-active: var(--secondary-color);
}
html[data-theme="dark"] {
  --primary-color: #1a7fa3;
  --bg-page: #121212;
  --bg-surface: #1e1e1e;
  --text-primary: #e0e0e0;
  --text-secondary: #a0a0a0;
  --border-color: #3a3a3a;
  --sidebar-bg: #1a1a1a;
  --sidebar-text: #a0a0a0;
  --sidebar-bg-hover: #2c2c2c;
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}
body {
  background: var(--bg-page);
  color: var(--text-primary);
  overflow-x: hidden;
}
.dashboard-container {
  display: flex;
  min-height: 100vh;
  width: 100%;
  position: relative;
}

/* SIDEBAR */
.sidebar {
  width: 250px;
  background: var(--sidebar-bg);
  color: var(--sidebar-text);
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  transition: all 0.3s ease;
  z-index: 1000;
}
.sidebar.closed {
  transform: translateX(-100%);
}
.sidebar-header {
  font-size: 1.6rem;
  font-weight: 700;
  color: #fff;
  margin-bottom: 2rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.sidebar-nav a {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: var(--sidebar-text);
  text-decoration: none;
  padding: 0.8rem 1rem;
  margin-bottom: 0.5rem;
  border-radius: 8px;
}
.sidebar-nav a:hover {
  background: var(--sidebar-bg-hover);
  color: #fff;
}
.sidebar-nav a.active {
  background: var(--sidebar-active);
  color: #fff;
}
.sidebar-nav i {
  width: 22px;
  text-align: center;
}
.sidebar-nav .logout {
  margin-top: auto;
}

/* OVERLAY */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.45);
  display: none;
  z-index: 900;
}
.overlay.show {
  display: block;
}

/* MAIN */
.main-content {
  flex-grow: 1;
  padding: 2rem;
  margin-left: 250px;
  transition: margin-left 0.3s ease;
}
.main-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}
.main-header h1 {
  font-size: 1.8rem;
  font-weight: 700;
}
#menu-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 1.7rem;
  color: var(--text-primary);
  cursor: pointer;
}

/* THEME TOGGLE */
.header-controls {
  display: flex;
  align-items: center;
  gap: 1rem;
}
.theme-switch {
  position: relative;
  width: 50px;
  height: 26px;
}
.theme-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: #ccc;
  border-radius: 26px;
  cursor: pointer;
  transition: 0.3s;
}
.slider:before {
  content: "";
  position: absolute;
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 3px;
  background: white;
  border-radius: 50%;
  transition: 0.3s;
}
input:checked + .slider {
  background: var(--primary-color);
}
input:checked + .slider:before {
  transform: translateX(22px);
}
.slider .fa-sun,
.slider .fa-moon {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 13px;
  color: #fff;
}
.slider .fa-sun {
  left: 6px;
}
.slider .fa-moon {
  right: 6px;
  opacity: 0;
}
input:checked + .slider .fa-sun {
  opacity: 0;
}
input:checked + .slider .fa-moon {
  opacity: 1;
}

/* CONTRACTOR GRID */
.contractor-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
  gap: 1.5rem;
}
.contractor-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: 12px;
  box-shadow: var(--shadow);
  padding: 1.5rem;
  transition: 0.3s;
}
.contractor-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}
.contractor-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}
.contractor-header img {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--border-color);
}
.contractor-header h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--text-primary);
}
.contractor-info span {
  display: block;
  font-size: 0.9rem;
  color: var(--text-secondary);
  margin-bottom: 4px;
}
.contractor-footer {
  margin-top: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.btn {
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;
  border: none;
  cursor: pointer;
}
.btn-primary {
  background: var(--primary-color);
  color: #fff;
}
.btn-primary:hover {
  background: #083b53;
}
.btn-secondary {
  background: var(--bg-inset);
  color: var(--text-secondary);
}
.no-data {
  text-align: center;
  padding: 3rem;
  color: var(--text-secondary);
  background: var(--bg-surface);
  border-radius: 12px;
}

/* RESPONSIVE FIX */
@media (max-width: 900px) {
  #menu-toggle {
    display: block;
  }
  .sidebar {
    left: -100%;
  }
  .sidebar.open {
    left: 0;
  }
  .main-content {
    margin-left: 0;
    padding: 1.2rem;
  }
}
</style>
</style>
</head>
<body>
<div class="dashboard-container">
  <aside class="sidebar">
    <div class="sidebar-header"><i class="fa-solid fa-user"></i>Customer</div>
    <nav class="sidebar-nav">
      <a href="dashboard.php"><i class="fa-solid fa-gauge"></i>Profile</a>
      <a href="form.php" class="active"><i class="fa-solid fa-briefcase"></i>Contractors</a>
      <a href="track.php"><i class="fa-solid fa-map-location-dot"></i>Track</a>
      <a href="userfroms.php"><i class="fa-solid fa-file"></i>Docs</a>
      <a href="respass.php"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i>Edit Profile</a>
              <a href="feedback.php"><i class="fa-solid fa-comment-dots"></i>Feedback</a>

      <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <h1>Available Contractors</h1>
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

    <div class="contractor-grid">
      <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
          <div class="contractor-card">
            <div class="contractor-header">
              <img src="<?= htmlspecialchars($row['ProfileImage'] ?: 'https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png') ?>" alt="">
              <div>
                <h3><?= htmlspecialchars($row['CName']) ?></h3>
                <span><?= htmlspecialchars($row['Cemail']) ?></span>
              </div>
            </div>
            <div class="contractor-info">
              <span><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($row['Contact']) ?></span>
              <span><i class="fa-solid fa-map-marker-alt"></i> <?= htmlspecialchars($row['Address']) ?></span>
              <span><i class="fa-solid fa-earth-asia"></i> <?= htmlspecialchars($row['Country']) ?>, <?= htmlspecialchars($row['State']) ?></span>
              <span><i class="fa-solid fa-user-clock"></i> <?= htmlspecialchars($row['ExperienceYears'] ?? 'N/A') ?> years experience</span>
              <span><i class="fa-solid fa-file"></i>
                <?php if (!empty($row['ExperienceProof'])): ?>
                  <a href="<?= htmlspecialchars($row['ExperienceProof']) ?>" target="_blank">View Proof</a>
                <?php else: ?>
                  Not Uploaded
                <?php endif; ?>
              </span>
            </div>

            <div class="contractor-footer">
              <?php if ($row['status'] == 'pending') { ?>
                <a href="?accept_id=<?= $row['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-handshake"></i> Request</a>
              <?php } elseif ($row['status'] == 'accept') { ?>
                <span class="btn btn-secondary">✔ Requested</span>
              <?php } elseif ($row['status'] == 'reject') { ?>
                <span class="btn btn-secondary">✖ Rejected</span>
              <?php } ?>
             
            </div>
          </div>
        <?php }
      } else { ?>
        <div class="no-data">
          <h2>No contractors found</h2>
          <p>Try changing your region or check again later.</p>
        </div>
      <?php } ?>
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
