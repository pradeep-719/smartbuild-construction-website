<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$contractor_email = $_SESSION['email'];
$csql = "SELECT id, ProfileImage FROM contractor WHERE Cemail = ?";
$stmt = $conn->prepare($csql);
$stmt->bind_param("s", $contractor_email);
$stmt->execute();
$cresult = $stmt->get_result();
$contractor = $cresult->fetch_assoc();
$contractor_id = $contractor['id'];
$profileImageSrc = $contractor['ProfileImage'] ?? 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png';

$sql = "SELECT f.feedback_text, f.rating, u.UName, f.feedback_date 
        FROM feedbacks f 
        JOIN usertab u ON f.user_id = u.id 
        WHERE f.contractor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contractor_id);
$stmt->execute();
$feedbacks = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartBuild | User Feedbacks</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
  --primary: #ff6b4a;
  --secondary: #2c3e50;
  --light: #f4f7f6;
  --white: #ffffff;
}

/* RESET */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:var(--light);overflow-x:hidden;}

/* SIDEBAR */
.sidebar{
  width:250px;height:100vh;background:var(--secondary);
  color:#fff;position:fixed;top:0;left:0;display:flex;
  flex-direction:column;padding:30px 20px;z-index:1001;
  transition:transform 0.3s ease;
}
.sidebar h2{color:var(--primary);margin-bottom:30px;font-size:24px;}
.sidebar a{
  color:#fff;text-decoration:none;padding:12px 10px;margin-bottom:8px;
  display:flex;align-items:center;gap:10px;border-radius:6px;
  transition:0.3s;
}
.sidebar a:hover,.sidebar a.active{background:var(--primary);}
.sidebar a.logout{margin-top:auto;}

/* OVERLAY */
.overlay{
  display:none;position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.5);z-index:1000;
}
.overlay.show{display:block;}

/* TOPBAR */
.topbar{
  width:100%;height:60px;background:var(--white);
  position:fixed;top:0;left:0;display:flex;
  align-items:center;justify-content:space-between;
  padding:0 20px;box-shadow:0 3px 10px rgba(0,0,0,0.1);
  z-index:900;
}
.topbar h1{color:var(--secondary);font-size:1.2rem;font-weight:700;}
#menu-toggle{
  background:none;border:none;font-size:1.6rem;
  color:var(--secondary);cursor:pointer;display:none;
}

/* MAIN */
.main{
  padding:100px 20px;margin-left:250px;transition:margin-left 0.3s ease;
}

/* FEEDBACK CONTAINER */
.feedback-container {
  background:var(--white);
  border-radius:20px;
  box-shadow:0 8px 25px rgba(0,0,0,0.1);
  padding:40px;
  max-width:1100px;
  margin:auto;
  transition:0.3s;
}
.feedback-container:hover {transform:translateY(-3px);}
.feedback-container h2 {
  text-align:center;
  color:var(--secondary);
  font-size:1.8rem;
  border-bottom:3px solid var(--primary);
  padding-bottom:10px;
  margin-bottom:30px;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
}

/* GRID FEEDBACK CARDS */
.feedback-grid {
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:20px;
}
.feedback-card {
  background:#fffaf5;
  border-left:6px solid var(--primary);
  border-radius:12px;
  padding:20px;
  box-shadow:0 4px 12px rgba(0,0,0,0.1);
  transition:all 0.3s ease;
}
.feedback-card:hover {
  transform:translateY(-5px);
  box-shadow:0 6px 18px rgba(0,0,0,0.15);
}
.feedback-header {
  display:flex;
  align-items:center;
  justify-content:space-between;
  margin-bottom:10px;
}
.feedback-header h3 {
  color:var(--secondary);
  font-size:1.1rem;
}
.feedback-header span {
  background:var(--primary);
  color:#fff;
  font-size:0.9rem;
  padding:5px 10px;
  border-radius:6px;
}
.feedback-text {
  color:#444;
  font-size:0.95rem;
  margin:10px 0;
  line-height:1.5;
}
.feedback-footer {
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-top:15px;
  font-size:0.85rem;
  color:#777;
}
.rating {
  color:#ff7b00;
  font-weight:600;
}

/* RESPONSIVE */
@media(max-width:900px){
  #menu-toggle{display:block;}
  .sidebar{transform:translateX(-100%);}
  .sidebar.open{transform:translateX(0);}
  .overlay.show{display:block;}
  .main{margin-left:0;padding:90px 15px;}
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
  <h2>SmartBuild</h2>
  <a href="dashboards.php"><i class="fa-solid fa-chart-line"></i> Profile</a>
  <a href="response.php"><i class="fa-solid fa-comments"></i> User Response</a>
  <a href="upload.php"><i class="fa-solid fa-upload"></i> Upload Daily Status</a>
  <a href="docu.php"><i class="fa-solid fa-file-lines"></i> Documentation</a>
  <a href="conres.php"><i class="fa-solid fa-key"></i> Pass Reset</a>
  <a href="pro.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
  <a href="feedview.php" class="active"><i class="fa-solid fa-message"></i> Feedback View</a>
  <a href="userlogouts.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay" id="overlay"></div>

<!-- TOPBAR -->
<div class="topbar">
  <h1>📢 User Feedbacks</h1>
  <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
</div>

<!-- MAIN -->
<div class="main">
  <div class="feedback-container">
    <h2><i class="fa-solid fa-comments"></i> User Feedbacks</h2>

    <div class="feedback-grid">
      <?php if ($feedbacks->num_rows > 0): ?>
        <?php while ($row = $feedbacks->fetch_assoc()): ?>
          <div class="feedback-card">
            <div class="feedback-header">
              <h3><?= htmlspecialchars($row['UName']) ?></h3>
              <span><?= htmlspecialchars($row['feedback_date']) ?></span>
            </div>
            <div class="feedback-text">
              <?php
                $text = htmlspecialchars($row['feedback_text']);
                echo nl2br(wordwrap($text, 80, "\n", true));
              ?>
            </div>
            <div class="feedback-footer">
              <div class="rating">⭐ <?= htmlspecialchars($row['rating']) ?>/5</div>
              <div>📅 <?= date("d M Y", strtotime($row['feedback_date'])) ?></div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center;font-weight:600;color:#555;">No feedback yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
const sidebar=document.getElementById('sidebar');
const overlay=document.getElementById('overlay');
const menuToggle=document.getElementById('menu-toggle');

menuToggle.addEventListener('click',()=>{
  sidebar.classList.toggle('open');
  overlay.classList.toggle('show');
});
overlay.addEventListener('click',()=>{
  sidebar.classList.remove('open');
  overlay.classList.remove('show');
});
</script>

</body>
</html>
