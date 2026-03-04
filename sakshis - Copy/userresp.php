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

// --- FETCH ALL CONTRACTORS ---
$query = "SELECT * FROM visit_form ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Responses | SmartBuild Admin</title>
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

/* Table Container */
.table-section{
  background:var(--white);
  border-radius:16px;
  box-shadow:0 8px 25px var(--shadow);
  padding:25px;
}
.table-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}
.table-header h2{
  color:var(--primary);
  font-weight:700;
}
.table-header button{
  background:var(--primary);
  color:#fff;
  border:none;
  padding:8px 16px;
  border-radius:6px;
  cursor:pointer;
  font-weight:600;
  transition:0.3s;
}
.table-header button:hover{background:#e67e00;}

table{
  width:100%;
  border-collapse:collapse;
  margin-top:10px;
}
th,td{
  padding:12px 15px;
  text-align:center;
  border-bottom:1px solid #eee;
}
th{
  background:#f5f7fb;
  color:var(--secondary);
  font-weight:600;
}
tr:hover{background:#fff6ec;}
img{border-radius:6px;cursor:pointer;}

/* Buttons */
.delete-btn{
  background:#e63946;
  color:#fff;
  border:none;
  padding:6px 12px;
  border-radius:6px;
  font-weight:600;
  cursor:pointer;
  transition:0.3s;
}
.delete-btn:hover{background:#c52735;}

@media(max-width:900px){
  .sidebar{display:none;}
  .main{margin-left:0;padding:25px;}
  .table-header{flex-direction:column;gap:10px;}
  th,td{font-size:13px;padding:10px;}
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
  <a href="visitor.php"><i class='bx bx-file-find'></i> Acceptance</a>
  <a href="project.php"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php" class="active"><i class='bx bx-chat'></i> User Response</a>
  <a href="logs.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- Main -->
<div class="main">
  <div class="header">
    <h1>📋 User Response Records</h1>
    <img src="<?= $profileImageSrc ?>" alt="Profile">
  </div>

  <div class="table-section">
    <div class="table-header">
      <h2>All User Responses</h2>
      <div>
        <button id="view-all-btn">View All</button>
        <button id="download-btn">Download</button>
      </div>
    </div>

    <table id="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Contractor Email</th>
          <th>Cost</th>
          <th>User Decision</th>
          <th>UPI</th>
          <th>Created At</th>
          <th>Photo</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['contractor_email']) ?></td>
          <td><?= htmlspecialchars($row['cost']) ?></td>
          <td><?= htmlspecialchars($row['user_decision']) ?></td>
          <td><?= htmlspecialchars($row['upi']) ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td><img src="<?= htmlspecialchars($row['photo']) ?>" width="70" height="50" onclick="zoomImage(this)"></td>
          <td><button class="delete-btn" data-id="<?= $row['id'] ?>">Delete</button></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function zoomImage(img){
  const zoomBox=document.createElement('div');
  zoomBox.style.cssText="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);display:flex;justify-content:center;align-items:center;z-index:9999;";
  const zoomedImg=document.createElement('img');
  zoomedImg.src=img.src;
  zoomedImg.style.cssText="max-width:90%;max-height:90%;border:3px solid white;border-radius:10px;";
  zoomBox.appendChild(zoomedImg);
  zoomBox.onclick=()=>zoomBox.remove();
  document.body.appendChild(zoomBox);
}

document.addEventListener("DOMContentLoaded",()=>{
  document.querySelectorAll(".delete-btn").forEach(btn=>{
    btn.addEventListener("click",function(){
      const id=this.dataset.id;
      if(confirm("Are you sure you want to delete this record?")){
        fetch("delete_visit.php",{
          method:"POST",
          headers:{"Content-Type":"application/x-www-form-urlencoded"},
          body:"id="+id
        })
        .then(res=>res.text())
        .then(data=>{
          if(data.trim()==="success"){
            alert("Record deleted successfully!");
            this.closest("tr").remove();
          }else alert("Failed to delete record! "+data);
        });
      }
    });
  });
});

document.addEventListener("DOMContentLoaded",()=>{
  const tableBody=document.querySelector("#data-table tbody");
  const viewAllBtn=document.getElementById("view-all-btn");
  const downloadBtn=document.getElementById("download-btn");
  const rows=Array.from(tableBody.querySelectorAll("tr"));
  const initialRowsCount=10;
  let isViewAllActive=false;

  function showLimitedRows(){
    tableBody.innerHTML="";
    rows.slice(0,initialRowsCount).forEach(r=>tableBody.appendChild(r));
    viewAllBtn.textContent="View All";
    isViewAllActive=false;
  }

  function showAllRows(){
    tableBody.innerHTML="";
    rows.forEach(r=>tableBody.appendChild(r));
    viewAllBtn.textContent="Less";
    isViewAllActive=true;
  }

  viewAllBtn.addEventListener("click",()=>isViewAllActive?showLimitedRows():showAllRows());
  downloadBtn.addEventListener("click",()=>window.print());
  showLimitedRows();
});
</script>
</body>
</html>
