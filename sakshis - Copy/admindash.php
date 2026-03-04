<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "User not logged in!";
    exit();
}
$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) die("Connection failed: " . mysqli_connect_error());

$user_email = $_SESSION['email'];
$stmt = mysqli_prepare($con, "SELECT AName, Aemail, Address, Contact, DOB, ProfileImage, Country, State, Purpose, createdate FROM admin WHERE Aemail = ?");
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['AName'] ?? '';
    $email = $row['Aemail'] ?? '';
    $address = $row['Address'] ?? '';
    $contact = $row['Contact'] ?? '';
    $dob = $row['DOB'] ?? '';
    $purpose = $row['Purpose'] ?? '';
    $country = $row['Country'] ?? '';
    $state = $row['State'] ?? '';
    $createdate = $row['createdate'] ?? '';
    $profileCircleStyle = !empty($row['ProfileImage'])
        ? "background-image:url('" . htmlspecialchars($row['ProfileImage']) . "');"
        : "background-image:url('https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png');";
} else {
    $name = "Guest";
    $email = "N/A";
    $address = $contact = $dob = $purpose = $country = $state = $createdate = "N/A";
    $profileCircleStyle = "background-image:url('https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png');";
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($name) ?>'s Profile</title>
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
/* PROFILE CARD */
.profile-card{
  background:var(--white);
  border-radius:20px;
  box-shadow:0 8px 25px rgba(0,0,0,0.1);
  padding:40px;
  max-width:1000px;
  margin:auto;
}
.profile-header{
  text-align:center;
  margin-bottom:40px;
}
.profile-header .profile-img{
  width:130px;height:130px;
  border-radius:50%;
  background-size:cover;
  background-position:center;
  border:4px solid var(--primary);
  margin:auto;
  box-shadow:0 4px 15px rgba(0,0,0,0.2);
}
.profile-header h2{
  color:var(--secondary);
  margin-top:20px;
  font-size:1.8rem;
}
.profile-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:20px;
}
.profile-section{
  background:#fffaf5;
  border-left:5px solid var(--primary);
  border-radius:12px;
  padding:20px;
  transition:0.3s;
}
.profile-section:hover{transform:translateY(-5px);box-shadow:0 6px 18px rgba(0,0,0,0.1);}
.profile-section h3{
  font-size:1.1rem;
  color:var(--secondary);
  margin-bottom:10px;
  border-bottom:2px solid #ffe0b3;
  padding-bottom:5px;
}
.info-item{margin-bottom:10px;}
.info-item span{display:block;color:#333;font-size:0.95rem;}
.info-label{font-weight:600;color:var(--primary);}
.edit-btn{
  display:block;
  text-align:center;
  background:var(--secondary);
  color:#fff;
  padding:12px 18px;
  border-radius:8px;
  font-weight:600;
  text-decoration:none;
  margin-top:20px;
  transition:0.3s;
}
.edit-btn:hover{background:var(--primary);}
@media(max-width:900px){
  .main{margin-left:0;padding:25px;}
  .sidebar{display:none;}
}
</style>
</head>
<body>
<!-- SIDEBAR -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="admindash.php" class="active"><i class='bx bx-grid-alt'></i>Profile</a>
  <a href="adform.php"><i class='bx bx-group'></i> Contractors</a>
  <a href="useer.php"><i class='bx bx-user'></i> Users</a>
  <a href="addoc.php"><i class='bx bx-file'></i> Documentation</a>
  <a href="resp.php"><i class='bx bx-reset'></i> Pass Reset</a>
  <a href="pros.php" ><i class='bx bx-user-circle'></i> Profile</a>
  <a href="feed.php"><i class='bx bx-message-dots'></i> User Feedback</a>
  <a href="visitor.php"><i class='bx bx-file-find'></i> Acceptance Form</a>
  <a href="project.php"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php"><i class='bx bx-chat'></i> User Response</a>
  <a href="userlogouts.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- MAIN -->
<div class="main">
  <div class="profile-card">
    <div class="profile-header">
      <div class="profile-img" style="<?= $profileCircleStyle ?>"></div>
      <h2>Welcome, <?= htmlspecialchars($name) ?></h2>
    </div>
    <div class="profile-grid">
      <div class="profile-section">
        <h3>👤 Personal Information</h3>
        <div class="info-item"><span class="info-label">Email:</span><span><?= $email ?></span></div>
        <div class="info-item"><span class="info-label">Date of Birth:</span><span><?= $dob ?></span></div>
        <div class="info-item"><span class="info-label">Created:</span><span><?= $createdate ?></span></div>
      </div>

      <div class="profile-section">
        <h3>📍 Address Details</h3>
        <div class="info-item"><span class="info-label">Address:</span><span><?= $address ?></span></div>
        <div class="info-item"><span class="info-label">Country:</span><span><?= $country ?></span></div>
        <div class="info-item"><span class="info-label">State:</span><span><?= $state ?></span></div>
      </div>

      <div class="profile-section">
        <h3>📞 Contact Information</h3>
        <div class="info-item"><span class="info-label">Phone:</span><span><?= $contact ?></span></div>
        <div class="info-item"><span class="info-label">Purpose:</span><span><?= $purpose ?></span></div>
      </div>
    </div>

    <a href="profile.php?email=<?= urlencode($email) ?>" class="edit-btn"><i class="bx bx-edit"></i> Edit Profile</a>
  </div>
</div>

<script>

    const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.querySelector(".sidebar");
const themeToggle = document.getElementById("theme-toggle");

// Sidebar toggle for mobile
menuToggle.addEventListener("click",()=>{sidebar.classList.toggle("open");});

document.querySelector(".menuicn")?.addEventListener("click",()=>{
  document.querySelector(".navcontainer")?.classList.toggle("navclose");

});
</script>
</body>
</html>
