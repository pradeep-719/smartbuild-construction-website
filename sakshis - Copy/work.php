<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervising Work - Quality & Oversight - SmartBuild</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="stl.css">
	
	<style>
        /* CSS Variables for SmartBuild Theme (UPDATED COLORS) */
        :root {
            --primary-color: #0F4C75; /* Modern Navy/Dark Blue */
            --accent-color: #FF8C00;  /* Burnt Gold/Orange Accent */
            --bg-light: #f7f9fc;
            --text-dark: #343a40;
            --shadow-subtle: 0 4px 10px rgba(0, 0, 0, 0.08);
            --shadow-deep: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        /* 1. Global Wrapper & Background (Light Gray) */
        .page-wrapper {
            /* Sets the overall background to light gray */
            background-color: #f0f0f0; 
            min-height: 100vh; /* Ensures it covers the entire viewport height */
            padding-bottom: 50px;
        }

        /* Main Content Area */
        .content-area {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto; /* Removed top margin, controlled by page-wrapper padding */
            padding: 20px 0;
            text-align: center; 
        }
        
        /* --- Minimal Title Section --- */
        .page-title-block {
            padding: 30px 20px;
            margin-bottom: 40px;
            border-bottom: 1px solid #ddd;
        }

        .page-title-block h1 {
            font-size: 3em;
            color: var(--primary-color);
            margin: 0 0 5px 0;
            font-weight: 700;
        }
        .page-title-block p {
            font-size: 1.1em;
            color: #6c757d;
            max-width: 900px;
            margin: 0 auto;
        }
        
        h2 {
            color: var(--accent-color); 
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        /* --- Assurance Grid (Responsive by default due to auto-fit) --- */
        .assurance-grid {
            display: grid;
            /* Auto-fit ensures it drops to 1 or 2 columns based on space */
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .assurance-item {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); 
            text-align: center;
            border-top: 4px solid var(--accent-color); 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .assurance-item:hover {
            transform: translateY(-5px); 
            box-shadow: var(--shadow-subtle);
        }

        .assurance-item .icon {
            font-size: 2.5em;
            color: var(--primary-color); 
            margin-bottom: 15px;
            display: block;
        }
        .assurance-item h3 {
            color: var(--primary-color);
            margin-top: 0;
            font-size: 1.4em;
        }
        .assurance-item p {
            font-size: 0.95em;
            color: #6c757d;
        }

        /* --- Timeline Section (Requires Specific Responsive Fixes) --- */
        .timeline {
            position: relative;
            padding: 20px 0;
            max-width: 900px;
            margin: 50px auto;
        }
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: var(--primary-color); 
            top: 0;
            bottom: 0;
            left: 50%; /* Center line on desktop */
            margin-left: -3px;
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -13px;
            background-color: white;
            border: 4px solid var(--accent-color); 
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        /* Left side styles */
        .timeline-left {
            left: 0;
        }
        .timeline-left::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            right: 30px;
            border: medium solid var(--bg-light);
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent var(--bg-light);
        }

        /* Right side styles */
        .timeline-right {
            left: 50%;
        }
        .timeline-right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid var(--bg-light);
            border-width: 10px 10px 10px 0;
            border-color: transparent var(--bg-light) transparent transparent;
        }
        .timeline-right::after {
            left: -12px; /* Position circle for right side */
        }

        .timeline-content {
            padding: 20px 30px;
            background-color: var(--bg-light);
            position: relative;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); 
        }
        .timeline-content h4 {
            color: var(--primary-color);
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }


        /* Call to Action Section */
        .cta-box {
            background-color: #e0e9f4; 
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin-top: 40px;
        }

        .cta-box h3 {
            color: var(--primary-color); 
            margin-top: 0;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--accent-color); 
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.2s;
            margin-top: 15px;
        }
        .cta-button:hover {
            background-color: #cc7000; 
        }

        /* --- Responsive Adjustments (Fixes Timeline for Mobile) --- */
        @media (max-width: 768px) {
            .page-title-block h1 {
                font-size: 2.5em;
            }
            
            /* Timeline changes to a single-column layout */
            .timeline::after {
                left: 31px; /* Move center line to the left */
            }
            .timeline-item {
                width: 100%;
                padding-left: 70px; /* Make room for the line and circle */
                padding-right: 25px;
            }
            .timeline-left { /* Apply left-side styles to all items */
                left: 0;
            }
            .timeline-right { /* Reset right-side specific positioning */
                left: 0;
            }

            /* Fix pointers (left/right are now identical) */
            .timeline-item::before {
                content: " ";
                height: 0;
                position: absolute;
                top: 22px;
                width: 0;
                z-index: 1;
                left: 60px; /* Triangle starts 60px from the left */
                border: medium solid var(--bg-light);
                border-width: 10px 10px 10px 0; /* Ensures triangle points left */
                border-color: transparent var(--bg-light) transparent transparent;
            }

            /* Fix circles (left/right are now identical) */
            .timeline-item::after {
                left: 18px; /* Circle starts 18px from the left, over the line */
                right: auto;
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
                <h1>Supervising Work: Quality & Control</h1>
                <p>Our commitment to rigorous supervision ensures every element of your project meets the highest standards of safety, quality, and precision.</p>
            </header>
        </div>

        <div class="content-area" style="text-align: left;">
            
            <section id="assurance-points">
                <h2>Our Three Pillars of Project Oversight</h2>
                
                <div class="assurance-grid">
                    
                    <div class="assurance-item">
                        <span class="icon">👷</span>
                        <h3>Dedicated Site Engineer</h3>
                        <p>A certified professional manages all day-to-day activities, quality checks, and resource deployment exclusively for your site.</p>
                    </div>

                    <div class="assurance-item">
                        <span class="icon">📱</span>
                        <h3>Daily Digital Reporting</h3>
                        <p>Receive real-time photo and video updates, material consumption reports, and progress tracking via our client portal.</p>
                    </div>

                    <div class="assurance-item">
                        <span class="icon">🔬</span>
                        <h3>Triple-Check Quality Protocol</h3>
                        <p>We implement quality checks at three stages: **material testing**, **in-progress inspection**, and **final audit** before every handover.</p>
                    </div>
                    
                </div>
            </section>
            
            <hr style="border: 0; height: 1px; background: #eee; margin: 50px 0;">

            <section id="supervision-process">
                <h2>The SmartBuild Quality Control Timeline</h2>
                
                <div class="timeline">
                    
                    <div class="timeline-item timeline-left">
                        <div class="timeline-content">
                            <h4>Phase 1: Pre-Construction Planning</h4>
                            <p>Detailed **method statements** are created for key tasks, and all initial materials (cement, steel) are verified with necessary certifications.</p>
                        </div>
                    </div>

                    <div class="timeline-item timeline-right">
                        <div class="timeline-content">
                            <h4>Phase 2: Execution Oversight</h4>
                            <p>Daily structural integrity checks, **labor coordination**, and budget adherence monitoring. Zero tolerance for safety violations.</p>
                        </div>
                    </div>

                    <div class="timeline-item timeline-left">
                        <div class="timeline-content">
                            <h4>Phase 3: Client Inspection Points</h4>
                            <p>Scheduled client visits at major milestones (**foundation, slab casting, final finishes**) for transparency and immediate feedback.</p>
                        </div>
                    </div>

                    <div class="timeline-item timeline-right">
                        <div class="timeline-content">
                            <h4>Phase 4: Post-Completion Audit</h4>
                            <p>Final sign-off by a senior engineer, ensuring all plans are executed perfectly, leading to the 10-year warranty activation.</p>
                        </div>
                    </div>
                    
                </div>
            </section>

            <hr style="border: 0; height: 1px; background: #eee; margin: 50px 0;">

            

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