<?php
session_start();

// --- Direct Database Connection ---
$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- Logout Logic ---
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: adminlogin.php");
    exit();
}

// --- Check Login ---
if (!isset($_SESSION['email'])) {
    header("Location:adminlogin.php");
    exit();
}

$contractor_email = $_SESSION['email'];
$query = mysqli_query($con, "SELECT AName FROM admin WHERE Aemail='$contractor_email'");
$row = mysqli_fetch_assoc($query);
$contractor_name = $row['AName'] ?? "Guest";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport" 
          content="width=device-width, 
                   initial-scale=1.0">
<title>User Logout</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
    <link rel="stylesheet" 
          href="usr.css">



<style>
/* ---- MAIN WRAPPER ---- */
.wrap {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    padding: 40px 25px;
    max-width: 1300px;
   margin: 40px auto;
    background: #f7f8fa;
    border-radius: 12px;
}

/* ---- Card ---- */
.card {
    background: #fff;
    width: 370px; /* Increased width */
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 25px;
    text-align: left;
    transition: all 0.3s ease;
    border-top: 5px solid #ff8800;
    font-family: "Poppins", sans-serif;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

.card h3 {
    margin-bottom: 10px;
    color: #222;
    font-size: 18px;
}
/* ---- TITLE ---- */
.wrap h2 {
  color: #ff8c00;
  font-size: 26px;
  margin-bottom: 10px;
}

/* ---- PARAGRAPHS ---- */
.wrap p {
  color: #444;
  font-size: 15px;
  margin-bottom: 18px;
}

/* ---- INFO BOX ---- */
.wrap .info {
  background: #fffaf2;
  border-left: 5px solid orange;
  padding: 10px 15px;
  border-radius: 10px;
  margin-bottom: 25px;
  text-align: left;
}
.wrap .info p {
  margin: 6px 0;
  color: #333;
}
.wrap .info strong {
  color: #ff8c00;
}

/* ---- LOGOUT BUTTON ---- */
.logout-btn {
  display: block;
  background: orange;
  color: white;
  padding: 12px 35px;
  border-radius: 30px;
  text-decoration: none;
  font-size: 17px;
  font-weight: 600;
  text-align: center;
  margin: 40px auto;
  width: fit-content;
  box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.wrap .logout-btn:hover {
  background: #e67e00;
  transform: scale(1.05);
}

/* ---- FOOTER NOTE ---- */
.wrap .note {
  text-align: center;
  margin-top: 25px;
  color: #777;
  font-size: 14px;
}

/* ---- BACKGROUND DECORATION ---- */

</style>



</head>
<body>
  
    <!-- for header part -->
    <header>

        <div class="logosec">
            <div class="logo">Admin Page</div>
            <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210182541/Untitled-design-(30).png"
                class="icn menuicn" 
                id="menuicn" 
                alt="menu-icon">
        </div>

        

        <div class="message">
            <div class="circle"></div>
            <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/8.png" 
                 class="icn" 
                 alt="">
            <div class="dp">
              <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
                    class="dpicn" 
                    alt="dp">
              </div>
        </div>

    </header>

  <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">


                <div class="nav-upper-options">
                    <div class="nav-option option1">
                      
 <i class='bx bx-border-all' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="admindash.php" style="text-decoration: none; color: inherit;">
                        <h3> Dashboard</h3>
</a>
                    </div>

                      <div class="nav-option option2">
 <i class='bx bx-border-all' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
                      <a href="adform.php" style="text-decoration: none; color: inherit;">
    <h3>Contractors</h3>
</a>
                    </div>

                     <div class="nav-option option3">
                     <i class='bx bxs-contact' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
   <a href="useer.php" style="text-decoration: none; color: inherit;">                    
  <h3>Users</h3>
</a>
                    </div>
                    <div class="nav-option option4">
                        <i class='bx bxs-devices' style="color: #e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
  <a href="addoc.php" style="text-decoration: none; color: inherit;">                        
 <h3>Documentation</h3>
</a>
                    </div>
                    <div class="nav-option option5">
                        <i class='bx bx-reset' style="color: #e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
   <a href="resp.php" style="text-decoration: none; color: inherit;">                      
  <h3>Pass-Reset</h3>
</a>
                    </div>
                  

                    <div class="nav-option option6">
                        
<i class='bx bxs-user-pin' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="pros.php" style="text-decoration: none; color: inherit;">  
                        <h3> Profile</h3>
</a>
                    </div>


 <div class="nav-option option7">
                        
<i class='bx bx-upload' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="feed.php" style="text-decoration: none; color: inherit;">  
                        <h3> User Feedback</h3>
</a>
                    </div>

<div class="nav-option option8">
                      <i class='bx bx-file' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="visitor.php" style="text-decoration: none; color: inherit;">  
                        <h3>Acceptance form</h3>
</a>
                    </div>	



<div class="nav-option option9">
                      <i class='bx bx-cloud-upload' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="project.php" style="text-decoration: none; color: inherit;">  
                        <h3>Upload project</h3>
</a>
                    </div>                   


<div class="nav-option option10">
                      <i class='bx bx-message-dots' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="userresp.php" style="text-decoration: none; color: inherit;">  
                        <h3>User Response</h3>
</a>
                    </div>	
                    	                    

                    <div class="nav-option logout">
                      <i class='bx bx-log-out-circle' style="color: white; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="logs.php" style="text-decoration: none; color: inherit;">  
                        <h3>Logout</h3>
</a>
                    </div>

                </div>
            </nav>
        </div>






<div class="wrap">
  <div class="card">
    <h2>Welcome Back, <?= htmlspecialchars($contractor_name) ?> 👷</h2>
    <p>Your personalized contractor dashboard</p>

    <div class="info">
      <p><strong>Contractor Name:</strong> <?= htmlspecialchars($contractor_name) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($contractor_email) ?></p>
    </div>

    <a href="?logout=true" class="logout-btn">Logout</a>

    <div class="note">
      <p>“Work hard, build smart — your success is under construction!” 🚧</p>
    </div>
  </div>
</div>







 <script>
let menuicn = document.querySelector(".menuicn");
let nav = document.querySelector(".navcontainer");

menuicn.addEventListener("click", () => {
    nav.classList.toggle("navclose");
})



</script>
</body>
</html>

