<?php
session_start();

// --- 1. Check if contractor logged in ---
if (!isset($_SESSION['email'])) {
    echo "Contractor not logged in!";
    exit();
}

// --- 2. Connect Database ---
$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// --- 3. Get contractor info ---
$contractor_email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM contractor WHERE Cemail='$contractor_email'";
$result = mysqli_query($con, $query);
$profileImage = ($result && mysqli_num_rows($result) > 0)
    ? mysqli_fetch_assoc($result)['ProfileImage']
    : "";
$profileImageSrc = $profileImage ?: "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";

$contractor_email_escaped = mysqli_real_escape_string($con, $contractor_email);
$contractor_query = mysqli_query($con, "SELECT id, CName, Cemail FROM contractor WHERE Cemail = '$contractor_email_escaped'");
if ($contractor_query && mysqli_num_rows($contractor_query) > 0) {
    $contractor = mysqli_fetch_assoc($contractor_query);
    $contractor_id = $contractor['id'];
    $contractor_name = $contractor['CName'];
    $contractor_email = $contractor['Cemail'];
} else {
    echo "Contractor not found in database!";
    exit();
}

$check_form = mysqli_query($con, "SELECT visit_form_filled FROM contractor WHERE Cemail='$contractor_email'");
$form_data = mysqli_fetch_assoc($check_form);
$form_filled = $form_data['visit_form_filled'];

// --- 4. Handle signed PDF upload ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_signed_pdf'])) {
    $user_email = $_POST['user_email'];
    $targetDir = "signed_uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName = basename($_FILES["signed_pdf"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($_FILES["signed_pdf"]["name"])) {
        if (strtolower($fileType) == "pdf") {
            if (move_uploaded_file($_FILES["signed_pdf"]["tmp_name"], $targetFilePath)) {
                $insert = mysqli_query($con, "
                    INSERT INTO signed_pdfs (user_email, contractor_email, file_path)
                    VALUES ('$user_email', '$contractor_email', '$targetFilePath')");
                echo $insert
                    ? "<script>alert('✅ Signed PDF uploaded successfully!');</script>"
                    : "<script>alert('❌ Database insert failed!');</script>";
            } else echo "<script>alert('❌ File upload failed!');</script>";
        } else echo "<script>alert('❌ Only PDF files allowed!');</script>";
    } else echo "<script>alert('⚠️ Please choose a PDF file!');</script>";
}

// --- 5. Fetch uploaded PDFs ---
$query = "
    SELECT d.id, d.file_path, d.upload_date, u.UName, u.Uemail
    FROM documents d
    JOIN usertab u ON d.user_id = u.id
    WHERE d.contractor_id = '$contractor_id'
    ORDER BY d.upload_date DESC
";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartBuild | Contractor Documents</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
  --primary-color: #ff6b4a;
  --secondary-color: #2c3e50;
  --light-gray: #f4f7f6;
  --white: #ffffff;
  --border-color: #e0e0e0;
}

/* BASE */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:var(--light-gray);color:#444;overflow-x:hidden;}

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
.topbar h1{font-size:1.1rem;color:var(--secondary-color);font-weight:700;}
#menu-toggle{
  background:none;border:none;font-size:1.6rem;
  color:var(--secondary-color);cursor:pointer;display:none;
}

/* MAIN */
.main{
  padding:100px 30px 30px 30px;margin-left:250px;
  transition:margin-left 0.3s ease;
}
h1{color:var(--secondary-color);margin-bottom:10px;}

/* MODERN CARDS */
.card-container{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
  gap:25px;
}
.card{
  background:var(--white);
  border-radius:14px;
  box-shadow:0 6px 16px rgba(0,0,0,0.08);
  padding:25px 25px 30px;
  border-top:4px solid var(--primary-color);
  transition:all 0.3s ease;
}
.card:hover{
  transform:translateY(-5px);
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
}
.card-header{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:10px;
}
.card-header h3{
  color:var(--secondary-color);
  font-size:1.1rem;font-weight:600;
}
.card p{font-size:0.9rem;margin:6px 0;}
.label{font-weight:600;color:#333;}

.pdf-link{
  background:var(--primary-color);
  color:white;
  padding:6px 14px;
  border-radius:6px;
  text-decoration:none;
  font-weight:600;
  font-size:0.9rem;
  display:inline-block;
  margin-top:5px;
  transition:0.3s;
}
.pdf-link:hover{background:#e65a3c;}

form{
  margin-top:15px;
  border-top:1px solid #eee;
  padding-top:15px;
}
input[type=file]{
  width:100%;
  margin-top:8px;
  padding:10px;
  border:1px solid var(--border-color);
  border-radius:6px;
  font-size:0.9rem;
  background:#fafafa;
}
button{
  margin-top:12px;
  width:100%;
  background:var(--primary-color);
  color:white;
  border:none;
  padding:10px 16px;
  border-radius:8px;
  font-size:1rem;
  font-weight:600;
  cursor:pointer;
  transition:0.3s;
}
button:hover{background:#e65a3c;}

/* RESPONSIVE */
@media(max-width:900px){
  #menu-toggle{display:block;}
  .sidebar{transform:translateX(-100%);}
  .sidebar.open{transform:translateX(0);}
  .overlay.show{display:block;}
  .topbar{left:0;width:100%;}
  .main{margin-left:0;padding:90px 20px;}
  .card-container{grid-template-columns:1fr;}
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
    <a href="docu.php" class="active"><i class="fa-solid fa-file-lines"></i> Documentation</a>
    <a href="conres.php"><i class="fa-solid fa-key"></i> Pass Reset</a>
    <a href="pro.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
    <a href="feedview.php"><i class="fa-solid fa-message"></i> Feedback View</a>
    <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay" id="overlay"></div>

<!-- TOPBAR -->
<div class="topbar">
  <h1>📄 Contractor Document Management</h1>
  <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
</div>

<!-- MAIN -->
<div class="main">
  <div class="card-container">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
          <div class="card-header">
            <h3>👤 <?= htmlspecialchars($row['UName']) ?></h3>
          </div>
          <p><span class="label">📧 User Email:</span> <?= htmlspecialchars($row['Uemail']) ?></p>
          <p><span class="label">📄 Original PDF:</span> <br>
            <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank" class="pdf-link">View PDF</a>
          </p>
          <p><span class="label">🕓 Uploaded On:</span> <?= htmlspecialchars($row['upload_date']) ?></p>
          
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_email" value="<?= htmlspecialchars($row['Uemail']) ?>">
            <label class="label">✍️ Upload Signed Agreement (PDF):</label>
            <input type="file" name="signed_pdf" accept=".pdf" required>
            <button type="submit" name="upload_signed_pdf"><i class="fa-solid fa-upload"></i> Submit</button>
          </form>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center;font-weight:600;">No documents uploaded yet for you.</p>
    <?php endif; ?>
  </div>
</div>

<script>
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
</script>
</body>
</html>
