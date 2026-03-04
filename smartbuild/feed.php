<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: adminlogin.php");
    exit();
}

$user_email = $_SESSION['email']; 
$query = "SELECT ProfileImage FROM admin WHERE Aemail='$user_email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $profileImage = $user_data['ProfileImage'];
} else {
    $profileImage = "";
}

// Default image
$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

// Insert remark
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $remark = $conn->real_escape_string($_POST['remark']);

    if (!empty($name) && !empty($subject) && !empty($remark)) {
        $sql = "INSERT INTO remarks (name, subject, remark, created_at) VALUES ('$name', '$subject', '$remark', NOW())";
        $msg = $conn->query($sql) ? "✅ Remark added successfully!" : "❌ Database error: " . $conn->error;
    } else {
        $msg = "⚠️ Please fill all fields!";
    }
}

// Fetch remarks
$remarks_sql = "SELECT * FROM remarks ORDER BY id DESC";
$remarks_result = $conn->query($remarks_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Feedback</title>
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
  background:var(--white); padding:15px 25px; border-radius:12px;
  display:flex; justify-content:space-between; align-items:center;
  box-shadow:0 4px 10px var(--shadow); margin-bottom:30px;
}
.header h1 {color:var(--secondary); font-size:1.6rem;}
.header img {width:45px; height:45px; border-radius:50%; object-fit:cover; border:2px solid var(--primary);}

/* Table Card */
.table-card {
  background:var(--white); padding:30px; border-radius:16px;
  box-shadow:0 6px 20px var(--shadow);
}
.table-card h2 {
  color:var(--primary); margin-bottom:20px; text-align:center;
}
.msg {
  background:#fff3e6; border-left:5px solid var(--primary);
  padding:10px; border-radius:6px; margin-bottom:20px;
  color:#333; font-weight:500;
}

/* Table */
table {
  width:100%; border-collapse:collapse; text-align:left;
  overflow:hidden; border-radius:12px;
}
thead {background:var(--primary); color:#fff;}
th, td {
  padding:12px 15px; border-bottom:1px solid #eee;
}
tbody tr:hover {background:#f9f9f9;}
td {color:#333;}
td:nth-child(3){white-space:pre-wrap; word-break:break-word;}

/* Buttons */
.button-container {
  display:flex; justify-content:flex-end; gap:10px;
  margin-bottom:20px;
}
button.view {
  background:var(--primary); color:#fff;
  padding:8px 18px; border:none; border-radius:8px;
  font-weight:600; cursor:pointer; transition:0.3s;
}
button.view:hover {background:#e56f00; transform:scale(1.05);}

/* Form */
.feedback-form {
  background:#fefefe; padding:20px; border:1px solid #eee;
  border-radius:10px; margin-bottom:30px;
}
.feedback-form h3 {color:var(--secondary); margin-bottom:15px;}
.feedback-form input, .feedback-form textarea {
  width:100%; padding:10px; border:1px solid #ccc;
  border-radius:8px; margin-bottom:10px; font-size:1rem;
}
.feedback-form button {
  background:var(--primary); border:none; color:white;
  padding:10px 20px; border-radius:6px; cursor:pointer;
  font-weight:600; transition:0.3s;
}
.feedback-form button:hover {background:#e67e00;}

@media(max-width:900px){
  .sidebar{display:none;}
  .main{margin-left:0; padding:25px;}
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
  <a href="feed.php" class="active"><i class='bx bx-message-dots'></i> Feedback</a>
  <a href="visitor.php"><i class='bx bx-file-find'></i> Acceptance</a>
  <a href="project.php"><i class='bx bx-cloud-upload'></i> Upload Project</a>
  <a href="userresp.php"><i class='bx bx-chat'></i> User Response</a>
  <a href="logs.php" class="logout"><i class='bx bx-log-out'></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <div class="header">
    <h1>📋 User Feedback & Remarks</h1>
    <img src="<?= $profileImageSrc ?>" alt="Profile">
  </div>

  <div class="feedback-form">
    <h3>Add a New Remark</h3>
    <?php if ($msg): ?><p class="msg"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
    <form method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="text" name="subject" placeholder="Subject" required>
      <textarea name="remark" rows="3" placeholder="Enter your remark..." required></textarea>
      <button type="submit">Submit Remark</button>
    </form>
  </div>

  <div class="table-card">
    <div class="button-container">
      <button id="view-all-btn" class="view">View All</button>
      <button id="download-btn" class="view">Download</button>
    </div>
    <h2>All Remarks</h2>
    <table id="data-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Subject</th>
          <th>Remark</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($remarks_result->num_rows > 0): ?>
          <?php while ($row = $remarks_result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['remark'])) ?></td>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
            </tr>
          <?php endwhile; ?>
      <?php else: ?>
          <tr><td colspan="4">No remarks found.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", ()=>{
  const tableBody=document.querySelector("#data-table tbody");
  const viewAllBtn=document.getElementById("view-all-btn");
  const downloadBtn=document.getElementById("download-btn");
  const rows=Array.from(tableBody.querySelectorAll("tr"));
  const initialRowsCount=8;
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

  downloadBtn.addEventListener("click",()=>{
    let csv="";
    document.querySelectorAll("#data-table tr").forEach(row=>{
      const cells=row.querySelectorAll("th,td");
      const rowData=Array.from(cells).map(c=>`"${c.textContent}"`).join(",");
      csv+=rowData+"\n";
    });
    const blob=new Blob([csv],{type:"text/csv"});
    const a=document.createElement("a");
    a.href=URL.createObjectURL(blob);
    a.download="remarks.csv";
    a.click();
  });
  showLimited();
});
</script>
</body>
</html>
