<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "Contractor not logged in!";
    exit();
}

$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];
$query = "SELECT ProfileImage FROM admin WHERE Aemail='$email'";
$result = mysqli_query($con, $query);
$profileImage = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result)['ProfileImage'] : "";
$profileImageSrc = !empty($profileImage)
    ? $profileImage
    : "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";

$sql = "SELECT * FROM signed_pdfs ORDER BY upload_time DESC";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signed PDFs | SmartBuild</title>
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
/* HEADER BAR */
.header-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--white);
  border-radius: 14px;
  padding: 18px 25px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  margin-bottom: 30px;
}

.header-bar h1 {
  color: var(--secondary);
  font-size: 1.6rem;
}

.header-bar .actions button {
  background: var(--primary);
  color: white;
  border: none;
  padding: 8px 18px;
  margin-left: 10px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}
.header-bar .actions button:hover {
  background: #ff9b33;
}

/* TABLE */
.data-container {
  background: var(--white);
  border-radius: 16px;
  padding: 25px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 10px;
  overflow: hidden;
}

thead {
  background: var(--primary);
  color: white;
}

th, td {
  padding: 12px 15px;
  text-align: left;
  font-size: 14px;
}

tbody tr:nth-child(even) {
  background: #fffaf5;
}
tbody tr:hover {
  background: #ffe6cc;
  transition: 0.3s;
}

/* BUTTONS */
.btn-view {
  background: var(--primary);
  color: white;
  padding: 7px 14px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
  box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}
.btn-view:hover {
  background: #ff9b33;
  transform: scale(1.05);
}

/* RESPONSIVE */
@media (max-width: 900px) {
  .sidebar { display: none; }
  .main { margin-left: 0; padding: 20px; }
  th, td { font-size: 13px; }
}

/* PRINT MODE */
@media print {
  .sidebar, .header-bar { display: none; }
  body { background: #fff; }
  table { border: 1px solid #000; border-collapse: collapse; width: 100%; }
  th, td { border: 1px solid #000; padding: 6px; }
  @page { size: landscape; margin: 10mm; }
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="admindash.php" ><i class='bx bx-grid-alt'></i> Profile</a>
  <a href="adform.php"><i class='bx bx-group'></i> Contractors</a>
  <a href="useer.php" ><i class='bx bx-user'></i> Users</a>
  <a href="addoc.php"  class="active"><i class='bx bx-file'></i> Documentation</a>
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
    <h1>📑 Signed PDFs</h1>
    <div class="actions">
      <button id="view-all-btn">View All</button>
      <button id="download-btn">Download</button>
    </div>
  </div>

  <div class="data-container">
    <table id="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>User Email</th>
          <th>Contractor Email</th>
          <th>Upload Time</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['user_email']}</td>
              <td>{$row['contractor_email']}</td>
              <td>{$row['upload_time']}</td>
              <td><a class='btn-view' href='{$row['file_path']}' target='_blank'>View PDF</a></td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='5' style='text-align:center;'>No Signed PDFs Found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded",()=>{
  const tableBody=document.querySelector("#data-table tbody");
  const viewAllBtn=document.getElementById("view-all-btn");
  const downloadBtn=document.getElementById("download-btn");
  const rows=Array.from(tableBody.querySelectorAll("tr"));
  const initial=7;
  let expanded=false;

  function showLimited(){
    tableBody.innerHTML="";
    rows.slice(0,initial).forEach(r=>tableBody.appendChild(r));
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
