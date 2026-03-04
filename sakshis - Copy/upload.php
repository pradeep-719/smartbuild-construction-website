<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
if (!isset($_SESSION['email'])) {
    echo "User not logged in!";
    exit();
}

$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$user_email = $_SESSION['email'];

// Fetch contractor info
$query = "SELECT ProfileImage, CName FROM contractor WHERE Cemail='$user_email'";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $profileImageSrc = !empty($user_data['ProfileImage'])
        ? $user_data['ProfileImage']
        : "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";
    $contractor_name = $user_data['CName'];
} else {
    $profileImageSrc = "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";
    $contractor_name = "";
}

define('UPLOAD_DIR', 'uploads/');
if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0777, true);

$message = "";

// ✅ Upload Logic (unchanged)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker_id = trim($_POST['worker_id']); 
    $user_email_manual = trim($_POST['user_email']); 
    $description = trim($_POST['description']);

    if (empty($worker_id) || empty($description) || empty($user_email_manual)) {
        $message = "❌ Please fill all required fields.";
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid('img_', true) . '.' . $file_ext;
        $dest_path = UPLOAD_DIR . $new_file_name;

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($file_ext, $allowed_ext)) {
            if (move_uploaded_file($file_tmp_path, $dest_path)) {
                $log_datetime = date('Y-m-d H:i:s');
                $stmt = $conn->prepare("INSERT INTO track_updates (worker_id, contractor_email, user_email, image_filename, description, log_datetime) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $worker_id, $user_email, $user_email_manual, $new_file_name, $description, $log_datetime);
                if ($stmt->execute()) {
                    echo "<script>alert('✅ Work update submitted successfully!'); window.location.href='upload.php';</script>";
                    exit();
                } else {
                    $message = "❌ Database Error: " . $stmt->error;
                    unlink($dest_path);
                }
                $stmt->close();
            } else {
                $message = "❌ File upload failed!";
            }
        } else {
            $message = "❌ Invalid file type!";
        }
    } else {
        $message = "❌ Please select a valid image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Update | SmartBuild</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
    --primary-color: #ff6b4a;
    --secondary-color: #2c3e50;
    --light-gray: #f4f7f6;
    --dark-gray: #555;
    --white: #ffffff;
    --border-color: #e0e0e0;
}

/* BASE */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:var(--light-gray);color:var(--dark-gray);overflow-x:hidden;}

/* SIDEBAR */
.sidebar{
    width:250px;height:100vh;background:var(--secondary-color);
    color:white;position:fixed;top:0;left:0;padding:30px 20px;
    display:flex;flex-direction:column;z-index:1001;
    transition:transform 0.3s ease;
}
.sidebar h2{color:var(--primary-color);font-size:24px;margin-bottom:30px;}
.sidebar a{
    color:white;text-decoration:none;display:flex;align-items:center;
    gap:10px;padding:12px 10px;margin-bottom:8px;border-radius:6px;transition:0.3s;
}
.sidebar a:hover,.sidebar a.active{background:var(--primary-color);}
.sidebar a.logout{margin-top:auto;}

/* OVERLAY */
.overlay{
    display:none;position:fixed;top:0;left:0;width:100%;height:100%;
    background:rgba(0,0,0,0.4);z-index:1000;
}
.overlay.show{display:block;}

/* TOPBAR */
.topbar{
    position:fixed;top:0;left:250px;width:calc(100% - 250px);
    height:60px;background:var(--white);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);
    z-index:900;transition:left 0.3s ease,width 0.3s ease;
}
.topbar h1{font-size:1.2rem;color:var(--secondary-color);font-weight:700;}
#menu-toggle{
    background:none;border:none;font-size:1.6rem;
    color:var(--secondary-color);cursor:pointer;display:none;
}

