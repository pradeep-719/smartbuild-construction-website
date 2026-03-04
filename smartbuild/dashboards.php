<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); // ✅ Correct India Timezone Set
if (!isset($_SESSION['email'])) {
    echo "User not logged in!";
    exit();
}

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_email = $_SESSION['email'] ?? null;
if (!$user_email) {
    header("Location: registr.php");
    exit();
}

$user_email_escaped = mysqli_real_escape_string($con, $user_email);

// ✅ Fetch with new columns included
$stmt = mysqli_prepare($con, "SELECT 
    CName, Cemail, Address, Contact, DOB, ProfileImage, Country, State, Purpose, createdate,
    AadharProof, PanProof, ExperienceYears, ExperienceProof 
    FROM contractor WHERE Cemail = ?");

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $user_email_escaped);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign variables
        $name = htmlspecialchars($row['CName'] ?? '');
        $email = htmlspecialchars($row['Cemail'] ?? '');
        $address = htmlspecialchars($row['Address'] ?? 'N/A');
        $contact = htmlspecialchars($row['Contact'] ?? 'N/A');
        $dob = htmlspecialchars($row['DOB'] ?? 'N/A');
        $purpose = htmlspecialchars($row['Purpose'] ?? 'N/A');
        $createdate = htmlspecialchars($row['createdate'] ?? 'N/A');
        $country = htmlspecialchars($row['Country'] ?? 'N/A');
        $state = htmlspecialchars($row['State'] ?? 'N/A');
        $aadhar = htmlspecialchars($row['AadharProof'] ?? '');
        $pan = htmlspecialchars($row['PanProof'] ?? '');
        $experience_years = htmlspecialchars($row['ExperienceYears'] ?? '');
        $experience_proof = htmlspecialchars($row['ExperienceProof'] ?? '');
        if (!empty($row['ProfileImage'])) {
            $profileImage = htmlspecialchars($row['ProfileImage']);
        } else {
            $profileImage = "https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png";
        }

    } else {
        $name = "Guest";
        $email = $address = $contact = $dob = $purpose = $country = $state = $createdate = "N/A";
        $aadhar = $pan = $experience_proof = "";
        $experience_years = "";
        $profileImage = "https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png";
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($name); ?> | Contractor Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
    --primary-color: #ff6b4a;
    --secondary-color: #2c3e50;
    --light-gray: #f4f7f6;
    --dark-gray: #555;
    --white: #ffffff;
    --border-color: #e0e0e0;
    --shadow: 0 6px 18px rgba(0,0,0,0.08);
}

/* ===== GLOBAL ===== */
* {margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif;}
body {display: flex; background: var(--light-gray); color: var(--dark-gray); overflow-x: hidden;}
.dashboard-container {display: flex; min-height: 100vh;}

/* ===== SIDEBAR ===== */
.sidebar {
  width: 250px;
  height: 100vh;
  background: var(--secondary-color);
  padding: 30px 20px;
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  z-index: 1000;
  transform: translateX(0);
  transition: transform 0.3s ease;
}
.sidebar.closed {transform: translateX(-100%);}
.sidebar.open {transform: translateX(0);}
.sidebar h2 {
  color: var(--primary-color);
  font-size: 24px;
  margin-bottom: 30px;
}
.sidebar a {
  display: flex;
  align-items: center;
  gap: 10px;
  color: white;
  text-decoration: none;
  padding: 12px 10px;
  margin-bottom: 8px;
  border-radius: 6px;
  transition: 0.3s;
}
.sidebar a:hover, .sidebar a.active {background: var(--primary-color);}
.sidebar a.logout {margin-top: auto;}

/* ===== OVERLAY ===== */
.overlay {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 999;
}
.overlay.show {display: block;}

/* ===== MAIN CONTENT ===== */
.main {
  flex: 1;
  padding: 30px;
  margin-left: 250px;
  transition: margin-left 0.3s ease;
}
.main-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}
.main-header h1 {
  color: var(--secondary-color);
  font-size: 1.8rem;
  font-weight: 700;
}
#menu-toggle {
  display: none;
  background: none;
  border: none;
  font-size: 1.8rem;
  color: var(--secondary-color);
  cursor: pointer;
}

/* ===== PROFILE CARD ===== */
.profile-card {
  background: var(--white);
  border-radius: 12px;
  box-shadow: var(--shadow);
  max-width: 900px;
  width: 100%;
}
.profile-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  padding: 25px 30px;
  border-bottom: 1px solid var(--border-color);
}
.header-left {display: flex; align-items: center; gap: 20px;}
.header-icon {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 4px solid var(--primary-color);
  object-fit: cover;
}
.header-text h2 {color: var(--secondary-color); font-size: 1.8rem; margin: 0;}
.header-text p {color: var(--dark-gray); margin: 5px 0;}
.edit-profile-btn {
  display: inline-block;
  background: var(--primary-color);
  color: #fff;
  padding: 10px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}
