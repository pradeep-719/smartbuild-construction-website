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
$profileImage = ($result && mysqli_num_rows($result) > 0)
    ? mysqli_fetch_assoc($result)['ProfileImage']
    : "";

$profileImageSrc = empty($profileImage)
    ? "https://media.geeksforgeeks.org/wp-content/uploads/20221210180014/profile-removebg-preview.png"
    : $profileImage;

$successMessage = ""; // 🟢 To store popup message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $price = (float)$_POST['price'];
    $rating = (int)$_POST['rating'];
    $page = $_POST['category']; // cement / sand / paints

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $max_size = 2 * 1024 * 1024; // 2MB

    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_type = mime_content_type($tmp_name);

    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, GIF allowed.");
    }
    if ($file_size > $max_size) {
        die("File too large. Maximum 2MB allowed.");
    }

    // ✅ Upload folder in frontend
    $upload_dir = "../buildsmart-frontend/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $unique_name = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($img_name));
    $path = $upload_dir . $unique_name;
    $db_path = "uploads/" . $unique_name;

    if (move_uploaded_file($tmp_name, $path)) {
        // Common materials table insert
        mysqli_query($conn, "INSERT INTO materials (name, brand, price, rating, image) 
                             VALUES ('$name','$brand','$price','$rating','$db_path')");

        // Category-specific insert
        if ($page == 'cement') {
            mysqli_query($conn, "INSERT INTO cement (name, brand, price, rating, image)
                                 VALUES ('$name','$brand','$price','$rating','$db_path')");
        } elseif ($page == 'sand') {
            mysqli_query($conn, "INSERT INTO sand (name, brand, price, rating, image)
                                 VALUES ('$name','$brand','$price','$rating','$db_path')");
        } elseif ($page == 'paints') {
            mysqli_query($conn, "INSERT INTO paints (name, brand, price, rating, image)
                                 VALUES ('$name','$brand','$price','$rating','$db_path')");
        }

        // ✅ Success message
        $successMessage = "Product uploaded successfully!";
    } else {
        echo "Failed to upload image!";
    }
}
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
          href="upls.css">
 
 <style>
        /* CSS starts here */

        /* Target the form itself */
        form {
            /* Center the form horizontally using margin auto */
            margin: 50px auto; /* 50px top/bottom margin, auto left/right for centering */
            width: 90%; /* Take up most of the width */
            max-width: 400px; /* Limit the max width for better readability */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            /* Ensures it is a block element and can be centered */
            display: block; 
        }

        /* Style all direct children of the form to prevent simple inline overlapping */
        form > * {
            /* Make inputs, buttons, and br tags take up full width (block) */
            display: block; 
            margin-bottom: 15px; /* Add space below each element */
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

        /* Style the input fields */
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%; /* Full width within the form */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Style the button */
        button[type="submit"] {
            width: 100%; /* Full width within the form */
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #4cae4c;
        }

        /* Hide the <br> tags since we're using margin-bottom for spacing */
        br {
            display: none;
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
                        
<i class='bx bxs-user-pin' style="color:#e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="feed.php" style="text-decoration: none; color: inherit;">  
                        <h3> User Feedback</h3>
</a>
                    </div>

 <div class="nav-option option8">
                        
<i class='bx bx-upload' style="color:white; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="upl.php" style="text-decoration: none; color: inherit;">  
                        <h3> Upload Product</h3>
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
                      <i class='bx bx-log-out-circle' style="color: #e67e00; font-size: 35px; width: 35px; height: 35px;"></i>
 <a href="logs.php" style="text-decoration: none; color: inherit;">  
                        <h3>Logout</h3>
</a>
                    </div>

                </div>
            </nav>
        </div>

  <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="brand" placeholder="Brand" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="rating" min="1" max="5" placeholder="Rating">
<select name="category" required>
        <option value="" disabled selected>Select Product Page</option>
        <option value="cement">Cement</option>
        <option value="steel">Steel</option>
        <option value="bricks">Bricks</option>
        <option value="tiles">Tiles</option>
        <option value="paint">Paint</option>
        <option value="wood">Wood</option>
        <option value="material">All Materials (General)</option>
    </select>
        <input type="file" name="image" required>
        <button type="submit">Add Product</button>
    </form>



    <script>
let menuicn = document.querySelector(".menuicn");
let nav = document.querySelector(".navcontainer");

menuicn.addEventListener("click", () => {
    nav.classList.toggle("navclose");
})
 </script>
</body>
</html>