<?php
// ... (Your original PHP code here)
$conn = mysqli_connect("localhost", "root", "", "usersss");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $price = (float)$_POST['price'];
    $rating = (int)$_POST['rating'];

    // Allowed file types and size limit (2MB)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $max_size = 2 * 1024 * 1024; // 2MB

    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_type = mime_content_type($tmp_name);

    // Validate file type
    if (!in_array($file_type, $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, GIF allowed.");
    }

    // Validate file size
    if ($file_size > $max_size) {
        die("File too large. Maximum 2MB allowed.");
    }

    // Create uploads folder if not exists
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    // Sanitize filename and avoid overwriting
    $unique_name = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($img_name));
    $path = "uploads/" . $unique_name;

    if (move_uploaded_file($tmp_name, $path)) {
        $sql = "INSERT INTO materials (name, brand, price, rating, image) 
                VALUES ('$name','$brand','$price','$rating','$path')";
        if (mysqli_query($conn, $sql)) {
            header("Location: material.php"); 
            exit();
        }else {
            echo "Database error: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload image!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="brand" placeholder="Brand" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="rating" min="1" max="5" placeholder="Rating">
        <input type="file" name="image" required>
        <button type="submit">Add Product</button>
    </form>
</body>
</html>