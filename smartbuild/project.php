<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM admin WHERE Aemail='$email'";
$result = mysqli_query($conn, $query);
$profileImage = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result)['ProfileImage'] : "";
$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

// --- SESSION CHECK ---
if (!isset($_SESSION['email'])) {
    header("Location: adminlogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $targetDir = "uploads/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $sql = "INSERT INTO projects (title, description, image) VALUES ('$title', '$description', '$targetFilePath')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Project added successfully!'); window.location='project.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Image upload failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Project | SmartBuild</title>
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
.header {
  background:var(--white);
  display:flex; justify-content:space-between; align-items:center;
  padding:15px 25px; border-radius:14px;
  box-shadow:0 5px 15px var(--shadow);
  margin-bottom:35px;
}
.header h1 {color:var(--secondary); font-weight:700; font-size:1.5rem;}
.header img {
  width:45px; height:45px; border-radius:50%;
  border:2px solid var(--primary); object-fit:cover;
}

/* Upload Card */
.wrapper {
  max-width:700px; margin:auto; background:var(--white);
  border-radius:16px; box-shadow:0 8px 25px var(--shadow);
  padding:40px; text-align:center;
}
.wrapper h2 {
  color:var(--primary);
  margin-bottom:20px;
  font-weight:700;
  font-size:1.5rem;
}
.wrapper input[type="text"],
.wrapper textarea,
.wrapper input[type="file"] {
  width:100%;
  padding:12px;
  margin:10px 0;
  border:1px solid #ccc;
  border-radius:8px;
  font-size:15px;
  transition:0.3s;
}
.wrapper input:focus, .wrapper textarea:focus {
  border-color:var(--primary);
  box-shadow:0 0 0 2px rgba(255,123,0,0.2);
}
.wrapper textarea {
  resize:none;
  height:120px;
}
.wrapper button {
  width:100%;
  padding:12px;
  background:var(--primary);
  border:none;
  border-radius:8px;
  color:#fff;
  font-weight:600;
  font-size:16px;
  transition:0.3s;
}
.wrapper button:hover {
  background:#e67e00;
}
@media(max-width:900px){
  .sidebar{display:none;}
  .main{margin-left:0;padding:25px;}
  .wrapper{padding:25px;}
}
</style>
</head>

<body>
<!-- Sidebar -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="admindash.php"><i class='bx bx-grid-alt'></i> Dashboard</a>
  <a href="adform.php"><i class='bx bx-user'></i> Contractors</a>
  <a href="useer.php"><i class='bx bx-group'></i> Users</a>
  <a href="addoc.php"><i class='bx bx-file'></i> Documentation</a>
  <a href="resp.php"><i class='bx bx-reset'></i> Pass Reset</a>
  <a href="pros.php"><i class='bx bx-user-circle'></i> Profile</a>
  <a href="feed.php"><i class='bx bx-message-dots'></i> User Feedback</a>
  <a href="visitor.php"><i class='bx bx-file-find'></i> Acceptance Form</a>
  <a href="project.php" class="active"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php"><i class='bx bx-chat'></i> User Response</a>
  <a href="logs.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- Main -->
<div class="main">
  <div class="header">
    <h1>📤 Upload Project</h1>
    <img src="<?= $profileImageSrc ?>" alt="Profile">
  </div>

  <div class="wrapper">
    <h2>Add New Project</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Project Title" required>
      <textarea name="description" placeholder="Project Description" required></textarea>
      <input type="file" name="image" accept="image/*" required>
      <button type="submit">Upload</button>
    </form>
  </div>
</div>
</body>
</html>
