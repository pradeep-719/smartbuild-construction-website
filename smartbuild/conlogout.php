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
    header("Location: registr.php");
    exit();
}

// --- Check Login ---
if (!isset($_SESSION['email'])) {
    header("Location: registr.php");
    exit();
}

$contractor_email = $_SESSION['email'];
$querys = "SELECT ProfileImage FROM contractor WHERE Cemail='$contractor_email'";
$result = mysqli_query($con, $querys);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
   $profileImage = $user_data['ProfileImage'];
} else {
    $profileImage = "";
}

// Default image lagao agar user ne upload nahi ki
if (empty($profileImage)) {
    $profileImageSrc = "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png";
} else {
    $profileImageSrc = $profileImage;
}
$query = mysqli_query($con, "SELECT CName FROM contractor WHERE Cemail='$contractor_email'");
$row = mysqli_fetch_assoc($query);
$contractor_name = $row['CName'] ?? "Guest";
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
<title>Contractor Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
    <link rel="stylesheet" 
          href="log.css">



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
        

     <div class="dp">
    <img src="<?= $profileImageSrc ?>" class="dpicn" alt="User Profile">
</div>

        </div>

    </header>



  <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">


                <div class="nav-upper-options">
                    <div class="nav-option option1">
                      
 <i class='bx bx-border-all' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="dashboards.php" style="text-decoration: none; color: inherit;">
                        <h3> Dashboard</h3>
</a>
                    </div>

                      <div class="nav-option option2">
 <i class='bx bx-border-all' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
                      <a href="response.php" style="text-decoration: none; color: inherit;">
    <h3>User Response</h3>
</a>
                    </div>

                     <div class="nav-option option3">
                     <i class='bx bxs-contact' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
   <a href="upload.php" style="text-decoration: none; color: inherit;">                    
  <h3>Upload Update</h3>
</a>
                    </div>
                    <div class="nav-option option4">
                        <i class='bx bxs-devices' style="color: #e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
  <a href="docu.php" style="text-decoration: none; color: inherit;">                        
 <h3>Documentation</h3>
</a>
                    </div>
                    <div class="nav-option option5">
                        <i class='bx bx-reset' style="color: #e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
   <a href="conres.php" style="text-decoration: none; color: inherit;">                      
  <h3>Pass-Reset</h3>
</a>
                    </div>
                  

                    <div class="nav-option option6">
                        
<i class='bx bxs-user-pin' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="pro.php" style="text-decoration: none; color: inherit;">  
                        <h3> Profile</h3>
</a>
                    </div>

                    

                    <div class="nav-option logout">
                      <i class='bx bx-log-out-circle' style="color: white; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="conlogout.php" style="text-decoration: none; color: inherit;">  
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


document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.querySelector("#data-table tbody");
    const viewAllBtn = document.getElementById("view-all-btn");
    const downloadBtn = document.getElementById("download-btn");

    // Retrieve all table rows
    const rows = Array.from(tableBody.querySelectorAll("tr"));
    const initialRowsCount = 10; // Number of rows to show initially
    let isViewAllActive = false;

    // Function to display a limited number of rows
    function showLimitedRows() {
        tableBody.innerHTML = ""; // Clear the table body
        rows.slice(0, initialRowsCount).forEach(row => tableBody.appendChild(row)); // Add only the first 5 rows
        viewAllBtn.textContent = "View All"; // Update button text
        isViewAllActive = false;
    }

    // Function to display all rows
    function showAllRows() {
        tableBody.innerHTML = ""; // Clear the table body
        rows.forEach(row => tableBody.appendChild(row)); // Add all rows
        viewAllBtn.textContent = " Less"; // Update button text
        isViewAllActive = true;
    }

    // Event listener for "View All" button
    viewAllBtn.addEventListener("click", () => {
        if (isViewAllActive) {
            showLimitedRows(); // Show only limited rows
        } else {
            showAllRows(); // Show all rows
        }
    });

    // Function to download the table data as a CSV file
    function downloadTableAsCSV() {
        let csvContent = "";
        const tableRows = document.querySelectorAll("#data-table tr");

        tableRows.forEach(row => {
            const cells = row.querySelectorAll("th, td");
            const rowData = Array.from(cells)
                .map(cell => `"${cell.textContent}"`) // Escape cell content for CSV
                .join(",");
            csvContent += rowData + "\n"; // Append row data with newline
        });

        // Create a downloadable blob
        const blob = new Blob([csvContent], { type: "text/csv" });
        const downloadLink = document.createElement("a");
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = "table_data.csv"; // File name
        downloadLink.click(); // Trigger download
    }

    // Event listener for "Download" button
    downloadBtn.addEventListener("click", downloadTableAsCSV);

    // Initialize table with limited rows
    showLimitedRows();
});


</script>
</body>
</html>

