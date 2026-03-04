<?php
session_start();

// Database connection (Keep this as-is)
$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);

    // **IMPORTANT:** Consider using prepared statements for better security against SQL Injection.
    $sql = "INSERT INTO remarks (name, subject, remark, created_at) 
            VALUES ('$name', '$subject', '$remark', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Remark inserted successfully!'); window.location='view_remarks.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Remark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

   <style>
        /* CSS Variables for Clean Styling */
        :root {
            --primary-color: #007bff; /* A clean blue */
            --accent-color: #28a745; /* Green for success/actions */
            --background-color: #f8f9fa; /* Very light gray */
            --card-background: #ffffff;
            --text-color: #343a40;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Base & Wrapper */
        .wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Use min-height for better content handling */
            padding: 20px;
            box-sizing: border-box;
        }

        /* Form Container (Card) */
        .remark-form {
            background: var(--card-background);
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            width: 100%;
            max-width: 400px; /* Good size for a centered form */
            box-sizing: border-box;
            border: 1px solid #e9ecef; /* Subtle border */
        }

        .remark-form h2 {
            text-align: center;
            color: orange;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Inputs and Textarea */
        .remark-form input,
        .remark-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ced4da; /* Soft border color */
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box; /* Crucial for padding/width calculation */
            transition: border-color 0.3s, box-shadow 0.3s;
            resize: vertical; /* Allow vertical resizing for textarea */
        }

        .remark-form input:focus,
        .remark-form textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25); /* Focus ring effect */
            outline: none;
        }
        
        /* Button */
        .remark-form button {
            /* Using a new accent color for a professional look */
            background: var(--accent-color); 
            border: none;
            padding: 12px 15px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.1s;
        }

        .remark-form button:hover {
            background: #218838; /* Slightly darker green */
        }
        
        .remark-form button:active {
             transform: scale(0.99);
        }

        /* Optional: Small screen adjustment for responsiveness */
        @media (max-width: 480px) {
            .remark-form {
                padding: 20px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
   <header class="header">
        <div class="container">
            <a href="#" class="logo">
                <img src="https://thumbs2.imgbox.com/26/2d/fxicueNg_t.jpg" alt=" ">
                SmartBuild

   </a>
            <nav class="nav-links">
                <a href="home.php"><b>Home</b></a>
               
                <a href="contractorfro.php"><b>Contractors</b></a>
                <a href="material.php"><b>Materials</b></a>
                
                <a href="alllogin.php" class="btn btn-sm btn-outline"><b>Login /Sign up</b></a>
                
            </nav>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>
    <div class="wrapper">
        <form class="remark-form" method="POST">
            <h2>Add Remark 📝</h2>
            <input type="text" name="name" placeholder="Enter Name" required>
            <input type="text" name="subject" placeholder="Enter Subject" required>
            <textarea name="remark" rows="5" placeholder="Enter Remark" required></textarea>
            <button type="submit">Submit Remark</button>
        </form>
    </div>

    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h4>  SmartBuild</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="team.php">Our Team</a></li>
                    <li><a href="ceareer.php">Careers</a></li>
                   
                  
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="home.php">Home Construction</a></li>
                    <li><a href="showpro.php">Commercial Projects</a></li>
                 <li><a href="contractorfro.php">Client Testimonials</a></li>
                 
                </ul>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <ul>
                    
                    <li><a href="material.php">Material Catalog</a></li>
                    <li><a href="guide.php">Building Guides</a></li>
                   
                    <li><a href="remark.php">Help Center</a></li>
                    
                </ul>
            </div>
            <div class="footer-col">
                <h4>Connect With Us</h4>
                <p><i class="fas fa-map-marker-alt"></i> 123  SmartBuild St, Dombivli, MH 421201</p>
                <p><i class="fas fa-phone"></i> <a href="tel:+919876543210">+91 98765 43210</a></p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:info@SmartBuild.com">info@  SmartBuild.com</a></p>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2025   SmartBuild. All rights reserved.</p>
                <ul class="footer-legal-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        // JavaScript for Mobile Navigation Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Optional: Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });

                // Close mobile menu after clicking a link
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                }
            });
        });

        // JavaScript for FAQ Accordion
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.closest('.faq-item');
                faqItem.classList.toggle('active');
                // Optional: Close other open FAQ items
                faqQuestions.forEach(item => {
                    if (item !== question && item.closest('.faq-item').classList.contains('active')) {
                        item.closest('.faq-item').classList.remove('active');
                    }
                });
            });
        });

        // Dynamic Progress Bar for "Track My Work" (Example) - Not directly used in this improved HTML, but kept for reference
        // You would typically update this based on backend data for a real application
        const progressSegment = document.querySelector('.progress-segment'); // This element isn't in the new HTML, but keep the JS if you plan to re-add.
        const progressSteps = document.querySelectorAll('.progress-step'); // Same as above.

        function updateProgressBar(activeStepIndex) {
            if (progressSteps.length > 0) { // Check if elements exist before trying to manipulate them
                progressSteps.forEach((step, index) => {
                    if (index <= activeStepIndex) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });

                const totalSteps = progressSteps.length;
                let percentage = 0;
                if (activeStepIndex >= 0) {
                    percentage = (activeStepIndex / (totalSteps - 1)) * 100;
                }
                if (progressSegment) { // Check if progressSegment exists
                    progressSegment.style.width = `${percentage}%`;
                }
            }
        }

        // Set initial progress (e.g., Work Started is the 3rd step, index 2)
        // You would change this value based on actual project status
        // updateProgressBar(2); // Commented out as the element is not present in the HTML
    </script>
</body>
</html>