<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Our Team - SmartBuild Experts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

   <style>
        /* Base Styles */
        .team-page-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #444;
            background-color: #f7f9fc;
        }
        
        /* Header Styling */
        .team-header {
            //background-color: #1a3c58; /* Deep Blue */
           // color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .team-header h1 {
            margin: 0;
            font-size: 2.8em;
        }
        .team-header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        /* Main Content Area Styling - Modified for Centering */
        .content-area {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto; 
            padding: 20px 0;
            
            /* Ensures all children (grid, CTA section) are centered */
            display: flex;
            flex-direction: column;
            align-items: center; 
        }
        
        /* Team Grid - Crucial changes for centering two items */
        .team-grid {
            display: grid;
            /* **KEY CHANGE:** Only 2 columns on large screens */
            grid-template-columns: repeat(2, 1fr); 
            gap: 30px;
            width: 100%; 
            max-width: 800px; /* **KEY CHANGE:** Limiting the max width to naturally center 2 items */
            margin: 0 auto;
        }
        
        /* Team Member Card Styling (No changes needed here) */
        .team-member-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .team-member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        /* Image Styling */
        .member-photo {
            width: 100%;
            height: 350px;
            background-color: #ddd; 
            display: flex; 
            align-items: center;
            justify-content: center;
        }
        .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .member-info {
            padding: 20px 15px;
        }
        .member-info h3 {
            color: #1a3c58;
            margin: 5px 0;
            font-size: 1.5em;
        }
        .member-info p {
            color: #e87b00;
            font-weight: 600;
            margin-bottom: 10px;
            font-style: italic;
        }
        .member-bio {
            font-size: 0.9em;
            color: #666;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 600px) {
            .team-grid {
                /* On small screens, switch to 1 column */
                grid-template-columns: 1fr;
                max-width: 400px; /* Keeps the single card from stretching too wide */
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
    <div class="team-page-wrapper">

        <hea class="team-header">
            <h1>Meet the SmartBuild Experts</h1>
            <p>Our success is driven by our founders, who maintain an unwavering commitment to quality and transparency.</p>
        </hea>

        <div class="content-area">
            
            <div class="team-grid">
                
                <div class="team-member-card">
                    <div class="member-photo">
                        <img src="https://thumbs2.imgbox.com/3b/d7/TW40dqHR_t.png" alt="Sakshi Shahu, Founder & CEO">
                    </div>
                    <div class="member-info">
                        <h3>Sakshi Shahu</h3>
                        <p>Founder & CEO</p>
                        <div class="member-bio">Visionary leader driving SmartBuild's strategic growth and commitment to quality and transparency.</div>
                    </div>
                </div>

                <div class="team-member-card">
                    <div class="member-photo">
                         <img src="https://thumbs2.imgbox.com/c8/14/04QC6lZy_t.jpg" alt="Pradeep Yadav, Senior Project Manager">
                    </div>
                    <div class="member-info">
                        <h3>Pradeep Yadav</h3>
                        <p>Senior Project Manager</p>
                        <div class="member-bio">Expert in logistical planning and site management, ensuring all projects are delivered efficiently and on budget.</div>
                    </div>
                </div>
                
            </div>
            
           
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