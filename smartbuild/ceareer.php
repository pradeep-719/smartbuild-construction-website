<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers at SmartBuild - Build Your Future With Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

   <style>
        /* Base Styles */
        .careers-page-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #444;
            background-color: #f7f9fc;
        }
        
        /* Header Styling */
        .careers-header {
          
            color: black;
            padding: 60px 20px;
            text-align: center;
        }
        .careers-header h1 {
            margin: 0;
            font-size: 3em;
        }
        .careers-header p {
            font-size: 1.2em;
            margin-top: 10px;
        }

        /* Main Content Area */
        .content-area {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px 0;
        }
        
        h2 {
            color: #e87b00; /* Warm Orange */
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
        }
        
        /* Values/Perks Section - Flexbox for Centering */
        .values-perks-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .perk-item {
            flex-basis: calc(33% - 20px); /* 3 items per row on large screens */
            text-align: center;
            padding: 15px;
            border-left: 3px solid #e87b00;
        }
        .perk-item h3 {
            color: #1a3c58;
            margin-top: 0;
        }

        /* Life at SmartBuild / Culture Section */
        .culture-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 20px;
            text-align: center;
        }
        .culture-item {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }
        .culture-item h3 {
            color: #e87b00;
        }

        /* CTA Button */
        .apply-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #e87b00;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .apply-button:hover {
            background-color: #c96800;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .perk-item {
                flex-basis: calc(50% - 20px); /* 2 items on tablets */
            }
        }
        @media (max-width: 480px) {
            .perk-item {
                flex-basis: 100%; /* 1 item on phones */
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
    <div class="careers-page-wrapper">

        <hea class="careers-header">
            <h1>Build Your Career with SmartBuild</h1>
            <p>Join a team dedicated to excellence, innovation, and community growth in construction and design.</p>
        </hea>

        <div class="content-area">

            <section id="why-join-us">
                <h2>Why Choose SmartBuild?</h2>
                <div class="values-perks-section">
                    <div class="perk-item">
                        <h3>Growth Opportunities</h3>
                        <p>Clear path for professional development and skill enhancement.</p>
                    </div>
                    <div class="perk-item">
                        <h3>Competitive Pay</h3>
                        <p>Industry-leading salaries and comprehensive benefits packages.</p>
                    </div>
                    <div class="perk-item">
                        <h3>Innovative Projects</h3>
                        <p>Work on challenging and cutting-edge residential and commercial builds.</p>
                    </div>
                </div>
            </section>
            
            <hr>

            <section id="life-at-smartbuild">
                <h2>Life at SmartBuild</h2>
                
                <div class="culture-grid">
                    <div class="culture-item">
                        <h3>Team Collaboration</h3>
                        <p>We foster an environment where architects, engineers, and site managers work together transparently to achieve superior results.</p>
                    </div>
                    <div class="culture-item">
                        <h3>Continuous Learning</h3>
                        <p>Access to modern training, seminars, and resources to stay ahead of the curve in sustainable building techniques.</p>
                    </div>
                    <div class="culture-item">
                        <h3>Community Impact</h3>
                        <p>Be a part of building the future of Dombivli and the wider MMR region, seeing your work benefit the local community directly.</p>
                    </div>
                </div>
            </section>
            
            <hr>

            

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