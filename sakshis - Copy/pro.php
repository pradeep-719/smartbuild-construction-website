<?php
date_default_timezone_set('Asia/Kolkata');
session_start();

$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_SESSION['email'])) {
    header("Location: registr.php");
    exit();
}

$user_email = $_SESSION['email'];
$message = "";

// --- Handle Profile Update ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $dob = trim($_POST['dob']);
    $purpose = trim($_POST['purpose']);
    $address = trim($_POST['address']);
    $phone_no = trim($_POST['phone_no']);
    $country = trim($_POST['Country']);
    $state = trim($_POST['State']);
    $experience_years = trim($_POST['experience_years']);

    $profileDir = "profile_uploads/";
    $proofDir = "proof_uploads/";
    if (!is_dir($profileDir)) mkdir($profileDir, 0777, true);
    if (!is_dir($proofDir)) mkdir($proofDir, 0777, true);

    function uploadFile($fileField, $targetDir) {
        if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES[$fileField]['tmp_name'];
            $fileName = basename($_FILES[$fileField]['name']);
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
            if (in_array($ext, $allowed)) {
                $newName = uniqid("proof_") . "." . $ext;
                $dest = $targetDir . $newName;
                if (move_uploaded_file($fileTmp, $dest)) return $dest;
            }
        }
        return "";
    }

    $profileImage = uploadFile("photo_upload", $profileDir);
    $aadharProof = uploadFile("aadhar_proof", $proofDir);
    $panProof = uploadFile("pan_proof", $proofDir);
    $expProof = uploadFile("experience_proof", $proofDir);

    $stmt = $conn->prepare("UPDATE contractor SET 
        CName=?, DOB=?, Purpose=?, Address=?, Contact=?, Country=?, State=?, 
        ProfileImage=IF(?='', ProfileImage, ?),
        AadharProof=IF(?='', AadharProof, ?),
        PanProof=IF(?='', PanProof, ?),
        ExperienceYears=?, 
        ExperienceProof=IF(?='', ExperienceProof, ?)
        WHERE Cemail=?");

    $stmt->bind_param(
        "sssssssssssssssss",
        $username, $dob, $purpose, $address, $phone_no, $country, $state,
        $profileImage, $profileImage,
        $aadharProof, $aadharProof,
        $panProof, $panProof,
        $experience_years,
        $expProof, $expProof,
        $user_email
    );

    $message = $stmt->execute() ? "✅ Profile updated successfully!" : "❌ Error: " . $stmt->error;
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM contractor WHERE Cemail=?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartBuild | Contractor Profile</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
:root {
    --primary: #ff6b4a;
    --secondary: #2c3e50;
    --light: #f4f7f6;
    --white: #fff;
    --shadow: 0 6px 20px rgba(0,0,0,0.07);
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
  padding:100px 20px;margin-left:250px;display:flex;
  justify-content:center;align-items:flex-start;transition:margin-left 0.3s ease;
}

/* PROFILE CARD */
.profile-card{
  background:var(--white);border-radius:16px;box-shadow:var(--shadow);
  width:100%;max-width:850px;padding:40px;
}
.profile-card h1{
  text-align:center;color:var(--secondary);margin-bottom:20px;
  border-bottom:3px solid var(--primary);padding-bottom:10px;
}
.message-box{
  background:#f8f8f8;border-left:5px solid var(--primary);
  padding:10px;border-radius:6px;margin-bottom:20px;text-align:center;
}
.profile-form{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;}
.form-group{display:flex;flex-direction:column;}
.form-group label{font-weight:600;color:#333;margin-bottom:6px;}
.form-group input,.form-group textarea{
  padding:10px;border:1px solid #ccc;border-radius:8px;
  background:#fafafa;transition:0.3s;font-size:0.95rem;
}
.form-group input:focus,textarea:focus{border-color:var(--primary);}
textarea{resize:none;height:80px;}
small a{color:var(--primary);text-decoration:none;}
small a:hover{text-decoration:underline;}
.profile-photo-section{text-align:center;grid-column:1/-1;margin-bottom:10px;}
.profile-photo{width:140px;height:140px;border-radius:50%;
overflow:hidden;margin:0 auto 10px;border:4px solid var(--primary);
box-shadow:0 2px 8px rgba(0,0,0,0.1);}
.profile-photo img{width:100%;height:100%;object-fit:cover;}
.upload-btn{
  background:var(--primary);color:white;padding:8px 14px;
  border-radius:6px;cursor:pointer;transition:0.3s;
}
.upload-btn:hover{background:#e65a3c;}
.form-buttons{grid-column:1/-1;text-align:right;margin-top:10px;}
.btn{padding:10px 20px;border:none;border-radius:8px;cursor:pointer;font-weight:600;}
.update-btn{background:var(--primary);color:white;}
.update-btn:hover{background:#e65a3c;}
.cancel-btn{background:#555;color:white;}
.cancel-btn:hover{background:#333;}

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
  <a href="pro.php" class="active"><i class="fa-solid fa-user"></i> Edit Profile</a>
  <a href="feedview.php"><i class="fa-solid fa-message"></i> Feedback View</a>
  <a href="userlogouts.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay" id="overlay"></div>

<!-- TOPBAR -->
<div class="topbar">
  <h1>👷 Contractor Profile</h1>
  <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
</div>

<!-- MAIN -->
<div class="main">
  <div class="profile-card">
    <h1>Contractor Profile</h1>

    <?php if (!empty($message)): ?>
      <div class="message-box"><?= $message; ?></div>
    <?php endif; ?>

    <form class="profile-form" method="POST" enctype="multipart/form-data">

      <div class="profile-photo-section">
        <div class="profile-photo">
          <img id="profile-image" src="<?= htmlspecialchars($user_data['ProfileImage'] ?? 'https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png'); ?>" alt="Profile">
        </div>
        <label for="photo-upload" class="upload-btn"><i class="fa-solid fa-camera"></i> Upload New Photo</label>
        <input type="file" id="photo-upload" name="photo_upload" accept="image/*" style="display:none;">
      </div>

      <div class="form-group"><label>Username *</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user_data['CName'] ?? ''); ?>" required></div>

      <div class="form-group"><label>D.O.B *</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($user_data['DOB'] ?? ''); ?>" required></div>

      <div class="form-group"><label>Requirements *</label>
        <textarea name="purpose" required><?= htmlspecialchars($user_data['Purpose'] ?? ''); ?></textarea></div>

      <div class="form-group"><label>Address *</label>
        <textarea name="address" required><?= htmlspecialchars($user_data['Address'] ?? ''); ?></textarea></div>

      <div class="form-group"><label>Phone No *</label>
        <input type="tel" name="phone_no" maxlength="10" value="<?= htmlspecialchars($user_data['Contact'] ?? ''); ?>" required></div>

      <div class="form-group"><label>Country *</label>
        <input type="text" name="Country" value="<?= htmlspecialchars($user_data['Country'] ?? ''); ?>" required></div>

      <div class="form-group"><label>State *</label>
        <input type="text" name="State" value="<?= htmlspecialchars($user_data['State'] ?? ''); ?>" required></div>

      <div class="form-group">
        <label>Aadhaar Proof</label>
        <input type="file" name="aadhar_proof" accept="image/*,.pdf">
        <?php if (!empty($user_data['AadharProof'])): ?>
          <small>Uploaded: <a href="<?= htmlspecialchars($user_data['AadharProof']); ?>" target="_blank">View Aadhaar</a></small>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>PAN Proof</label>
        <input type="file" name="pan_proof" accept="image/*,.pdf">
        <?php if (!empty($user_data['PanProof'])): ?>
          <small>Uploaded: <a href="<?= htmlspecialchars($user_data['PanProof']); ?>" target="_blank">View PAN</a></small>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>Experience (Years)</label>
        <input type="text" name="experience_years" value="<?= htmlspecialchars($user_data['ExperienceYears'] ?? ''); ?>">
      </div>

      <div class="form-group">
        <label>Experience Proof (Optional)</label>
        <input type="file" name="experience_proof" accept="image/*,.pdf">
        <?php if (!empty($user_data['ExperienceProof'])): ?>
          <small>Uploaded: <a href="<?= htmlspecialchars($user_data['ExperienceProof']); ?>" target="_blank">View Proof</a></small>
        <?php endif; ?>
      </div>

      <div class="form-buttons">
        <button type="submit" class="btn update-btn"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        <button type="button" class="btn cancel-btn" onclick="window.location.href='dashboards.php'"><i class="fa-solid fa-xmark"></i> Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('photo-upload').addEventListener('change', (event)=>{
  const file=event.target.files[0];
  if(file){
    const reader=new FileReader();
    reader.onload=(e)=>document.getElementById('profile-image').src=e.target.result;
    reader.readAsDataURL(file);
  }
});

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
