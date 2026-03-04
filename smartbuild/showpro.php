<?php
// PHP logic remains the same
$conn = mysqli_connect('localhost', 'root', '', 'usersss');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Recent Projects Gallery - SmartBuild</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

   <style>
        /* --- 1. Global & Variables --- */
:root {
    --primary-color: #1a3c58; /* SmartBuild Deep Blue */
    --accent-color: #e87b00;  /* SmartBuild Warm Orange */
    --bg-light: #f7f9fc;
    --text-dark: #343a40;
    --shadow-subtle: 0 6px 15px rgba(0, 0, 0, 0.1);
}

/* --- 2. Header & Introduction --- */
.gallery-container {
    text-align: center;
    padding: 40px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.gallery-container h2 {
    font-size: 3em; 
    color: var(--primary-color);
    font-weight: 800;
    margin-bottom: 5px;
}

.gallery-container p {
    color: #6c757d;
    font-size: 1.1em;
    margin-bottom: 50px;
    font-style: italic;
}

/* --- 3. Projects Grid Layout (Fixed Three Columns) --- */
.projects {
    display: grid; 
    /* Set exactly three equal-width columns */
    grid-template-columns: repeat(3, 1fr); 
    gap: 30px; 
    
    justify-content: center; 
    margin-top: 20px;
    
    overflow-x: unset; 
    white-space: normal;
    padding-bottom: 0;
}

/* --- 4. Card Styling --- */
.card {
    flex-shrink: initial;
    width: 100%; 
    
    background: #fff;
    border-radius: 16px; 
    /* Multi-layered shadow for premium look */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(0, 0, 0, 0.02);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    /* Brand accent border at the top */
    border-top: 5px solid var(--accent-color); 
}

.card:hover {
    transform: translateY(-8px); 
    /* Enhanced hover shadow */
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.18); 
}

.card img {
    width: 100%;
    height: 220px; 
    object-fit: cover;
    transition: transform 0.5s ease;
}

.card:hover img {
    transform: scale(1.05);
}


.card .content {
    padding: 25px; 
    text-align: left;
    flex-grow: 1;
}

.card .content h3 {
    margin: 0 0 10px 0; 
    color: var(--primary-color);
    font-size: 1.6em; 
    font-weight: 700;
}

.card .content p {
    color: #666;
    font-size: 1em; 
    margin: 0;
}

/* --- 5. Empty State Message --- */
.no-projects {
    padding: 50px;
    background-color: #ffffff;
    border: 2px dashed #ffc107;
    border-radius: 12px;
    margin-top: 30px;
    color: var(--primary-color);
    font-weight: 600;
    text-align: center;
    width: 100%; 
    grid-column: 1 / -1; /* Make it span all columns on larger screens */
}


/* --- 6. Responsive Adjustments --- */
@media (max-width: 992px) {
    .projects {
        /* Change to 2 columns on medium screens (laptops/large tablets) */
        grid-template-columns: repeat(2, 1fr); 
        gap: 20px;
    }
}

@media (max-width: 650px) {
    .projects {
        /* Change to 1 column on small screens (phones) */
        grid-template-columns: 1fr;
        gap: 15px;
    }
    .gallery-container h2 {
        font-size: 2em;
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
<div class="gallery-container">
    <h2>Our Recent Projects Gallery 🏗️</h2>
    <p>Showcasing **SmartBuild** excellence in residential and commercial construction across the MMR region.</p>

    <div class="projects">
        <?php 
        $project_count = 0;
        while ($row = mysqli_fetch_assoc($result)) { 
            $project_count++;
        ?>
            <div class="card">
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?> Image">
                <div class="content">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                </div>
            </div>
        <?php } ?>
        
        <?php if ($project_count === 0) { ?>
            <div class="no-projects">
                <p>No current projects to display. Please add projects to the 'projects' table.</p>
            </div>
        <?php } ?>

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