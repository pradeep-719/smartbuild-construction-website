<?php
session_start();

// --- Database Connection ---
$conn = new mysqli("localhost", "root", "", "usersss");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Logged-in Contractor (via Email) ---
$contractor_email = $_SESSION['email'] ?? "sonu@gmail.com";

// ✅ Fetch Contractor ID First
$contractor_query = $conn->query("SELECT id, CName, admin_action, ProfileImage FROM contractor WHERE Cemail='$contractor_email'");
if ($contractor_query->num_rows > 0) {
    $contractor = $contractor_query->fetch_assoc();
    $contractor_id = $contractor['id'];
    $contractor_name = $contractor['CName'];
    $action = $contractor['admin_action'];
    $profileImage = $contractor['ProfileImage'];
} else {
    echo "<h3 style='text-align:center;color:red;'>Contractor not found. Please log in again.</h3>";
    exit();
}

// ✅ Default image if none
$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

// --- Handle Send Request ---
if (isset($_GET['request_id'])) {
    $user_id = intval($_GET['request_id']);

    $check = $conn->query("SELECT * FROM contractor_user_response WHERE contractor_id='$contractor_id' AND user_id='$user_id'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Request already sent!'); window.location.href='response.php';</script>";
        exit();
    } else {
        $conn->query("INSERT INTO contractor_user_response (contractor_id, user_id, request_status, request_date)
                      VALUES ('$contractor_id', '$user_id', 'pending', NOW())");
        echo "<script>alert('Request sent successfully!'); window.location.href='response.php';</script>";
        exit();
    }
}

// --- Fetch Only Users who accepted/requested this Contractor ---
$sql = "
SELECT 
    u.id AS user_id,
    u.UName,
    u.Uemail,
    u.Contact,
    u.Address,
    u.Purpose,
    u.DOB,
    u.Country,
    u.State,
    u.ProfileImage,
    COALESCE(cur.request_status, 'not sent') AS contractor_status,
    ucs.status AS user_status
FROM usertab u
INNER JOIN user_contractor_status ucs
    ON u.id = ucs.user_id 
   AND ucs.contractor_id = '$contractor_id'
   AND ucs.status IN ('requested', 'accept')
LEFT JOIN contractor_user_response cur
    ON u.id = cur.user_id 
   AND cur.contractor_id = '$contractor_id'
ORDER BY u.UName ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($contractor_name) ?> — User Responses</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
  --primary-color: #ff6b4a;
  --secondary-color: #2c3e50;
  --light-gray: #f4f7f6;
  --dark-gray: #555;
  --white: #ffffff;
  --border-color: #e0e0e0;
  --shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{display:flex;background:var(--light-gray);color:var(--dark-gray);overflow-x:hidden;}

/* ==== SIDEBAR ==== */
.sidebar{
  width:250px;height:100vh;background:var(--secondary-color);
  padding:30px 20px;color:white;position:fixed;top:0;left:0;
  display:flex;flex-direction:column;z-index:1000;
  transform:translateX(0);transition:transform 0.3s ease;
}
.sidebar.closed{transform:translateX(-100%);}
.sidebar.open{transform:translateX(0);}
.sidebar h2{color:var(--primary-color);font-size:24px;margin-bottom:30px;}
.sidebar a{
  display:flex;align-items:center;gap:10px;color:white;
  text-decoration:none;padding:12px 10px;margin-bottom:8px;
  border-radius:6px;transition:0.3s;
}
.sidebar a:hover,.sidebar a.active{background:var(--primary-color);}
.sidebar a.logout{margin-top:auto;}

/* ==== OVERLAY ==== */
.overlay{
  display:none;position:fixed;top:0;left:0;width:100%;height:100%;
  background:rgba(0,0,0,0.5);z-index:999;
}
.overlay.show{display:block;}

/* ==== TOP BAR ==== */
.topbar{
  width:100%;background:var(--white);height:60px;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 20px;box-shadow:0 2px 10px rgba(0,0,0,0.05);
  position:fixed;top:0;left:0;z-index:900;
}
.topbar h1{
  font-size:1.3rem;color:var(--secondary-color);
  font-weight:700;
}
#menu-toggle{
  background:none;border:none;font-size:1.8rem;
  color:var(--secondary-color);cursor:pointer;
  display:none;
}

