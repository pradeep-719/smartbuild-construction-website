<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
    header("Location: adminlogin.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM admin WHERE Aemail='$email'";
$result = mysqli_query($conn, $query);
$profileImage = ($result && mysqli_num_rows($result) > 0)
    ? mysqli_fetch_assoc($result)['ProfileImage']
    : "";
$profileImageSrc = !empty($profileImage)
    ? $profileImage
    : "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";

$sql = "SELECT * FROM usertab ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SmartBuild | Users Data</title>
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
.header-bar{
  display:flex;align-items:center;justify-content:space-between;
  background:var(--white);border-radius:12px;padding:15px 25px;
  box-shadow:0 4px 12px rgba(0,0,0,0.1);margin-bottom:30px;
}
.header-bar h1{color:var(--secondary);font-size:1.6rem;}
.header-bar .actions button{
  background:var(--primary);border:none;color:#fff;padding:8px 18px;margin-left:10px;
  border-radius:8px;font-weight:600;cursor:pointer;transition:0.3s;
}
.header-bar .actions button:hover{background:#ff9b33;}

/* TABLE CONTAINER */
.data-container{
  background:var(--white);
  border-radius:16px;
  padding:25px;
  box-shadow:0 6px 20px rgba(0,0,0,0.1);
  overflow:auto;
}
table{
  width:100%;
  border-collapse:collapse;
  border-radius:10px;
  overflow:hidden;
}
thead{
  background:var(--primary);
  color:#fff;
}
th,td{
  padding:12px 15px;
  text-align:left;
  font-size:14px;
}
tbody tr:nth-child(even){background:#fffaf5;}
tbody tr:hover{background:#ffe6cc;transition:0.3s;}
.view-link{
  color:var(--primary);
  text-decoration:none;
  font-weight:600;
}
.view-link:hover{text-decoration:underline;}
img{
  border-radius:6px;
  cursor:pointer;
}

/* ZOOM BOX */
#zoomBox{
  display:none;
  position:fixed;
  top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.85);
  text-align:center;z-index:9999;
}
#zoomBox img{
  max-width:90%;max-height:90%;
  margin-top:4%;border:4px solid #fff;border-radius:10px;
}
#closeBtn{
  position:fixed;top:20px;right:35px;
  color:#fff;font-size:45px;cursor:pointer;
}

/* RESPONSIVE */
@media(max-width:900px){
  .main{margin-left:0;padding:20px;}
  .sidebar{display:none;}
  th,td{font-size:13px;}
}

/* PRINT */
@media print{
  header,.sidebar,.header-bar{display:none;}
  body{background:#fff;}
  table{width:100%;border:1px solid #000;border-collapse:collapse;font-size:12px;}
  th,td{border:1px solid #000;padding:6px;}
  @page{size:landscape;margin:10mm;}
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="admindash.php" ><i class='bx bx-grid-alt'></i> Profile</a>
  <a href="adform.php"><i class='bx bx-group'></i> Contractors</a>
  <a href="useer.php"  class="active"><i class='bx bx-user'></i> Users</a>
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
  <div class="header-bar">
    <h1>Users Data</h1>
    <div class="actions">
      <button id="view-all-btn">View All</button>
      <button id="download-btn">Download</button>
    </div>
  </div>

  <div class="data-container">
    <table id="data-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Purpose</th>
          <th>DOB</th>
          <th>Country</th>
          <th>State</th>
          <th>Profile</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($row['UName']) ?></td>
          <td><?= htmlspecialchars($row['Uemail']) ?></td>
          <td><?= htmlspecialchars($row['Contact']) ?></td>
          <td>
            <?php
              $address = $row['Address'] ?? 'No Address Provided';
              $chunks = array_chunk(explode(" ", $address), 30);
              foreach ($chunks as $chunk) echo htmlspecialchars(implode(" ", $chunk)) . "<br>";
            ?>
          </td>
          <td><?= htmlspecialchars($row['Purpose']) ?></td>
          <td><?= htmlspecialchars($row['DOB']) ?></td>
          <td><?= htmlspecialchars($row['Country']) ?></td>
          <td><?= htmlspecialchars($row['State']) ?></td>
          <td><img src="<?= htmlspecialchars($row['ProfileImage']) ?>" width="60" height="40" onclick="zoomImage(this)"></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ZOOM BOX -->
<div id="zoomBox">
  <span id="closeBtn" onclick="closeZoom()">&times;</span>
  <img id="zoomedImg">
</div>

<script>
function zoomImage(img){
  document.getElementById('zoomedImg').src=img.src;
  document.getElementById('zoomBox').style.display='block';
}
function closeZoom(){
  document.getElementById('zoomBox').style.display='none';
}

document.addEventListener("DOMContentLoaded",()=>{
  const tableBody=document.querySelector("#data-table tbody");
  const viewAllBtn=document.getElementById("view-all-btn");
  const downloadBtn=document.getElementById("download-btn");
  const rows=Array.from(tableBody.querySelectorAll("tr"));
  const initialRows=7;
  let expanded=false;

  function showLimited(){
    tableBody.innerHTML="";
    rows.slice(0,initialRows).forEach(r=>tableBody.appendChild(r));
    viewAllBtn.textContent="View All";
    expanded=false;
  }
  function showAll(){
    tableBody.innerHTML="";
    rows.forEach(r=>tableBody.appendChild(r));
    viewAllBtn.textContent="Less";
    expanded=true;
  }
  viewAllBtn.addEventListener("click",()=>expanded?showLimited():showAll());
  downloadBtn.addEventListener("click",()=>window.print());
  showLimited();
});
</script>
</body>
</html>
