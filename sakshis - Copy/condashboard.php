<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "User not logged in!";
    exit();
}


// Establish database connection
$con = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Use 'email' consistently from session after login
$user_email = $_SESSION['email'] ?? null; // Use $_SESSION['email'] from your login script

// Redirect if user is not logged in (no email in session)
if (!$user_email) {
    header("Location: registr.php"); // Or your login page
    exit();
}

$user_email_escaped = mysqli_real_escape_string($con, $user_email);

// Fetch user data using correct column names (UName, Uemail)
// Using prepared statements for security (highly recommended)
$stmt = mysqli_prepare($con, "SELECT CName, Cemail, Address, Contact, DOB, ProfileImage,Country,State, Purpose, createdate FROM contractor WHERE Cemail = ?");

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $user_email_escaped);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a row was returned
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign fetched data to variables, using null coalescing for fallbacks
        $name = htmlspecialchars($row['CName'] ?? '');
        $email = htmlspecialchars($row['Cemail'] ?? '');
        $address = htmlspecialchars($row['Address'] ?? 'N/A');
        $contact = htmlspecialchars($row['Contact'] ?? 'N/A');
        $dob = htmlspecialchars($row['DOB'] ?? 'N/A');
        $purpose = htmlspecialchars($row['Purpose'] ?? 'No purpose defined');
        $createdate = htmlspecialchars($row['createdate'] ?? 'N/A');
        $country = htmlspecialchars($row['Country'] ?? 'N/A');
        $state = htmlspecialchars($row['State'] ?? 'N/A');

        // --- CORRECTED: Logic for Profile Image Styling ---
        // Use $row['ProfileImage'] directly from the fetched data
        if (!empty($row['ProfileImage'])) {
            $profileCircleStyle = "background-image: url('" . htmlspecialchars($row['ProfileImage']) . "');";
        } else {
            // Default image if no profile image is set or path is empty in DB
            $profileCircleStyle = "background-image: url('https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png');"; // Using a reliable default placeholder
        }

    } else {
        // If no user is found with the session email (should ideally not happen if login is secure)
        $name = 'Guest'; // Provide a default name
        $email = 'N/A';
        $address = 'N/A';
        $contact = 'N/A';
        $dob = 'N/A';
        $purpose = 'N/A';
        $createdate = 'N/A';
        $country='N/A';
         $state='N/A';
        $profileCircleStyle = "background-image: url('https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png');"; // Default image
        // Optional: Destroy session and redirect if user not found for security
        // session_destroy();
        // header("Location: index.php?error=user_not_found");
        // exit();
    }
    mysqli_stmt_close($stmt); // Close the prepared statement
} else {
    // Handle error if prepared statement fails
    error_log("Error preparing SQL statement: " . mysqli_error($con));
    // Set default values in case of database query failure
    $name = 'Error';
    $email = 'Error';
    $address = 'N/A';
    $contact = 'N/A';
    $dob = 'N/A';
    $purpose = 'N/A';
    $createdate = 'N/A';
    $country='N/A';
    $state='N/A';
    $profileCircleStyle = "background-image: url('https://thumbs2.imgbox.com/e3/26/klxWrJ8q_t.png');"; // Default image
}

mysqli_close($con); // Close the database connection at the end
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?>'s Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
    <link rel="stylesheet" 
          href="das.css">
 
<style>
        /* CSS Variables for a clean, customizable theme */
:root {
    --primary-color: #4A90E2; /* A modern blue for accents */
    --secondary-color: #F5A623; /* A vibrant orange for buttons */
    --text-dark: #333;
    --text-medium: #555;
    --text-light: #f8f9fa;
    --bg-body: #f7f9fc; /* Very light, soft background */
    --bg-card: #ffffff;
    --bg-header-gradient-start: #6a11cb; /* Deeper purple for header */
    --bg-header-gradient-end: #2575fc; /* Stronger blue for header */
    --border-subtle: 1px solid #e0e0e0; /* Softer borders */
    --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.08); /* Lighter, broader shadow */
    --shadow-strong: 0 8px 30px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
    --transition-speed: 0.3s ease;
}

/* Global Styles & Body */
/* Assuming body styling is elsewhere or you'll add it */

