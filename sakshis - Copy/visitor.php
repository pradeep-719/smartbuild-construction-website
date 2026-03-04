<?php
session_start();

// --- DATABASE CONNECTION ---
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM admin WHERE Aemail='$email'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $profileImage = $user_data['ProfileImage'];
} else {
    $profileImage = "";
}
$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

// --- SESSION CHECK ---
if (!isset($_SESSION['email'])) {
    header("Location: adminlogin.php");
    exit();
}

// --- DELETE RECORD ---
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $getData = $conn->query("SELECT contractor_email, user_email FROM visit_form WHERE id='$id'");
    $row = $getData->fetch_assoc();
    $contractor_email = $row['contractor_email'];
    $contractor_name = strstr($contractor_email, '@', true);

    $conn->query("DELETE FROM visit_form WHERE id='$id'");
    $conn->query("DELETE FROM user_contractor_status WHERE contractor_name='$contractor_name' AND status='accept'");
    $conn->query("UPDATE contractor SET visit_form_filled=0 WHERE Cemail='$contractor_email'");

    echo "<script>alert('Data Deleted! Admin Action = Rejected Updated in Both Tables');window.location='visitor.php';</script>";
}

$sql = "SELECT vf.*, ucs.status, ucs.contractor_name 
        FROM visit_form vf 
        LEFT JOIN user_contractor_status ucs 
        ON vf.contractor_email LIKE CONCAT(ucs.contractor_name, '%')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acceptance Form | SmartBuild</title>
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
.header{background:var(--white);border-radius:14px;padding:15px 25px;
  display:flex;justify-content:space-between;align-items:center;
  box-shadow:0 5px 15px var(--shadow);margin-bottom:35px;}
.header h1{color:var(--secondary);font-size:1.5rem;font-weight:700;}
.header img{width:45px;height:45px;border-radius:50%;border:2px solid var(--primary);object-fit:cover;}

/* Card Container */
.card {
  background: var(--white);
  border-radius: 20px;
  padding: 25px;
  box-shadow: 0 6px 20px var(--shadow);
  transition: 0.3s;
}
.card:hover {transform: scale(1.01);}
.card h2 {color: var(--primary); text-align: center; margin-bottom: 15px;}

/* Buttons */
.button-container {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-bottom: 15px;
}
button.view {
  background: var(--primary);
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}
button.view:hover {background: #e67e00; transform: scale(1.05);}
.btn-del {
  background: #ff4d4d;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
}
.btn-del:hover {background: #d93636;}

/* Table */
table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 12px;
  overflow: hidden;
}
thead {background: var(--primary); color: white;}
th, td {
  padding: 10px 14px;
  text-align: left;
  border-bottom: 1px solid #eee;
  font-size: 0.95rem;
}
tbody tr:hover {background: #f9f9f9;}
td img {
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}
td img:hover {transform: scale(1.1);}

/* Zoom Modal */
#zoomBox {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.8);
  text-align: center;
  z-index: 9999;
}
#closeBtn {
  position: fixed;
  top: 15px; right: 25px;
  color: #fff;
  font-size: 45px;
  font-weight: bold;
  cursor: pointer;
  z-index: 10000;
  background: rgba(0, 0, 0, 0.3);
  border-radius: 5px;
  padding: 0 10px;
}
#zoomedImg {
  max-width: 90%;
  max-height: 90%;
  margin-top: 4%;
  border: 3px solid white;
  border-radius: 8px;
  cursor: pointer;
}

@media(max-width:900px){
  .sidebar {display:none;}
  .main {margin-left:0;padding:25px;}
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
  <a href="feed.php"><i class='bx bx-message-dots'></i> Feedback</a>
  <a href="visitor.php" class="active"><i class='bx bx-file-find'></i> Acceptance Form</a>
  <a href="project.php"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php"><i class='bx bx-chat'></i> User Response</a>
  <a href="logs.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- Main -->
<div class="main">
  <div class="header">
    <h1>📋 Acceptance & Visit Form Data</h1>
    <img src="<?= $profileImageSrc ?>" alt="Profile">
  </div>

  <div class="card">
    <div class="button-container">
      <button id="view-all-btn" class="view">View All</button>
      <button id="download-btn" class="view">Download</button>
    </div>

    <h2>Visit Form & Contractor Status</h2>
    <table id="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Contractor Email</th>
          <th>User Email</th>
          <th>Cost</th>
          <th>User Decision</th>
          <th>UPI</th>
          <th>Contractor Name</th>
          <th>Status</th>
          <th>Photo</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['contractor_email'] ?></td>
          <td><?= $row['user_email'] ?></td>
          <td><?= $row['cost'] ?></td>
          <td><?= $row['user_decision'] ?></td>
          <td><?= $row['upi'] ?></td>
          <td><?= $row['contractor_name'] ?: 'N/A' ?></td>
          <td><?= $row['status'] ?: 'N/A' ?></td>
          <td><img src="<?= htmlspecialchars($row['photo']) ?>" width="60" height="40" onclick="zoomImage(this)"></td>
          <td><a href="?delete_id=<?= $row['id'] ?>"><button class="btn-del">Delete</button></a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Zoom Modal -->
<div id="zoomBox">
  <span id="closeBtn" onclick="closeZoom()">&times;</span>
  <img id="zoomedImg" onclick="closeZoom()">
</div>

<script>
function zoomImage(img){
  document.getElementById('zoomedImg').src=img.src;
  document.getElementById('zoomBox').style.display='block';
}
function closeZoom(){
  document.getElementById('zoomBox').style.display='none';
}

document.addEventListener("DOMContentLoaded", ()=>{
  const tableBody=document.querySelector("#data-table tbody");
  const viewAllBtn=document.getElementById("view-all-btn");
  const downloadBtn=document.getElementById("download-btn");
  const rows=Array.from(tableBody.querySelectorAll("tr"));
  const initialRowsCount=7;
  let isViewAll=false;

  function showLimited(){
    tableBody.innerHTML="";
    rows.slice(0,initialRowsCount).forEach(r=>tableBody.appendChild(r));
    viewAllBtn.textContent="View All";
    isViewAll=false;
  }
  function showAll(){
    tableBody.innerHTML="";
    rows.forEach(r=>tableBody.appendChild(r));
    viewAllBtn.textContent="Less";
    isViewAll=true;
  }
  viewAllBtn.addEventListener("click",()=>isViewAll?showLimited():showAll());
  downloadBtn.addEventListener("click",()=>window.print());
  showLimited();
});
</script>
</body>
</html>
