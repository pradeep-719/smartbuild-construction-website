<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ✅ Step 1: Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// --- Admin Profile Fetch ---
$email = $_SESSION['email'];
$query = "SELECT ProfileImage, UName, id FROM usertab WHERE Uemail='$email'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $user_row = mysqli_fetch_assoc($result);
    $profileImage = $user_row['ProfileImage'];
    $user_id = $user_row['id'];
    $user_name = $user_row['UName'];
} else {
    die("User not found");
}

$profileImageSrc = !empty($profileImage)
    ? $profileImage
    : "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";

// ✅ Step 2: Check accepted contractor for this user
$sql = "SELECT c.id, c.CName 
        FROM contractor c
        INNER JOIN user_contractor_status ucs 
        ON c.id = ucs.contractor_id
        WHERE ucs.user_id = ? AND LOWER(ucs.status) = 'accept'
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$contractor = $result->fetch_assoc();

// ✅ Step 3: Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contractor_id = intval($_POST['contractor_id']);
    $feedback = trim($_POST['feedback']);
    $rating = intval($_POST['rating']);

    if (!empty($contractor_id) && !empty($feedback)) {
        $insert = $conn->prepare("
            INSERT INTO feedbacks (user_id, contractor_id, feedback_text, rating)
            VALUES (?, ?, ?, ?)
        ");
        $insert->bind_param("iisi", $user_id, $contractor_id, $feedback, $rating);
        if ($insert->execute()) {
            echo "<script>alert('✅ Feedback submitted successfully!');</script>";
        } else {
            echo "<script>alert('❌ Database error while saving feedback!');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Please provide both feedback and rating.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Feedback | SmartBuild</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
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
  --shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
}

* {margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif;}
body {background: var(--bg-page); color: var(--text-primary); overflow-x: hidden;}
.dashboard-container {display: flex; min-height: 100vh;}

/* === SIDEBAR === */
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
  z-index: 1000;
  transform: translateX(0);
  transition: transform 0.3s ease;
}
.sidebar.closed {transform: translateX(-100%);}
.sidebar.open {transform: translateX(0);}
.sidebar-header {
  font-size: 1.6rem; font-weight: 700; color: #fff;
  margin-bottom: 2rem; display: flex; align-items: center; gap: .75rem;
}
.sidebar-nav a {
  display: flex; align-items: center; gap: .75rem;
  color: var(--sidebar-text); text-decoration: none;
  padding: .8rem 1rem; margin-bottom: .5rem;
  border-radius: 8px; transition: 0.3s;
}
.sidebar-nav a:hover {background: var(--sidebar-hover); color: #fff;}
.sidebar-nav a.active {background: var(--sidebar-active); color: #fff;}
.sidebar-nav i {width: 22px; text-align: center;}
.sidebar-nav .logout {margin-top: auto;}

/* === OVERLAY === */
.overlay {
  display: none; position: fixed; top: 0; left: 0;
  width: 100%; height: 100%; background: rgba(0,0,0,0.5);
  z-index: 999;
}
.overlay.show {display: block;}

/* === MAIN === */
.main-content {
  flex-grow: 1;
  margin-left: 250px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
}
.main-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}
.main-header h1 {font-size: 1.8rem; font-weight: 700;}
#menu-toggle {
  display: none; background: none; border: none;
  font-size: 1.8rem; color: var(--text-primary);
  cursor: pointer;
}

/* === THEME SWITCH === */
.header-controls {display: flex; align-items: center; gap: 1rem;}
.theme-switch {position: relative; width: 50px; height: 26px;}
.theme-switch input {opacity: 0; width: 0; height: 0;}
.slider {
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  background: #ccc; border-radius: 26px; cursor: pointer; transition: .3s;
}
.slider:before {
  content: ""; position: absolute;
  height: 20px; width: 20px; left: 4px; bottom: 3px;
  background: white; border-radius: 50%; transition: .3s;
}
input:checked + .slider {background: var(--primary-color);}
input:checked + .slider:before {transform: translateX(22px);}
.slider .fa-sun, .slider .fa-moon {
  position: absolute; top: 50%; transform: translateY(-50%);
  font-size: 13px; color: #fff;
}
.slider .fa-sun {left: 6px;}
.slider .fa-moon {right: 6px; opacity: 0;}
input:checked + .slider .fa-sun {opacity: 0;}
input:checked + .slider .fa-moon {opacity: 1;}

/* === FEEDBACK FORM === */
.feedback-wrapper {
  display: flex; justify-content: center; align-items: center;
  padding: 40px 20px;
}
.feedback-card {
  background: var(--bg-surface);
  border-radius: 16px;
  box-shadow: var(--shadow);
  padding: 35px;
  max-width: 550px;
  width: 100%;
  transition: .3s;
}
.feedback-card:hover {transform: translateY(-3px); box-shadow: 0 12px 28px rgba(0,0,0,.1);}
.feedback-card h2 {
  text-align: center; color: var(--primary-color);
  margin-bottom: 20px; font-weight: 700; font-size: 1.6rem;
}
.feedback-form {display: flex; flex-direction: column; gap: 18px;}
.form-group label {font-weight: 600; color: var(--primary-color); margin-bottom: 5px;}
.form-group input, .form-group select, .form-group textarea {
  width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1;
  border-radius: 8px; font-size: 15px; transition: .3s;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px rgba(10,77,104,0.15);
  outline: none;
}
textarea {resize: vertical; min-height: 90px;}
.submit-btn {
  background: var(--primary-color); color: #fff; border: none;
  padding: 12px; border-radius: 8px; font-weight: 600;
  cursor: pointer; transition: .3s;
}
.submit-btn:hover {background: #125678; transform: scale(1.03);}
.no-contractor {
  text-align: center; background: #fff; border-radius: 10px;
  padding: 20px; color: var(--primary-color); box-shadow: var(--shadow);
}

/* === RESPONSIVE === */
@media(max-width: 900px) {
  #menu-toggle {display: block;}
  .sidebar {transform: translateX(-100%);}
  .sidebar.open {transform: translateX(0);}
  .overlay.show {display: block;}
  .main-content {margin-left: 0; padding: 1.2rem;}
  .feedback-wrapper {padding: 20px;}
  .feedback-card {padding: 25px 20px; max-width: 95%;}
}


</style>
</head>
<body>

<div class="dashboard-container">
  <aside class="sidebar">
    <div class="sidebar-header"><i class="fa-solid fa-user"></i>Customer</div>
    <nav class="sidebar-nav">
      <a href="dashboard.php" ><i class="fa-solid fa-gauge"></i>Profile</a>
      <a href="form.php"><i class="fa-solid fa-briefcase"></i>Contractors</a>
      <a href="track.php"><i class="fa-solid fa-map-location-dot"></i>Track</a>
      <a href="userfroms.php"><i class="fa-solid fa-file"></i>Docs</a>
      <a href="respass.php"><i class="fa-solid fa-key"></i>Reset</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i>Edit Profile</a>
              <a href="feedback.php" class="active"><i class="fa-solid fa-comment-dots"></i>Feedback</a>

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


  <div class="feedback-wrapper">
    <div class="feedback-card">
      <h2>📝 Give Feedback</h2>
      <?php if ($contractor): ?>
      <form method="POST" class="feedback-form">
        <div class="form-group">
          <label>Contractor:</label>
          <input type="text" value="<?= htmlspecialchars($contractor['CName']) ?>" readonly>
          <input type="hidden" name="contractor_id" value="<?= $contractor['id'] ?>">
        </div>

        <div class="form-group">
          <label>Rating (1–5):</label>
          <select name="rating" required>
            <option value="">Select</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Feedback:</label>
          <textarea name="feedback" required placeholder="Write your feedback here..."></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Feedback</button>
      </form>
      <?php else: ?>
      <p class="no-contractor">⚠ You have not accepted any contractor yet.</p>
      <?php endif; ?>
    </div>
  </div>
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