.profile-card {
    background-color: var(--bg-card);
    border-radius: 15px;
    box-shadow: var(--shadow-strong);
    width: 95%;
    max-width: 650px;
    overflow: hidden;
    margin-top: 20px;    /* Keep 20px space on top */
    margin-bottom: 5px; /* <--- Reduce bottom space to 5px (or your desired value) */
    margin-left: auto;   /* Center horizontally */
    margin-right: auto;  /* Center horizontally */
    animation: fadeIn 0.8s ease-out;
    border: var(--border-subtle);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header Section (Top background with profile image inside) */
.card-header {
    position: relative;
    height: 130px; /* Adjusted height for overall compactness */
    background: #e67e00; /* Vibrant gradient for header */
    display: flex;
    flex-direction: column; /* Stack items vertically */
    justify-content: center; /* Center items vertically in the header */
    align-items: center; /* Center items horizontally in the header */
    border-bottom: var(--border-subtle); /* Softer border below header */
}

.profile-img {
    width: 120px; /* Increased size for better visibility */
    height: 120px;
    border-radius: 50%;
    border: 6px solid white; /* Thicker white border */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat; /* Ensure image doesn't repeat */
    position: absolute;
    bottom: -60px; /* Adjust to half of height to center vertically */
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 4px 15px rgba(0,0,0,0.25); /* Stronger shadow */
    transition: transform var(--transition-speed), box-shadow var(--transition-speed);

}

.profile-img:hover {
    transform: translateX(-50%) scale(1.05); /* More noticeable hover effect */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35); /* Stronger shadow on hover */
}

/* Card Body (Main Information Area) */
.card-body {
    padding: 35px; /* Increased padding for more breathing room */
    text-align: left;
    /* --- MODIFICATION: INCREASE GAP BETWEEN CIRCLE AND EMAIL --- */
    /* Increased padding-top to push content further down, creating space below the profile image */
    padding-top: 80px; /* Adjusted for more space. You can tweak this value. */
}

.user-name {
    font-family: 'Poppins', sans-serif; /* Poppins for name, more impactful */
    font-size: 2.2em; /* Larger, more prominent name */
    font-weight: 700;
    color: var(--text-dark);
    text-align: center;
    margin-top: -10px; /* Adjust if needed based on the design flow */
    margin-bottom: 30px; /* More space below name */
    letter-spacing: -0.5px; /* Slightly tighter letter spacing */
}

/* Information Grid - Single Column */
.info-grid {
    display: grid; /* Using grid for better control over spacing */
    grid-template-columns: 1fr;
    gap: 15px; /* Increased gap between items */
    /* --- MODIFICATION: REMOVED MARGIN-BOTTOM AS BUTTON IS REMOVED --- */
    /* margin-bottom: 20px; */ /* Removed as the edit button is no longer present */
}

.info-item {
    display: flex;
    align-items: center;
    padding-bottom: 12px; /* Padding to separate items visually */
    border-bottom: 1px dashed var(--border-subtle); /* Subtle dashed separator */
    /* ENSURE TEXT STAYS ON ONE LINE */
    flex-wrap: nowrap; /* Prevents wrapping within the info-item by default */
}
.info-item:last-child {
    border-bottom: none; /* No border for the last item */
    padding-bottom: 0;
}