/* MAIN */
.main{
    padding:100px 30px 30px 30px;margin-left:250px;
    transition:margin-left 0.3s ease;
}
.toggle-buttons{
    display:flex;justify-content:center;gap:15px;margin-bottom:25px;flex-wrap:wrap;
}
.toggle-btn{
    background:var(--secondary-color);color:white;padding:12px 20px;border:none;
    border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;
    transition:all 0.3s ease;
}
.toggle-btn.active,.toggle-btn:hover{background:var(--primary-color);}
.form-card,.progress-box{
    background:var(--white);border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    padding:30px 35px;max-width:900px;margin:auto;
}
.form-card h2,.progress-box h3{
    color:var(--primary-color);margin-bottom:20px;text-align:center;
}
form{
    display:grid;grid-template-columns:1fr 1fr;gap:20px 25px;
}
label{font-weight:600;color:#333;margin-bottom:6px;display:block;}
input[type="text"],input[type="email"],input[type="file"],textarea{
    width:100%;padding:10px 12px;border:1.5px solid #ddd;
    border-radius:8px;font-size:0.95rem;transition:0.3s;
}
input:focus,textarea:focus{border-color:var(--primary-color);outline:none;}
textarea{grid-column:span 2;resize:none;height:100px;}
button{
    grid-column:span 2;padding:12px 16px;background:var(--primary-color);
    color:#fff;border:none;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;
}
button:hover{background:#e65a3c;}
.info-note{grid-column:span 2;font-size:13px;color:#777;}
.hidden{display:none;}
.progress-box iframe{
    width:100%;min-height:600px;border:none;border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* RESPONSIVE */
@media(max-width:900px){
    #menu-toggle{display:block;}
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .overlay.show{display:block;}
    .topbar{left:0;width:100%;}
    .main{margin-left:0;padding:90px 20px;}
    form{grid-template-columns:1fr;}
    textarea,button,.info-note{grid-column:span 1;}
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h2>SmartBuild</h2>
    <a href="dashboards.php"><i class="fa-solid fa-chart-line"></i> Profile</a>
    <a href="response.php"><i class="fa-solid fa-comments"></i> User Response</a>
    <a href="upload.php" class="active"><i class="fa-solid fa-upload"></i> Upload Daily Status</a>
    <a href="docu.php"><i class="fa-solid fa-file-lines"></i> Documentation</a>
    <a href="conres.php"><i class="fa-solid fa-key"></i> Pass Reset</a>
    <a href="pro.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
    <a href="feedview.php"><i class="fa-solid fa-message"></i> Feedback View</a>
    <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay" id="overlay"></div>

<!-- TOPBAR -->
<div class="topbar">
    <h1>Work Update Panel</h1>
    <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
</div>

<!-- MAIN -->
<div class="main">
    <div class="toggle-buttons">
        <button class="toggle-btn active" id="uploadBtn">👷 Labour Progress Upload</button>
        <button class="toggle-btn" id="progressBtn">📊 View All Upload & Status</button>
    </div>

    <!-- Upload Form -->
    <div class="form-card" id="uploadSection">
        <h2>👷 Labour Progress Upload</h2>
        <?php if (!empty($message)): ?>
            <div style="color:red; text-align:center; margin-bottom:15px; font-weight:600;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div>
                <label>Contractor Name</label>
                <input type="text" name="worker_id" value="<?= htmlspecialchars($contractor_name) ?>" readonly>
            </div>
            <div>
                <label>User Email</label>
                <input type="email" name="user_email" placeholder="Enter user email" required>
            </div>
            <div>
                <label>Description</label>
                <textarea name="description" placeholder="Describe work progress..." required></textarea>
            </div>
            <div>
                <label>Image Proof (JPG/PNG/GIF)</label>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <p class="info-note">Note: Date & Time will be recorded automatically upon submission.</p>
            <button type="submit">Submit Work Update</button>
        </form>
    </div>

    <!-- Progress Section -->
    <div class="progress-box hidden" id="progressSection">
        <h3>📊 Contractor Progress Section</h3>
        <iframe src="userupload.php?email=<?= urlencode($user_email) ?>"></iframe>
    </div>
</div>

<script>
// Sidebar Toggle
const sidebar=document.getElementById("sidebar");
const overlay=document.getElementById("overlay");
const menuToggle=document.getElementById("menu-toggle");

menuToggle.addEventListener("click",()=>{
    sidebar.classList.toggle("open");
    overlay.classList.toggle("show");
});
overlay.addEventListener("click",()=>{
    sidebar.classList.remove("open");
    overlay.classList.remove("show");
});

// Section Toggle
const uploadBtn=document.getElementById("uploadBtn");
const progressBtn=document.getElementById("progressBtn");
const uploadSection=document.getElementById("uploadSection");
const progressSection=document.getElementById("progressSection");

uploadBtn.addEventListener("click",()=>{
    uploadBtn.classList.add("active");
    progressBtn.classList.remove("active");
    uploadSection.classList.remove("hidden");
    progressSection.classList.add("hidden");
});
progressBtn.addEventListener("click",()=>{
    progressBtn.classList.add("active");
    uploadBtn.classList.remove("active");
    progressSection.classList.remove("hidden");
    uploadSection.classList.add("hidden");
});
</script>
</body>
</html>
