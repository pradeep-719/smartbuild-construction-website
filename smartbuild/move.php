<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moving In: Final Handover - SmartBuild</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">

   <style>
        /* CSS Variables for SmartBuild Theme */
        :root {
            --primary-color: #0F4C75; /* Modern Navy/Dark Blue */
            --accent-color: #FF8C00;  /* Burnt Gold/Orange Accent */
            --bg-light: #fdfdfd; /* Updated: Warmer White for inner elements */
            --bg-page: #fafafa; /* Updated: Lightest Gray/Off-White for wrapper */
            --text-dark: #343a40;
            --shadow-subtle: 0 4px 10px rgba(0, 0, 0, 0.08);
        }
        
        /* 1. Global Wrapper & Background */
        .page-wrapper {
            /* NEW BACKGROUND: Subtle Off-White/Lightest Gray */
            background-color: var(--bg-page); 
            min-height: 100vh;
            padding-bottom: 50px;
        }

        /* Main Content Area */
        .content-area {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 0 20px 0;
            text-align: center; 
        }
        
        /* --- Minimal Title Section --- */
        .page-title-block {
            padding: 0 20px 30px 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
        }

        .page-title-block h1 {
            font-size: 3.5em;
            color: var(--primary-color);
            margin: 0 0 5px 0;
            font-weight: 700;
        }
        .page-title-block p {
            font-size: 1.2em;
            color: #6c757d;
            max-width: 900px;
            margin: 0 auto;
        }
        
        h2 {
            color: var(--accent-color); 
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2em;
        }

        /* --- Stepped Process Cards --- */
        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
            text-align: left;
        }

        .step-card {
            background: #fff; /* Cards remain pure white for contrast */
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow-subtle);
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }
        .step-card:hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .step-number {
            font-size: 2.5em;
            font-weight: 900;
            color: var(--accent-color);
            opacity: 0.8;
            line-height: 1;
            margin-bottom: 10px;
            display: inline-block;
            border-bottom: 4px solid var(--primary-color);
            padding-bottom: 5px;
        }

        .step-card h3 {
            color: var(--primary-color);
            font-size: 1.5em;
            margin: 10px 0 10px 0;
        }
        .step-card p {
            color: #555;
            font-size: 0.95em;
        }
        
        /* --- Document List --- */
        .document-list {
            list-style: none;
            padding: 0;
            text-align: center;
            max-width: 800px;
            margin: 20px auto 50px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .document-list li {
            /* Uses the new warmer white for subtle list background */
            background-color: var(--bg-light); 
            border: 1px solid #ddd;
            padding: 15px 20px;
            border-radius: 8px;
            color: var(--primary-color);
            font-weight: 600;
            flex-basis: calc(33% - 20px);
            min-width: 180px;
        }


        /* --- Warranty Block --- */
        .warranty-block {
            background-color: var(--primary-color);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-top: 50px;
            text-align: center;
            box-shadow: var(--shadow-subtle);
        }
        .warranty-block h3 {
            font-size: 2em;
            color: var(--accent-color);
            margin: 0 0 10px 0;
        }
        .warranty-block p {
            font-size: 1.1em;
            max-width: 800px;
            margin: 0 auto 20px auto;
        }
        .warranty-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--accent-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .warranty-button:hover {
            background-color: #cc7000;
        }

        /* Responsive Adjustments */
        @media (max-width: 900px) {
             .document-list li {
                flex-basis: calc(50% - 20px);
            }
        }
        @media (max-width: 768px) {
            .page-title-block h1 {
                font-size: 2.5em;
            }
            .process-steps {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .document-list li {
                flex-basis: 100%;
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


    <div class="page-wrapper">

        <div class="content-area">

            <header class="page-title-block">
                <h1>The Keys to Your New Home</h1>
                <p>Congratulations! We've distilled the final handover into four simple steps, ensuring your move-in is completely seamless and stress-free.</p>
            </header>
            
            <section id="handover-process" style="text-align: left;">
                <h2>Your 4-Step Move-In Journey</h2>
                
                <div class="process-steps">
                    
                    <div class="step-card">
                        <div class="step-number">01</div>
                        <h3>Final Walkthrough & Audit</h3>
                        <p>A joint inspection with your site engineer to confirm 100% completion of the snag list and review all final finishes before documentation begins.</p>
                    </div>

                    <div class="step-card">
                        <div class="step-number">02</div>
                        <h3>Handover of Documents</h3>
                        <p>You receive all necessary legal and technical documentation, including the Occupancy Certificate, as-built drawings, and appliance manuals.</p>
                    </div>

                    <div class="step-card">
                        <div class="step-number">03</div>
                        <h3>Key Exchange & Orientation</h3>
                        <p>The formal exchange of keys, followed by a detailed demonstration of all utility systems, smart features, and operational protocols of the home.</p>
                    </div>

                    <div class="step-card">
                        <div class="step-number">04</div>
                        <h3>Post-Move Support</h3>
                        <p>We activate your 10-year structural warranty and provide an immediate contact for any minor issues during your first 30 days of settling in.</p>
                    </div>
                    
                </div>
            </section>
             <section class="warranty-block">
                <h3>Peace of Mind: Your 10-Year Structural Warranty</h3>
                <p>SmartBuild stands behind every structure we build. Your warranty is effective immediately, covering materials and workmanship for a full decade.</p>
            </section>
            <hr style="border: 0; height: 1px; background: #ddd; margin: 30px 0;">

            <section id="documents-received">
                <h2>Key Documents You Will Receive</h2>
                
                <ul class="document-list">
                    <li>Occupancy Certificate (OC)</li>
                    <li>As-Built Drawings</li>
                    <li>Structural Certificate</li>
                    <li>10-Year Warranty Agreement</li>
                    <li>Utility Transfer Documents</li>
                    <li>Maintenance Guides</li>
                </ul>
            </section>

           

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