.info-item i {
    color: var(--primary-color); /* Icon color matching primary accent */
    font-size: 1.3em; /* Slightly larger icons */
    width: 30px; /* Fixed width for consistent alignment */
    text-align: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.info-label {
    font-family: 'Poppins', sans-serif; /* Poppins for labels too */
    font-weight: 600; /* More prominent labels */
    color: var(--text-dark);
    flex-shrink: 0; /* Prevents the label from shrinking too much */
    margin-right: 15px; /* More space between label and value */
    font-size: 1.05em;
    white-space: nowrap; /* Ensures the label text itself stays on one line */
}

.info-value {
    color: var(--text-medium);
    /* --- MODIFICATION: REDUCE TRAILING SPACE --- */
    /* Removed flex-grow: 1 so the value takes only the space it needs */
    /* This will make the text 'hug' the end more closely. */
    /* If you re-add flex-grow: 1, the space will return. */
    /* flex-grow: 1; */
    word-break: break-word; /* Allows long words to break if necessary */
    font-size: 1.05em;
    line-height: 1.4; /* Better line height for readability */
    min-width: 0; /* Allows the value to shrink beyond its content if needed to prevent overflow */
}


.welcome-text {
    color: var(--text-light);
    font-family: 'Poppins', sans-serif;
    font-size: 1.8em;
    font-weight: 600;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    z-index: 1;
    white-space: nowrap;
    position: absolute; /* Changed to absolute for proper positioning within header */
    top: 20px; /* Adjust as needed */
   align:center;
}

/* --- MODIFICATION: REMOVE EDIT BUTTON CONTAINER STYLES --- */
/* The entire .edit-btn-container and .edit-btn rules are now commented out/removed */
 .edit-btn-container {
    text-align: center;
    margin-top: 30px;
}

.edit-btn {
    display: block; /* Change from inline-flex */
    align-items: center; /* No effect with display: block */
    justify-content: center; /* No effect with display: block */
    background: #e67e00; /* Vibrant gradient for header */
    color: var(--text-light);
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center; /* Will center inline content if display: inline-block was used, but margin: auto handles the block itself */
    margin: 5px auto 0 auto; /* Top: 5px, Right: auto, Bottom: 0, Left: auto */
    /* Or simply: margin-top: 5px; margin-left: auto; margin-right: auto; */
    /* Or if you want 5px margin all around except top: margin: 5px auto; */
}

.edit-btn:hover {
      background: #e67e00;/* Reverse gradient on hover */
}

.edit-btn i {
    margin-right: 8px;
    font-size: 18px;
} 


@media (min-width: 1000px) and (max-width: 1100px) {
    .profile-card {
        margin-left: 270px; /* sidebar ki actual width ke hisaab se adjust karein */
        width: calc(100% - 240px); /* sidebar ke width minus card width */
        min-width: 400px; /* card kabhi isse chhota na ho */
        max-width: 600px; /* card bahut zyada na failaaye */
    }
}
@media (max-width: 992px) {
    .profile-card {
        margin-left: 300px; /* if sidebar shrinks */
        width: calc(100% - 210px);
    }
}
@media (max-width: 768px) {
    /* On smaller screens, sidebar stacks on top */
    .profile-card {
        margin-left: auto;
        margin-right: auto;
        width: 95%;
    }
}

/* Responsive Design */
@media (max-width: 600px) {
    .profile-card {
        margin: 15px auto; /* Keep centered */
        border-radius: 12px;
    }
    .card-header {
        height: 160px; /* Adjusted height for smaller screens */
    }
    .profile-img {
        width: 100px;
        height: 100px;
        bottom: -50px;
        border: 5px solid white;
    }
    .card-body {
        /* --- MODIFICATION: INCREASE GAP BETWEEN CIRCLE AND EMAIL FOR SMALLER SCREENS --- */
        padding: 30px 20px;
        padding-top: 70px; /* Adjusted for smaller screens */
    }
    .info-grid {
        gap: 15px; /* Further reduced gap */
        /* --- MODIFICATION: REMOVED MARGIN-BOTTOM AS BUTTON IS REMOVED --- */
        /* margin-bottom: 25px; */
    }
    .info-item {
        padding-bottom: 10px;
        flex-wrap: wrap; /* Allow wrapping on smaller screens */
    }
    .info-item i {
        margin-bottom: 5px; /* Space below icon when stacked */
        margin-right: 10px; /* Keep some right margin when items might wrap */
    }
    .info-label {
        margin-right: 10px; /* Adjust spacing between label and value if needed */
        margin-bottom: 0; /* Ensure no extra margin if label wraps */
    }

    .info-value {
        font-size: 0.95em;
        /* --- MODIFICATION: REDUCE TRAILING SPACE --- */
        /* flex-basis: 0; */ /* Removed. It's not strictly necessary if flex-grow is 0 */
        flex-grow: 0; /* Set to 0 to make it take only required width */
    }
    /* --- MODIFICATION: REMOVE EDIT BUTTON STYLES FOR RESPONSIVE --- */
     .edit-btn {
        padding: 12px 28px;
        font-size: 1.05em;
    } 
    .welcome-text {
        font-size: 1.5em;
        top: 15px; /* Adjust for smaller header */
        left: 15px;
    }
}

@media (max-width: 400px) {
    .user-name {
        font-size: 1.6em;
        margin-bottom: 20px;
    }

    .info-value {
        font-size: 0.9em;
        text-align: left; /* Align value to left when stacked */
        word-break: break-all; /* Allow breaking of long words to fit */
        /* --- MODIFICATION: REDUCE TRAILING SPACE --- */
        flex-grow: 0; /* Ensure it's 0 for smallest screens too */
    }
    /* --- MODIFICATION: REMOVE EDIT BUTTON STYLES FOR RESPONSIVE --- */
    .edit-btn {
        padding: 10px 24px;
        font-size: 0.95em;
    } 
    .welcome-text {
        font-size: 1.2em;
        top: 10px;
        left: 10px;
    }

    .card-body {
        /* --- MODIFICATION: INCREASE GAP BETWEEN CIRCLE AND EMAIL FOR SMALLEST SCREENS --- */
        padding: 25px 15px;
        padding-top: 60px; /* Adjusted for very small screens */
    }
    .info-grid {
        gap: 10px; /* Even smaller gap for very small screens */
        /* --- MODIFICATION: REMOVED MARGIN-BOTTOM AS BUTTON IS REMOVED --- */
        /* margin-bottom: 20px; */
    }
    .info-item {
        flex-direction: column; /* Stack label and value vertically */
        align-items: flex-start;
        padding-bottom: 8px; /* Reduced padding when stacked */
    }
    .info-item i {
        margin-right: 0; /* Remove horizontal margin when stacked */
        margin-bottom: 3px; /* Smaller space below icon when stacked */
    }
    .info-label {
        margin-bottom: 2px; /* Smaller space below label when stacked */
    }
    /* --- MODIFICATION: REMOVE EDIT BUTTON CONTAINER STYLES --- */
     .edit-btn-container {
        margin-top: 25px;
    } 
}
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
                      
 <i class='bx bx-border-all' style="color:white; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="dashboard.html" style="text-decoration: none; color: inherit;">
                        <h3> Dashboard</h3>
</a>
                    </div>

                      <div class="nav-option option2">
 <i class='bx bx-border-all' style="color: var(--Border-color); font-size: 35px; width: 35px; height: 35px;"></i>
                      <a href="form-lead.html" style="text-decoration: none; color: inherit;">
    <h3>Form Leads</h3>
</a>
                    </div>

                     <div class="nav-option option3">
                     <i class='bx bxs-contact' style="color: var(--Border-color); font-size: 35px; width: 35px; height: 35px;"></i>
   <a href="contact-lead.html" style="text-decoration: none; color: inherit;">                    
  <h3>Contact leads</h3>
</a>
                    </div>
                    <div class="nav-option option4">
                        <i class='bx bxs-devices' style="color: var(--Border-color); font-size: 35px; width: 35px; height: 35px;"></i>
  <a href="remark.html" style="text-decoration: none; color: inherit;">                        
 <h3>Remark</h3>
</a>
                    </div>
                    <div class="nav-option option5">
                        <i class='bx bx-reset' style="color: var(--Border-color); font-size: 35px; width: 35px; height: 35px;"></i>
   <a href="password-reset.html" style="text-decoration: none; color: inherit;">                      
  <h3>Password Reset</h3>
</a>
                    </div>
                  

                    <div class="nav-option option6">
                        
<i class='bx bxs-user-pin' style="color: var(--Border-color); font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="profile.html" style="text-decoration: none; color: inherit;">  
                        <h3> Profile</h3>
</a>
                    </div>

                    

                    <div class="nav-option logout">
                      <i class='bx bx-log-out-circle' style="color: var(--Border-color); font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="logout.html" style="text-decoration: none; color: inherit;">  
                        <h3>Logout</h3>
</a>
                    </div>

                </div>
            </nav>
        </div>
 
<div class="profile-card">
    <div class="card-header">
     <div class="profile-img" style="<?php echo $profileCircleStyle; ?>"></div>

      <h2 class="welcome-text">Welcome, <?= htmlspecialchars($name) ?></h2>
    </div>
 
    <div class="card-body">
     
              
        <div class="info-grid">
         
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <span class="info-label">Email Address:</span>
                <span class="info-value"><?php echo htmlspecialchars($email); ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span class="info-label">Address:</span>
                <span class="info-value"><?php echo htmlspecialchars($address); ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <span class="info-label">Contact:</span>
                <span class="info-value"><?php echo htmlspecialchars($contact); ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-briefcase"></i> <span class="info-label">Purpose:</span>
                <span class="info-value"><?php echo htmlspecialchars($purpose); ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-calendar-alt"></i> <span class="info-label">Date of Birth:</span>
                <span class="info-value"><?php echo htmlspecialchars($dob); ?></span>
            </div>

  <div class="info-item">
                <i class="fas fa-globe"></i> 
                  <span class="info-label">Country:</span>
                <span class="info-value"><?php echo htmlspecialchars( $country ); ?></span>
            </div>

  <div class="info-item">
                <i class="fas fa-city">
                </i> <span class="info-label">State:</span>
                <span class="info-value"><?php echo htmlspecialchars( $state ); ?></span>
            </div>


  <div class="info-item">
                <i class="fas fa-user"></i> <span class="info-label">Created Date:</span>
                <span class="info-value"><?php echo htmlspecialchars( $createdate ); ?></span>
            </div>

 <div class="info-item">
                        <a href="profile.php?email=<?php echo urlencode($email); ?>" class="edit-btn">
                            <i class="fas fa-user-edit"></i> EDIT PROFILE
                        </a>
                    </div>
        </div>

    </div>
</div>
</body>
</html>