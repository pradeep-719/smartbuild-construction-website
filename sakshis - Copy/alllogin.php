<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Role</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">
    <style>
       
/* --- Global Variables (Colors & Shadows) --- */
:root {
    --primary-color: #3498db;  /* User/Customer - Blue */
    --secondary-color: #2ecc71; /* Contractor - Green */
    --tertiary-color: #e74c3c; /* Admin - Red */
    --card-bg: #fff;
    --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.1);
    --font-stack: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* --- Basic Typography and Reset (excluding 'body') --- */
* {
    box-sizing: border-box;
    font-family: var(--font-stack);
}

h1 {
    color: #333;
    margin-bottom: 40px;
    font-size: clamp(1.8em, 4vw, 2.5em); /* Responsive font size */
    text-align: center;
}

/* --- Grid Container for the Cards (Responsive Grid) --- */
.card-grid {
    /* Set up a fluid, responsive grid */
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px; /* Space between the cards */
    max-width: 1100px;
    margin: 40px auto; /* Center the grid container and add vertical space */
    padding: 0 20px; /* Internal padding for smaller screens */
}

/* --- Card Styling --- */
.card {
    background-color: var(--card-bg);
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 30px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    /* Use flex to ensure the content and button align nicely vertically */
    display: flex; 
    flex-direction: column;
    justify-content: space-between;
    min-height: 280px; /* Consistent height for visual balance */
}

.card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.card-title {
    font-size: 1.6em;
    margin-bottom: 10px;
    font-weight: 700;
}

.card-text {
    color: #666;
    margin-bottom: 25px;
    flex-grow: 1; /* Pushes the button to the bottom */
    line-height: 1.5;
}

/* --- Button Styling --- */
.card-button {
    display: inline-block;
    width: 100%;
    padding: 12px;
    border: 2px solid transparent;
    border-radius: 8px;
    font-size: 1.05em;
    font-weight: bold;
    color: white;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* --- Role-Specific Colors and Hover Effects --- */

/* 1. User/Customer */
.card-user .card-title { color:#e67e00; }
.card-user .card-button { background-color: #e67e00; }
.card-user .card-button:hover { 
    background-color: #2980b9; 
    border-color: #2980b9;
    box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
}

/* 2. Contractor */
.card-contractor .card-title { color: var(--secondary-color); }
.card-contractor .card-button { background-color: var(--secondary-color); }
.card-contractor .card-button:hover { 
    background-color: #27ae60; 
    border-color: #27ae60;
    box-shadow: 0 4px 8px rgba(46, 204, 113, 0.4);
}

/* 3. Admin */
.card-admin .card-title { color: var(--tertiary-color); }
.card-admin .card-button { background-color: var(--tertiary-color); }
.card-admin .card-button:hover { 
    background-color: #c0392b; 
    border-color: #c0392b;
    box-shadow: 0 4px 8px rgba(231, 76, 60, 0.4);
}

/* --- Media Query for Forced 3-Column Layout on Very Large Screens --- */
@media (min-width: 900px) {
    .card-grid {
        /* This ensures they stay in a neat 3-column row when there is plenty of space */
        grid-template-columns: repeat(3, 1fr);
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
               
                <a href="contractors.php"><b>Contractors</b></a>
                 <a href="http://localhost/buildsmart-frontend/home.php">Materials</a>
                
                <a href="alllogin.php" class="btn btn-sm btn-outline"><b>Login /Sign up</b></a>
                
            </nav>
            <div class="menu-toggle" id="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <h1>Select Your Role and Continue</h1>

    <div class="card-grid">

        <div class="card card-user">
            <div>
                <h2 class="card-title">User / Customer</h2>
                <p class="card-text">
                    I am looking to browse and purchase products or services. Log in or register here to manage your profile and orders.
                </p>
            </div>
            <a href="index.php" class="card-button">
                User Login / Register
            </a>
        </div>

        <div class="card card-contractor">
            <div>
                <h2 class="card-title">Contractor</h2>
                <p class="card-text">
                    I offer services and need to manage my projects, bids, and profile. Access your contractor dashboard here.
                </p>
            </div>
            <a href="registr.php" class="card-button">
                Contractor Login/ Register
            </a>
        </div>

        <div class="card card-admin">
            <div>
                <h2 class="card-title">Admin</h2>
                <p class="card-text">
                    I am a system administrator. Access the control panel to manage all users, contractors, and system settings.
                </p>
            </div>
            <a href="adminlogin.php" class="card-button">
                Admin Login/ Register
            </a>
        </div>

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