.edit-profile-btn:hover {background: #e65a3c;}

.profile-body {padding: 30px;}
.details-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}
.detail-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}
.detail-item .icon {
  font-size: 1.2rem;
  color: var(--primary-color);
  width: 20px;
  text-align: center;
}
.detail-item .text .label {
  display: block;
  font-weight: 600;
  color: #333;
}
.detail-item .text .value {color: var(--dark-gray);}
.document-link {
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 500;
}
.document-link:hover {text-decoration: underline;}

/* ===== RESPONSIVE ===== */
@media(max-width: 900px) {
  #menu-toggle {display: block;}
  .sidebar {transform: translateX(-100%);}
  .sidebar.open {transform: translateX(0);}
  .overlay.show {display: block;}
  .main {margin-left: 0; padding: 20px;}
  .details-grid {grid-template-columns: 1fr;}
  .profile-header {flex-direction: column; align-items: flex-start;}
}
</style>
</head>

<body>
<!-- SIDEBAR -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="dashboards.php" class="active"><i class="fa-solid fa-chart-line"></i> Profile</a>
  <a href="response.php"><i class="fa-solid fa-comments"></i> User Response</a>
  <a href="upload.php"><i class="fa-solid fa-upload"></i> Upload Daily Status</a>
  <a href="docu.php"><i class="fa-solid fa-file-lines"></i> Documentation</a>
  <a href="conres.php"><i class="fa-solid fa-key"></i> Pass Reset</a>
  <a href="pro.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
  <a href="feedview.php"><i class="fa-solid fa-message"></i> Feedback View</a>
  <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay"></div>

<!-- MAIN CONTENT -->
<div class="main">
  <header class="main-header">
    <h1>Contractor Dashboard</h1>
    <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
  </header>

  <div class="profile-card">
    <div class="profile-header">
      <div class="header-left">
        <img src="<?php echo $profileImage; ?>" alt="Profile" class="header-icon">
        <div class="header-text">
          <h2><?php echo $name; ?></h2>
          <p>Welcome to your Contractor Profile</p>
        </div>
      </div>
      <a href="pro.php?email=<?php echo urlencode($email); ?>" class="edit-profile-btn">
        <i class="fa-solid fa-pen-to-square"></i> Edit Profile
      </a>
    </div>

    <div class="profile-body">
      <div class="details-grid">
        <div class="detail-item"><i class="fa-solid fa-envelope icon"></i><div class="text"><span class="label">Email</span><span class="value"><?php echo $email; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-phone icon"></i><div class="text"><span class="label">Contact</span><span class="value"><?php echo $contact; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-map-marker-alt icon"></i><div class="text"><span class="label">Address</span><span class="value"><?php echo $address; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-calendar icon"></i><div class="text"><span class="label">DOB</span><span class="value"><?php echo $dob; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-flag icon"></i><div class="text"><span class="label">Country</span><span class="value"><?php echo $country; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-city icon"></i><div class="text"><span class="label">State</span><span class="value"><?php echo $state; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-user-tie icon"></i><div class="text"><span class="label">Purpose</span><span class="value"><?php echo $purpose; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-id-card icon"></i><div class="text"><span class="label">Aadhaar Proof</span><span class="value"><?php echo $aadhar ? "<a href='$aadhar' target='_blank' class='document-link'>View Aadhaar</a>" : "Not Uploaded"; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-id-badge icon"></i><div class="text"><span class="label">PAN Proof</span><span class="value"><?php echo $pan ? "<a href='$pan' target='_blank' class='document-link'>View PAN</a>" : "Not Uploaded"; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-briefcase icon"></i><div class="text"><span class="label">Experience</span><span class="value"><?php echo $experience_years ? $experience_years.' years' : 'Not Provided'; ?> <?php if($experience_proof) echo " | <a href='$experience_proof' target='_blank' class='document-link'>View Proof</a>"; ?></span></div></div>
        <div class="detail-item"><i class="fa-solid fa-calendar-check icon"></i><div class="text"><span class="label">Created On</span><span class="value"><?php echo $createdate; ?></span></div></div>
      </div>
    </div>
  </div>
</div>

<script>
// Sidebar toggle for mobile
const sidebar = document.querySelector('.sidebar');
const menuToggle = document.getElementById('menu-toggle');
const overlay = document.querySelector('.overlay');

menuToggle.addEventListener('click', () => {
  sidebar.classList.toggle('open');
  overlay.classList.toggle('show');
});

overlay.addEventListener('click', () => {
  sidebar.classList.remove('open');
  overlay.classList.remove('show');
});
</script>
</body>
</html>