/* ==== MAIN ==== */
.main{
  flex:1;padding:90px 30px 30px 30px;margin-left:250px;
  transition:margin-left 0.3s ease;
}
.table-card{
  background:var(--white);border-radius:12px;
  box-shadow:var(--shadow);padding:25px;
}
.table-header{
  display:flex;justify-content:space-between;align-items:center;
  margin-bottom:15px;flex-wrap:wrap;gap:10px;
}
.table-header h2{color:var(--secondary-color);font-size:1.5rem;}
.table-header .actions button{
  background:var(--primary-color);border:none;color:var(--white);
  padding:8px 15px;border-radius:6px;cursor:pointer;font-weight:600;
  transition:0.3s;
}
.table-header .actions button:hover{background:#e65a3c;}
table{width:100%;border-collapse:collapse;}
th,td{
  padding:12px 10px;border-bottom:1px solid var(--border-color);
  text-align:left;font-size:0.95rem;
}
th{background:#f7f8f9;color:var(--secondary-color);}
tr:hover{background:#fff5f2;transition:0.2s;}
img{border-radius:6px;cursor:pointer;}
.btn{text-decoration:none;padding:6px 12px;border-radius:5px;font-weight:bold;}
.accept-btn{background-color:#28a745;color:white;}

/* ==== ZOOM BOX ==== */
#zoomBox{display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.8);text-align:center;z-index:9999;}
#zoomBox img{max-width:90%;max-height:90%;margin-top:4%;border:3px solid white;border-radius:8px;}
#closeBtn{position:fixed;top:15px;right:25px;color:#fff;font-size:45px;cursor:pointer;z-index:10000;}

/* ==== RESPONSIVE ==== */
@media(max-width:900px){
  #menu-toggle{display:block;}
  .sidebar{transform:translateX(-100%);}
  .sidebar.open{transform:translateX(0);}
  .overlay.show{display:block;}
  .main{margin-left:0;padding:80px 20px;}
  table{font-size:0.85rem;}
  th,td{padding:8px;}
}

</style>
</head>

<body>
<!-- SIDEBAR -->
<div class="sidebar">
  <h2>SmartBuild</h2>
  <a href="dashboards.php"><i class="fa-solid fa-chart-line"></i> Profile</a>
  <a href="response.php" class="active"><i class="fa-solid fa-comments"></i> User Response</a>
  <a href="upload.php"><i class="fa-solid fa-upload"></i> Upload Daily Status</a>
  <a href="docu.php"><i class="fa-solid fa-file-lines"></i> Documentation</a>
  <a href="conres.php"><i class="fa-solid fa-key"></i> Pass Reset</a>
  <a href="pro.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
  <a href="feedview.php"><i class="fa-solid fa-message"></i> Feedback View</a>
  <a href="userlogouts.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="overlay"></div>

<!-- TOP BAR -->
<div class="topbar">
  <button id="menu-toggle"><i class="fa-solid fa-bars"></i></button>
  <h1>User Responses</h1>
</div>

<!-- MAIN CONTENT -->
<div class="main">
  <div class="table-card">
    <div class="table-header">
      <h2>Users Connected With You</h2>
      <div class="actions">
        <button id="view-all-btn">View All</button>
        <button id="download-btn">Download</button>
      </div>
    </div>

    <table id="data-table">
      <thead>
        <tr>
          <th>Name</th><th>Email</th><th>Address</th><th>Contact</th><th>Requirements</th>
          <th>Country</th><th>State</th><th>Profile</th><th>User Accepted</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($row['UName']) ?></td>
          <td><?= htmlspecialchars($row['Uemail']) ?></td>
          <td><?= htmlspecialchars($row['Address']) ?></td>
          <td><?= htmlspecialchars($row['Contact']) ?></td>
          <td><?= htmlspecialchars($row['Purpose']) ?></td>
          <td><?= htmlspecialchars($row['Country']) ?></td>
          <td><?= htmlspecialchars($row['State']) ?></td>
          <td><img src="<?= htmlspecialchars($row['ProfileImage']) ?>" width="60" height="40" onclick="zoomImage(this)"></td>
          <td>
            <?php
            $user_status = $row['user_status'];
            if ($user_status == 'accept') echo "<span class='btn accept-btn'>Request</span>";
            elseif ($user_status == 'reject') echo "<span class='btn accept-btn'>Rejected ❌</span>";
            else echo "<span style='color:gray;'>Not Responded</span>";
            ?>
          </td>
          <td>
            <?php
            $status = str_replace(' ', '', $row['contractor_status']);
            if ($status == 'notsent') {
              echo "<a href='?request_id={$row['user_id']}' class='btn accept-btn'>Accept</a>";
            } elseif ($status == 'pending') {
              echo "<span style='color:blue;'>Approved ✅</span>";
            } elseif ($status == 'accept') {
              echo "<span style='color:green;'>Accepted ✅</span>";
            } elseif ($status == 'reject') {
              echo "<span style='color:red;'>Rejected ❌</span>";
            }
            ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ZOOM IMAGE -->
<div id="zoomBox">
  <span id="closeBtn" onclick="closeZoom()">&times;</span>
  <img id="zoomedImg" onclick="closeZoom()">
</div>

<script>
// Sidebar Toggle
const sidebar=document.querySelector('.sidebar');
const overlay=document.querySelector('.overlay');
const menuToggle=document.getElementById('menu-toggle');

menuToggle.addEventListener('click',()=>{
  sidebar.classList.toggle('open');
  overlay.classList.toggle('show');
});
overlay.addEventListener('click',()=>{
  sidebar.classList.remove('open');
  overlay.classList.remove('show');
});

// Zoom
function zoomImage(img){
  const zoomBox=document.getElementById("zoomBox");
  const zoomedImg=document.getElementById("zoomedImg");
  zoomedImg.src=img.src;
  zoomBox.style.display="block";
}
function closeZoom(){document.getElementById("zoomBox").style.display="none";}

// Table
document.addEventListener("DOMContentLoaded",()=>{
  const tableBody=document.querySelector("#data-table tbody");
  const viewAllBtn=document.getElementById("view-all-btn");
  const downloadBtn=document.getElementById("download-btn");
  const rows=Array.from(tableBody.querySelectorAll("tr"));
  const initialRowsCount=10;
  let isViewAllActive=false;
  function showLimitedRows(){
    tableBody.innerHTML="";
    rows.slice(0,initialRowsCount).forEach(row=>tableBody.appendChild(row));
    viewAllBtn.textContent="View All";
    isViewAllActive=false;
  }
  function showAllRows(){
    tableBody.innerHTML="";
    rows.forEach(row=>tableBody.appendChild(row));
    viewAllBtn.textContent="Less";
    isViewAllActive=true;
  }
  viewAllBtn.addEventListener("click",()=>isViewAllActive?showLimitedRows():showAllRows());
  downloadBtn.addEventListener("click",()=>{
    let csvContent="";
    const tableRows=document.querySelectorAll("#data-table tr");
    tableRows.forEach(row=>{
      const cells=row.querySelectorAll("th, td");
      const rowData=Array.from(cells).map(cell=>`"${cell.textContent}"`).join(",");
      csvContent+=rowData+"\n";
    });
    const blob=new Blob([csvContent],{type:"text/csv"});
    const link=document.createElement("a");
    link.href=URL.createObjectURL(blob);
    link.download="user_responses.csv";
    link.click();
  });
  showLimitedRows();
});
</script>

</body>
</html>